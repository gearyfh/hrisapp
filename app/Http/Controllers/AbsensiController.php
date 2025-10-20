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

        // Ambil absensi aktif (belum checkout)
        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereNull('jam_keluar')
            ->latest()
            ->first();

        // Ambil semua riwayat absensi
        $attendances = Attendance::where('employee_id', $employeeId)
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return view('employees.attendance.absensi', compact('attendance', 'attendances'));
    }

    // 🔹 BALIKIN CREATE UNTUK FORM absensi_create.blade.php
    public function create()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('employees.attendance.absensi')
                             ->with('error', 'Anda bukan employee!');
        }

        // Cek apakah masih ada absensi aktif (belum checkout)
        $active = Attendance::where('employee_id', $employee->id)
            ->whereNull('jam_keluar')
            ->first();

        if ($active) {
            return redirect()->route('employees.attendance.absensi')
                             ->with('error', 'Anda masih punya absensi aktif, silakan checkout dulu!');
        }

        return view('employees.attendance.absensi_create');
    }

    // 🔹 PROSES CHECK-IN
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

        return redirect()->route('employees.attendance.absensi')->with('success', 'Check-in berhasil!');
    }

    // 🔹 PROSES CHECK-OUT
    public function checkout()
    {
        $employee = Auth::user()->employee;

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('tanggal_masuk', now()->toDateString())
            ->whereNull('jam_keluar')
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Anda belum check-in hari ini.');
        }

        $attendance->update([
            'tanggal_keluar' => now()->format('Y-m-d'),
            'jam_keluar'     => now()->format('H:i:s'),
        ]);

        return redirect()->route('employees.attendance.absensi')->with('success', 'Check-out berhasil!');
    }
}
