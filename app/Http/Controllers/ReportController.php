<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function indexTotalAbsensi(Request $request)
    {
        // Pastikan variabel $month selalu ada
        $month = $request->input('month') ?? now()->format('Y-m');

        // Tentukan awal dan akhir bulan berdasarkan input
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // Ambil semua employee beserta attendance & overtime mereka
        $employees = Employee::with(['attendances', 'overtimeRequests'])->get();

        $rekap = [];

        foreach ($employees as $employee) {
            // Filter data attendance sesuai bulan
            $attendances = $employee->attendances
                ->whereBetween('tanggal_masuk', [$start->toDateString(), $end->toDateString()]);

            // Hitung total jam kerja (dari work_hours)
            $totalWorkHours = $attendances->sum(function ($a) {
                return (float) ($a->work_hours ?? 0);
            });

            $hari_kerja = $attendances->count();

            // Hitung total lembur (approved only)
            $totalOvertime = $employee->overtimeRequests()
                ->where('status', 'approved')
                ->whereBetween('date', [$start, $end])
                ->sum('duration');
            // dd($totalOvertime, $employee->overtimeRequests()->where('status', 'approved')->pluck('date'));           


            // Tambahkan ke array rekap
            $rekap[] = [
                'nama' => $employee->name ?? '-',
                'hari_kerja' => $hari_kerja,
                'jam_kerja' => $totalWorkHours,
                'jam_lembur' => $totalOvertime,
                'total_jam' => $totalWorkHours + $totalOvertime,
            ];
        }

        return view('admin.data.absensi.index', compact('rekap', 'month'));
    }
}
    