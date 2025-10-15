<?php

namespace App\Http\Controllers;

use App\Models\OvertimeRequest;
use App\Models\AttendanceCorrection;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /** 
     * Tampilkan semua pengajuan izin/cuti/sakit 
     */
    public function index()
    {
        $requests = LeaveRequest::with(['employee', 'leaveType'])
            ->orderBy('status', 'asc')
            ->latest()
            ->get();

        return view('admin.approvals.index', compact('requests'));
    }

    /** 
     * Halaman pengajuan CUTI 
     */
    public function cuti()
    {
        $requests = LeaveRequest::with(['employee', 'leaveType'])
            ->whereHas('leaveType', fn($q) => $q->where('type', 'cuti'))
            ->orderBy('status', 'asc')
            ->latest()
            ->get();

        return view('admin.approvals.cuti.index', compact('requests'));
    }

    /** 
     * Halaman pengajuan IZIN / SAKIT 
     */
    public function izinSakit()
    {
        $requests = LeaveRequest::with(['employee', 'leaveType'])
            ->whereHas('leaveType', fn($q) => $q->whereIn('type', ['izin', 'sakit', 'izin_sakit']))
            ->orderBy('status', 'asc')
            ->latest()
            ->get();

        return view('admin.approvals.izin.index', compact('requests'));
    }

    /** 
     * Detail pengajuan CUTI 
     */
    public function showCuti($id)
    {
        $leave = LeaveRequest::with(['employee', 'leaveType'])->findOrFail($id);

        return view('admin.approvals.cuti.show', compact('leave'));
    }

    /** 
     * Detail pengajuan IZIN / SAKIT 
     */
    public function showIzinSakit($id)
    {
        $leave = LeaveRequest::with(['employee', 'leaveType'])->findOrFail($id);

        return view('admin.approvals.izin.show', compact('leave'));
    }

    /** 
     * Update status (approved / rejected)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'comment' => 'nullable|string|max:255',
        ]);

        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'status' => $request->status,
            'comment' => $request->comment,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Arahkan sesuai jenis pengajuan
        if ($leave->leaveType->type === 'cuti') {
            return redirect()->route('admin.approvals.cuti')
                ->with('success', '✅ Status pengajuan cuti berhasil diperbarui.');
        }

        return redirect()->route('admin.approvals.izin_sakit')
            ->with('success', '✅ Status pengajuan izin/sakit berhasil diperbarui.');
    }

    /** 
     * Approve langsung (opsional jika tidak pakai update)
     */
    public function approve(Request $request, $id)
    {
        $request->validate(['comment' => 'nullable|string|max:500']);

        $leave = LeaveRequest::findOrFail($id);
        $leave->update([
            'status' => 'approved',
            'comment' => $request->comment,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', '✅ Pengajuan telah disetujui.');
    }

    /** 
     * Reject langsung (opsional jika tidak pakai update)
     */
    public function reject(Request $request, $id)
    {
        $request->validate(['comment' => 'nullable|string|max:500']);

        $leave = LeaveRequest::findOrFail($id);
        $leave->update([
            'status' => 'rejected',
            'comment' => $request->comment,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('error', '❌ Pengajuan telah ditolak.');
    }

    public function correctionIndex()
    {
        $corrections = AttendanceCorrection::with('employee')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->get();

        return view('admin.approvals.corrections.index', compact('corrections'));
    }

    /** 
     * Detail pengajuan koreksi absensi
     */
    public function correctionShow($id)
    {
        $correction = AttendanceCorrection::with('employee')->findOrFail($id);
        return view('admin.approvals.corrections.show', compact('correction'));
    }

    /** 
     * Update status koreksi absensi (approve/reject)
     */
   public function correctionUpdate(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'comment' => 'nullable|string|max:500',
    ]);

    $correction = AttendanceCorrection::with('attendance')->findOrFail($id);

    $correction->update([
        'status' => $request->status,
        'comment' => $request->comment,
        'approved_by' => Auth::id(),
        'approved_at' => now(),
    ]);

    /** 
     * Jika koreksi disetujui, update tabel attendance
     */
    if ($request->status === 'approved' && $correction->attendance) {
        $attendance = $correction->attendance;

        $attendance->update([
            'tanggal_masuk' => $correction->new_date_in ?? $attendance->tanggal_masuk,
            'tanggal_keluar' => $correction->new_date_out ?? $attendance->tanggal_keluar,
            'jam_masuk' => $correction->new_clock_in ?? $attendance->jam_masuk,
            'jam_keluar' => $correction->new_clock_out ?? $attendance->jam_keluar,
            'is_corrected' => true, // Kolom tambahan di tabel attendances
        ]);
    }

    return redirect()->route('admin.corrections.index')
        ->with('success', '✅ Status koreksi absensi berhasil diperbarui.');
}

public function overtimeIndex()
{
    $overtimes = OvertimeRequest::with('employee')
        ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
        ->latest()
        ->get();

    return view('admin.approvals.overtimes.index', compact('overtimes'));
}

public function overtimeShow($id)
{
    $overtime = OvertimeRequest::with('employee')->findOrFail($id);
    return view('admin.approvals.overtimes.show', compact('overtime'));
}

public function overtimeUpdate(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'comment' => 'nullable|string|max:255',
    ]);

    $overtime = OvertimeRequest::findOrFail($id);

    $overtime->update([
        'status' => $request->status,
        'comment' => $request->comment,
        'approved_by' => Auth::id(),
        'approved_at' => now(),
    ]);

    return redirect()->route('admin.overtimes.index')
        ->with('success', '✅ Status pengajuan lembur berhasil diperbarui.');
}


}
