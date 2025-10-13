<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;   

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
}
