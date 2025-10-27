<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Attendance;
use App\Models\OvertimeRequest;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;   
use App\Helpers\ActivityLogger;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Pastikan hanya admin yang boleh masuk
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda bukan admin!');
        }

        // Ambil semua absensi dan cuti pegawai
        $attendances = Attendance::with('employee')
            ->orderBy('tanggal_masuk', 'desc')
            ->take(10)
            ->get();

        $leaves = LeaveRequest::with(['employee', 'leaveType'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin', compact('attendances', 'leaves'));
    }


// public function indexTotalAbsensi(Request $request)
// {
//     // ambil parameter
//     $month = $request->input('month') ?? now()->format('Y-m');
//     $search = $request->input('search');
//     $sort = $request->input('sort');

//     // boundary tanggal bulan
//     $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth()->toDateString();
//     $end   = Carbon::createFromFormat('Y-m', $month)->endOfMonth()->toDateString();

//     // ambil employees with relations (lazy load attendances/overtimes per employee)
//     $employees = \App\Models\Employee::all();

//     $rekap = collect();

//     foreach ($employees as $employee) {
//         // ambil attendances dari DB untuk bulan tersebut (query langsung)
//         $attendances = $employee->attendances()
//             ->whereBetween('tanggal_masuk', [$start, $end])
//             ->get();

//         // jumlah hari kerja (jumlah record attendances)
//         $hariKerja = $attendances->count();

//         // jam kerja dihitung dari kolom work_hours (yang sudah diisi saat checkout)
//         $jamKerja = (float) $attendances->sum(function ($a) {
//             return (float) ($a->work_hours ?? 0);
//         });

//         // total lembur (approved) untuk bulan tersebut, query langsung
//         $jamLembur = $employee->overtimeRequests()
//             ->where('status', 'approved')
//             ->whereBetween('date', [$start, $end])
//             ->sum('duration');

//         $totalJam = $jamKerja + (float) $jamLembur;

//         $rekap->push([
//             'employee_id'     => $employee->id,
//             'nama'            => $employee->name ?? $employee->nama ?? '-',
//             'hari_kerja'      => $hariKerja,
//             'jam_kerja'       => round($jamKerja, 2),
//             'jam_lembur'      => round($jamLembur, 2),
//             'total_jam'       => round($totalJam, 2),
//         ]);
//     }

//     // -------- apply search ----------
//     if ($search) {
//         $rekap = $rekap->filter(function ($item) use ($search) {
//             return stripos($item['nama'], $search) !== false;
//         })->values(); // reset keys
//     }

//     // -------- apply sort ----------
//     if ($sort === 'name_asc') {
//         $rekap = $rekap->sortBy('nama')->values();
//     } elseif ($sort === 'name_desc') {
//         $rekap = $rekap->sortByDesc('nama')->values();
//     } elseif ($sort === 'hours_desc') {
//         $rekap = $rekap->sortByDesc('total_jam')->values();
//     } elseif ($sort === 'hours_asc') {
//         $rekap = $rekap->sortBy('total_jam')->values();
//     }

//     // kirim ke view
//     return view('admin.data.absensi.index', [
//         'rekap' => $rekap,
//         'month' => $month,
//         'search' => $search,
//         'sort' => $sort,
//     ]);
// }



// }
