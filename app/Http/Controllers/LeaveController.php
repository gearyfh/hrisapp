<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    /**
     * Daftar semua pengajuan cuti/izin/sakit milik user login
     */
    public function index()
    {
        // Pastikan foreign key sesuai (user_id)
        $leaves = LeaveRequest::with('leaveType')
            ->where('employee_id', Auth::id())
            ->latest()
            ->get();

        return view('leave.index', compact('leaves'));
    }

    public function indexSick()
    {
        // Pastikan foreign key sesuai (user_id)
        $leaves = LeaveRequest::with('leaveType')
            ->where('employee_id', Auth::id())
            ->latest()
            ->get();

        return view('sick.index', compact('leaves'));
    }

    /**
     * Form pengajuan cuti
     */
    public function createCuti()
    {
        $leaveTypes = LeaveType::where('type', 'cuti')->get();
        return view('leave.createcuti', compact('leaveTypes'));
    }

    /**
     * Form pengajuan izin/sakit
     */
    public function createIzinSakit()
    {
        $leaveTypes = LeaveType::where('type', 'izin_sakit')->get();
        return view('sick.createsick', compact('leaveTypes'));
    }

    /**
     * Simpan pengajuan cuti / izin / sakit
     */
    public function store(Request $request)
{
    $request->validate([
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $employeeId = Auth::id();

    // 🔍 Cek bentrok tanggal
    $hasOverlap = LeaveRequest::where('employee_id', $employeeId)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($q) use ($request) {
                      $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                  });
        })
        ->exists();

    if ($hasOverlap) {
        return back()->withErrors([
            'date' => 'Tanggal yang diajukan sudah digunakan pada pengajuan sebelumnya.'
        ])->withInput();
    }

    // 🔍 Jika izin/sakit, cek lampiran
    $leaveType = LeaveType::find($request->leave_type_id);
    if (strtolower($leaveType->name) === 'sakit' && !$request->hasFile('attachment')) {
        return back()->withErrors([
            'attachment' => 'Lampiran wajib diunggah untuk izin atau sakit.'
        ])->withInput();
    }

    // Hitung durasi hari
    $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400 + 1;

    // Simpan data
    LeaveRequest::create([
        'employee_id' => $employeeId,
        'leave_type_id' => $request->leave_type_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'total_days' => $days,
        'reason' => $request->reason,
        'attachment' => $request->file('attachment') ? $request->file('attachment')->store('attachments', 'public') : null,
    ]);

    if (strtolower($leaveType->name) === 'sakit' || strtolower($leaveType->name) === 'izin pribadi') {
        return redirect()->route('sick.index')->with('success', 'Pengajuan berhasil dikirim.');
    } else {
        return redirect()->route('leave.index')->with('success', 'Pengajuan berhasil dikirim.');
    }
}

    public function detail($id)
{
    $leave = LeaveRequest::with(['leaveType', 'employee'])->findOrFail($id);

    // Pastikan hanya employee yang punya hak bisa lihat datanya
    if ($leave->employee_id !== Auth::id()) {
        abort(403, 'Unauthorized access.');
    }

    return view('leave.detail', compact('leave'));
}

public function detailSick($id)
{
    $leave = LeaveRequest::with(['leaveType', 'employee'])->findOrFail($id);

    // Validasi agar hanya pemilik data yang bisa lihat
    if ($leave->employee_id !== Auth::id()) {
        abort(403, 'Unauthorized access.');
    }

    return view('sick.detail', compact('leave'));
}


}
