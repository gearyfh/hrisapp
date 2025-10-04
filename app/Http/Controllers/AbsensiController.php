<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class AbsensiController extends Controller
{
    public function index()
    {
         $employee = Auth::user()->employee;

    if (!$employee) {
        return redirect()->back()->with('error', 'Anda bukan employee!');
    }

    $employeeId = $employee->id;

    // Ambil absensi hari ini
    $attendance = Attendance::where('employee_id', $employeeId)
                    ->whereDate('tanggal', now()->toDateString())
                    ->first();

    // Ambil semua riwayat absensi
    $attendances = Attendance::where('employee_id', $employeeId)
                    ->orderBy('tanggal', 'desc')
                    ->get();

    return view('employees.absensi', compact('attendance', 'attendances'));
    }


public function create()
{
    $employee = Auth::user()->employee;

    if (!$employee) {
        return redirect()->route('employees.absensi')
                         ->with('error', 'Anda bukan employee!');
    }

    // cek kalau sudah check-in hari ini, tidak boleh ke create
    $alreadyCheckedIn = Attendance::where('employee_id', $employee->id)
        ->whereDate('tanggal', now()->toDateString())
        ->exists();

    if ($alreadyCheckedIn) {
        return redirect()->route('employees.absensi')
                         ->with('error', 'Anda sudah check-in hari ini!');
    }

    return view('employees.absensi_create');
}

public function checkin(Request $request)
{
    $employee = Auth::user()->employee;

    if (!$employee) {
        return redirect()->back()->with('error', 'Anda bukan employee!');
    }

    $validated = $request->validate([
        'jenis'   => 'required|in:WFH,WFO',
        'tanggal' => 'required|date',
        'lokasi'  => 'nullable|string|max:255',
    ]);

    // Simpan jam_masuk, jam_keluar masih null
    Attendance::create([
        'employee_id' => $employee->id,
        'jenis'       => $validated['jenis'],
        'tanggal'     => $validated['tanggal'],
        'jam_masuk'   => now()->format('H:i'),
        'lokasi'      => $validated['lokasi'],
    ]);

    return redirect()->route('employees.absensi')->with('success', 'Check-in berhasil!');
}


    // ✅ CHECK OUT
    public function checkout()
    {
        $employee = Auth::user()->employee;
        $today = now()->toDateString();

        $attendance = Attendance::where('employee_id', $employee->id)
                        ->whereDate('tanggal', $today)
                        ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Anda belum check-in hari ini.');
        }

        if ($attendance->jam_keluar) {
            return redirect()->back()->with('error', 'Anda sudah check-out.');
        }

        $attendance->update([
            'jam_keluar' => now()->format('H:i:s'),
        ]);

        return redirect()->route('employees.absensi')->with('success', 'Berhasil check-out!');
    }
}
