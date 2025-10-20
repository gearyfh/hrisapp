<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\OvertimeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthlyReport(Request $request)
    {
        $employee = Auth::user()->employee;
        $month = $request->month ?? now()->format('Y-m');

        // Ambil awal dan akhir bulan
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = Carbon::parse($month . '-01')->endOfMonth();

        // Ambil semua attendance bulan itu
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('tanggal_masuk', [$start, $end])
            ->get();

        // Hitung lembur yang approved
        $overtimes = OvertimeRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->whereBetween('date', [$start, $end])
            ->sum('duration');

        // Hitung total jam kerja
        $totalDays = $attendances->count();
        $totalWorkHours = ($totalDays * 8) + $overtimes;

        return view('employees.reports.monthly', compact('month', 'totalDays', 'totalWorkHours', 'overtimes'));
    }
}
