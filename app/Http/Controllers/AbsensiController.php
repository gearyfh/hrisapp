<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ActivityLogger;
use App\Models\Attendance;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'Anda bukan employee!');
        }

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereNull('jam_keluar')
            ->latest()
            ->first();

        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return view('employees.attendance.absensi', compact('attendance', 'attendances'));
    }

    public function create()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('employees.attendance.absensi')
                             ->with('error', 'Anda bukan employee!');
        }

        $active = Attendance::where('employee_id', $employee->id)
            ->whereNull('jam_keluar')
            ->first();

        if ($active) {
            return redirect()->route('employees.attendance.absensi')
                             ->with('error', 'Anda masih punya absensi aktif, silakan checkout dulu!');
        }

        return view('employees.attendance.absensi_create');
    }

    public function checkin(Request $request)
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'Anda bukan employee!');
        }

        $validated = $request->validate([
            'jenis'   => 'required|in:WFH,WFO',
            'lokasi'  => 'nullable|string|max:255',
        ]);

        Attendance::create([
            'employee_id'   => $employee->id,
            'jenis'         => $validated['jenis'],
            'tanggal_masuk' => now()->format('Y-m-d'),
            'jam_masuk'     => now()->format('H:i:s'),
            'lokasi'        => $validated['lokasi'],
        ]);

        ActivityLogger::log('checkin', 'Attendance', $attendance->id ?? null, 'User melakukan check-in');

        return redirect()->route('employees.attendance.absensi')->with('success', 'Check-in berhasil!');
    }

    public function checkout()
{
    $employee = Auth::user()->employee;

    $attendance = Attendance::where('employee_id', $employee->id)
        ->whereNull('jam_keluar')
        ->latest()
        ->first();

    if (!$attendance) {
        return redirect()->back()->with('error', 'Tidak ada absensi aktif untuk di-checkout.');
    }

    // 🔹 Gabungkan tanggal dan jam agar bisa hitung lintas hari
    $jamMasuk = Carbon::createFromFormat('Y-m-d H:i:s', "{$attendance->tanggal_masuk} {$attendance->jam_masuk}");
    $jamKeluar = Carbon::now();

    // 🔹 Hitung selisih jam (boleh lintas hari)
    $selisihMenit = $jamKeluar->diffInMinutes($jamMasuk);
    $selisihJam = $selisihMenit / 60;

    // 🔹 Terapkan aturan kerja sesuai permintaan kamu
    if ($selisihJam >= 9) {
        $workHours = 8; // kerja penuh
    } elseif ($selisihJam < 8) {
        $workHours = max($selisihJam - 1, 0); // potong 1 jam istirahat
    } else {
        $workHours = $selisihJam; // kalau pas di antara 8–9 jam, pakai jam sebenarnya
    }

    // 🔹 Update data absensi
    $attendance->update([
        'tanggal_keluar' => $jamKeluar->format('Y-m-d'),
        'jam_keluar'     => $jamKeluar->format('H:i:s'),
        'work_hours'     => round($workHours, 2),
    ]);

    ActivityLogger::log('checkout', 'Attendance', $attendance->id, 'User melakukan check-out');

    return redirect()->route('employees.attendance.absensi')->with('success', 'Check-out berhasil!');
}


}
