<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class EmployeeController extends Controller
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

           $leaves = LeaveRequest::with('leaveType')
            ->where('employee_id', $employeeId)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.employee', compact('attendance', 'attendances', 'leaves'));


    }

    public function show_document($id)
    {
        $employee = Employee::with('documents')->findOrFail($id);
        return view('employees.show_documents', compact('employee'));
    }

    public function rekap(Request $request)
{
    $employee = Auth::user()->employee;

$totalHours = $employee->getTotalWorkingHours();
    $month = $request->get('month', now()->month);
    $year = $request->get('year', now()->year);

    $rekap = $employee->getTotalWorkingHours($month, $year);

    return view('admin.data.absensi.index', compact('rekap', 'month', 'year'));
}

}
