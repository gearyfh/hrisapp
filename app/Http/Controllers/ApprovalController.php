<?php

namespace App\Http\Controllers;

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

        return view('admin.approvals.cutiindex', compact('requests'));
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

        return view('admin.approvals.izinindex', compact('requests'));
    }

    /** 
     * Detail pengajuan CUTI 
     */
    public function showCuti($id)
    {
        $leave = LeaveRequest::with(['employee', 'leaveType'])->findOrFail($id);

        return view('admin.approvals.cutishow', compact('leave'));
    }

    /** 
     * Detail pengajuan IZIN / SAKIT 
     */
    public function showIzinSakit($id)
    {
        $leave = LeaveRequest::with(['employee', 'leaveType'])->findOrFail($id);

        return view('admin.approvals.izinshow', compact('leave'));
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
}
