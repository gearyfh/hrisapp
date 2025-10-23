<?php

namespace App\Http\Controllers;

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

     public function indexTotalAbsensi()
    {
        
        // Ambil semua karyawan beserta relasi attendance dan lembur
        $employees = Employee::with(['attendances', 'overtimeRequests'])->get();

        // Buat array rekap
        $rekap = $employees->map(function ($employee) {
            return [
                'nama' => $employee->name,
                'total_absen' => $employee->attendances->count(),
                'total_lembur' => $employee->overtimeRequests()->where('status', 'approved')->sum('duration'),
                'total_jam_kerja' => $employee->getTotalWorkingHours(),
            ];
        });


        return view('admin.data.absensi.index', compact('rekap'));
    }
}
