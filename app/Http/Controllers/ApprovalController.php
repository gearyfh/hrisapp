<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        // ambil semua pengajuan cuti/izin/sakit yang belum disetujui
        $requests = LeaveRequest::with(['employee', 'leaveType'])
            ->orderBy('status', 'asc')
            ->latest()
            ->get();

        return view('admin.approvals.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'note' => 'nullable|string|max:255',
        ]);

        $leave = LeaveRequest::findOrFail($id);
        $leave->status = $request->status;
        $leave->save();

        return redirect()->route('admin.approvals.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
