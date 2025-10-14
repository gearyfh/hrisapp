<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceCorrectionController extends Controller
{
    /** ===========================
     *  EMPLOYEE SIDE
     *  =========================== */
    public function myCorrections()
    {
        $corrections = AttendanceCorrection::where('employee_id', Auth::user()->employee->id)
            ->latest()
            ->get();

        return view('employees.corrections.index', compact('corrections'));
    }

    public function selectAttendance()
{
    $attendances = Attendance::where('employee_id', Auth::user()->employee->id)
        ->orderByDesc('tanggal_masuk')
        ->get();

    return view('employees.corrections.select', compact('attendances'));
}

    public function create($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);

        return view('employees.corrections.create', compact('attendance'));
    }

    public function store(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:attendances,id',
        'new_date_in' => 'nullable|date',
        'new_date_out' => 'nullable|date',
        'new_clock_in' => 'nullable|date_format:H:i',
        'new_clock_out' => 'nullable|date_format:H:i',
        'reason' => 'nullable|string|max:500',
    ]);

    $employeeId = Auth::user()->employee->id;

    // 🧩 Cek apakah sudah pernah mengajukan koreksi untuk attendance ini
    $existingCorrection = AttendanceCorrection::where('attendance_id', $request->attendance_id)
        ->where('employee_id', $employeeId)
        ->latest()
        ->first();

    // 🛑 Jika sudah pernah dan belum ditolak, tolak pengajuan baru
    if ($existingCorrection && $existingCorrection->status !== 'rejected') {
        return back()->with('error', '❌ Anda sudah mengajukan koreksi untuk absensi ini. Tunggu keputusan admin sebelum mengajukan lagi.');
    }

    $attendance = Attendance::findOrFail($request->attendance_id);

    if (
        empty($request->new_date_in) &&
        empty($request->new_date_out) &&
        empty($request->new_clock_in) &&
        empty($request->new_clock_out)
    ) {
        return back()
            ->withInput()
            ->withErrors(['message' => '❌ Minimal satu perubahan (tanggal atau jam) harus diisi.']);
    }

   AttendanceCorrection::create([
        'attendance_id' => $attendance->id,
        'employee_id' => Auth::user()->employee->id,
        'date_in' => $attendance->tanggal_masuk, // tanggal dasar
        'date_out' => $attendance->tanggal_keluar, // tanggal dasar
        'old_clock_in' => $attendance->jam_masuk,
        'old_clock_out' => $attendance->jam_keluar,

        // Kalau field baru kosong → ambil nilai lama
        'new_clock_in' => $request->new_clock_in ?: $attendance->jam_masuk,
        'new_clock_out' => $request->new_clock_out ?: $attendance->jam_keluar,
        'new_date_in' => $request->new_date_in ?: $attendance->tanggal_masuk,
        'new_date_out' => $request->new_date_out ?: $attendance->tanggal_keluar,

        'reason' => $request->reason,
        'status' => 'pending',
    ]);

    return redirect()->route('employees.corrections.index')
        ->with('success', 'Pengajuan koreksi absensi berhasil dikirim.');
}

public function show($id)
{
    $correction = AttendanceCorrection::with(['attendance', 'employee.user'])
        ->findOrFail($id);

    // Pastikan hanya pemilik koreksi yang bisa melihat
    if ($correction->employee_id !== Auth::user()->employee->id) {
        abort(403, 'Tidak diizinkan melihat pengajuan ini.');
    }

    return view('employees.corrections.show', compact('correction'));
}


//     /** ===========================
//      *  ADMIN SIDE
//      *  =========================== */
//     public function index()
//     {
//         $corrections = AttendanceCorrection::with('employee')
//             ->orderBy('status', 'asc')
//             ->latest()
//             ->get();

//         return view('admin.corrections.index', compact('corrections'));
//     }

//     public function show($id)
//     {
//         $correction = AttendanceCorrection::with('employee')->findOrFail($id);
//         return view('admin.corrections.show', compact('correction'));
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'status' => 'required|in:approved,rejected',
//             'comment' => 'nullable|string|max:255',
//         ]);

//         $correction = AttendanceCorrection::findOrFail($id);
//         $correction->update([
//             'status' => $request->status,
//             'comment' => $request->comment,
//             'approved_by' => Auth::id(),
//             'approved_at' => now(),
//         ]);

//         if ($request->status === 'approved') {
//             $attendance = Attendance::where('employee_id', $correction->employee_id)
//                 ->whereDate('date', $correction->date)
//                 ->first();

//             if ($attendance) {
//                 $attendance->update([
//                     'clock_in' => $correction->new_clock_in ?? $attendance->clock_in,
//                     'clock_out' => $correction->new_clock_out ?? $attendance->clock_out,
//                 ]);
//             }
//         }

//         return redirect()->route('admin.corrections.index')
//             ->with('success', 'Koreksi absensi berhasil diperbarui.');
//     }
}
