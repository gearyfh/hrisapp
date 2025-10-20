<?php

namespace App\Http\Controllers;

use App\Models\OvertimeRequest;
use App\Models\AttendanceCorrection;
use App\Models\LeaveRequest;
use App\Helpers\NotificationHelper;

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

        $employeeId = $leave->employee_id;
        $title = $request->status === 'approved' ? 'Pengajuan Diterima ✅' : 'Pengajuan Ditolak ❌';
        $message = "Pengajuan {$leave->leaveType->name} kamu dari {$leave->start_date} hingga {$leave->end_date} telah {$request->status}.";
        NotificationHelper::send($employeeId, $title, $message);

        if ($leave->leaveType->type === 'cuti') {
            return redirect()->route('admin.approvals.cuti')
                ->with('success', '✅ Status pengajuan cuti berhasil diperbarui.');
        }

        return redirect()->route('admin.approvals.izin_sakit')
            ->with('success', '✅ Status pengajuan izin/sakit berhasil diperbarui.');
    }

    /**
     * Approve langsung
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

        $employeeId = $leave->employee_id;
        $title = $request->status === 'approved' ? 'Pengajuan Diterima ✅' : 'Pengajuan Ditolak ❌';
        $message = "Pengajuan {$leave->leaveType->name} kamu dari {$leave->start_date} hingga {$leave->end_date} telah {$request->status}.";
        NotificationHelper::send($employeeId, $title, $message);

        return back()->with('success', '✅ Pengajuan telah disetujui.');
    }

    /**
     * Reject langsung
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

        $employeeId = $leave->employee_id;
        $title = $request->status === 'approved' ? 'Pengajuan Diterima ✅' : 'Pengajuan Ditolak ❌';
        $message = "Pengajuan {$leave->leaveType->name} kamu dari {$leave->start_date} hingga {$leave->end_date} telah {$request->status}.";
        NotificationHelper::send($employeeId, $title, $message);

        return back()->with('error', '❌ Pengajuan telah ditolak.');
    }

    /**
     * Daftar koreksi absensi
     */
    public function correctionIndex()
    {
        $corrections = AttendanceCorrection::with('employee')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->get();

        return view('admin.approvals.corrections.index', compact('corrections'));
    }

    /**
     * Detail koreksi absensi
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

        // Jika koreksi disetujui, update data absensi
        if ($request->status === 'approved' && $correction->attendance) {
            $attendance = $correction->attendance;
            $attendance->update([
                'tanggal_masuk' => $correction->new_date_in ?? $attendance->tanggal_masuk,
                'tanggal_keluar' => $correction->new_date_out ?? $attendance->tanggal_keluar,
                'jam_masuk' => $correction->new_clock_in ?? $attendance->jam_masuk,
                'jam_keluar' => $correction->new_clock_out ?? $attendance->jam_keluar,
                'is_corrected' => true,
            ]);
        }

        $employeeId = $correction->employee_id;
        $title = $request->status === 'approved' ? 'Koreksi Absensi Diterima ✅' : 'Koreksi Absensi Ditolak ❌';
        $message = "Pengajuan koreksi absensi kamu untuk tanggal {$correction->old_date} telah {$request->status}.";
        NotificationHelper::send($employeeId, $title, $message);


        return redirect()->route('admin.corrections.index')
            ->with('success', '✅ Status koreksi absensi berhasil diperbarui.');
    }

    /**
     * Daftar pengajuan lembur
     */
    public function overtimeIndex()
    {
        $overtimes = OvertimeRequest::with('employee')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->get();

        return view('admin.approvals.overtimes.index', compact('overtimes'));
    }

    /**
     * Detail lembur
     */
    public function overtimeShow($id)
    {
        $overtime = OvertimeRequest::with('employee', 'attendance')->findOrFail($id);
        return view('admin.approvals.overtimes.show', compact('overtime'));
    }

    /**
     * Update status lembur (approve/reject)
     */
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

        $employeeId = $overtime->employee_id;
        $title = $request->status === 'approved' ? 'Lembur Disetujui ✅' : 'Lembur Ditolak ❌';
        $message = "Pengajuan lembur kamu pada {$overtime->date} telah {$request->status}.";
        NotificationHelper::send($employeeId, $title, $message);

        return redirect()->route('admin.overtimes.index')
            ->with('success', '✅ Status pengajuan lembur berhasil diperbarui.');
    }
}
