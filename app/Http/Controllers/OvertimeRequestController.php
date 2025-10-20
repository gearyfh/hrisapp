<?php

namespace App\Http\Controllers;

use App\Models\OvertimeRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OvertimeRequestController extends Controller
{
    public function index()
    {
        $overtimes = OvertimeRequest::where('employee_id', Auth::user()->employee->id)
            ->latest()
            ->get();

        return view('employees.overtime.index', compact('overtimes'));
    }

    public function selectAttendance()
    {
        $attendances = Attendance::where('employee_id', Auth::user()->employee->id)
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return view('employees.overtime.select', compact('attendances'));
    }

    public function create($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);
        return view('employees.overtime.create', compact('attendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'duration_option' => 'required|numeric',
            'reason' => 'nullable|string|max:255',
        ]);

        $employee = Auth::user()->employee;

        $start = strtotime($request->start_time);
        $durationHours = (float) $request->duration_option;
        $end = date('H:i', $start + ($durationHours * 3600));

        // ✅ gunakan relasi overtimes(), bukan overtimeRequest()
        $employee->overtimeRequest()->create([
            'attendance_id' => $request->attendance_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $end,
            'duration' => $durationHours,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('employees.overtime.index')
            ->with('success', '✅ Pengajuan lembur berhasil dikirim.');
    }
}
