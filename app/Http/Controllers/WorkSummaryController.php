<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\WorkSummary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkSummaryController extends Controller
{


    public function index(Request $request)
{
    $month = $request->month ?? now()->format('Y-m');
    $year = \Carbon\Carbon::parse($month)->year;
    $bulan = \Carbon\Carbon::parse($month)->month;

    $query = WorkSummary::with('employee')
        ->where('month', $bulan)
        ->where('year', $year);

    // ✅ Search by employee name
    if ($request->search) {
        $query->whereHas('employee', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    // ✅ Sorting
    if ($request->sort === 'name_asc') {
        $query->join('employees', 'employees.id', '=', 'work_summaries.employee_id')
              ->orderBy('employees.name', 'asc');
    } elseif ($request->sort === 'name_desc') {
        $query->join('employees', 'employees.id', '=', 'work_summaries.employee_id')
              ->orderBy('employees.name', 'desc');
    } elseif ($request->sort === 'hours_desc') {
        $query->orderByRaw('(total_work_hours + total_overtime_hours) DESC');
    } elseif ($request->sort === 'hours_asc') {
        $query->orderByRaw('(total_work_hours + total_overtime_hours) ASC');
    }

    $rekap = $query->paginate(10);

    return view('admin.data.absensi.index', compact('rekap', 'month'));
}


    public function updateSummary(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');
        $year = Carbon::parse($month)->year;
        $bulan = Carbon::parse($month)->month;

        $employees = Employee::with('attendances', 'overtimeRequests')
                    ->whereHas('attendances')
                    ->orWhereHas('overtimeRequests')
                    ->get();

        foreach ($employees as $employee) {

            $attendances = $employee->attendances()
                ->whereMonth('tanggal_masuk', $bulan)
                ->whereYear('tanggal_masuk', $year)
                ->get();

                //dd($attendances->pluck(['id', 'tanggal_masuk', 'jam_masuk', 'jam_keluar', 'work_hours']));

            // foreach ($attendances as $att) {
            //     dd($att->work_hours);
            // }     

            $hari_kerja = $attendances->count();
            //dd($attendances, $hari_kerja);

            // ✅ Hitung ulang work_hours jika masih 0
            $jam_kerja = $attendances->map(function ($att) {
                if ($att->jam_masuk && $att->jam_keluar) {
                    $start = Carbon::parse($att->jam_masuk);
                    $end = Carbon::parse($att->jam_keluar);
                    $diff = $start->diffInMinutes($end) / 60;
                    return round($diff, 2);
                }
                return $att->work_hours ?? 0;
            })->sum();

            $jam_lembur = $employee->overtimeRequests()
                ->where('status', 'approved')
                ->whereMonth('date', $bulan)
                ->whereYear('date', $year)
                ->sum('duration');
            //dd($jam_kerja,$jam_lembur);

            WorkSummary::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'month' => $bulan,
                    'year' => $year,
                ],
                [
                    'work_days' => $hari_kerja,
                    'work_hours' => $jam_kerja,
                    'overtime_hours' => $jam_lembur,
                    'total_hours' => $jam_kerja + $jam_lembur
                ]
            );
        }

        return back()->with('success', 'Work Summary berhasil diperbarui!');
    }
}
