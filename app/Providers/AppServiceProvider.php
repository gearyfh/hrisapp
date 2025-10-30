<?php

namespace App\Providers;

use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use App\Models\AttendanceCorrection;
use Illuminate\Support\Facades\View;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot():void
    {
        //
        View::composer('*', function ($view) {
        // 🔹 Pending Cuti
        $pendingCuti = LeaveRequest::where('status', 'pending')
            ->whereHas('leaveType', fn($q) => $q->where('type', 'cuti'))
            ->count();

        // 🔹 Pending Izin/Sakit
        $pendingSakit = LeaveRequest::where('status', 'pending')
            ->whereHas('leaveType', fn($q) => $q->where('type', 'izin_sakit'))
            ->count();

        // 🔹 Pending Koreksi Absensi
        $pendingKoreksi = AttendanceCorrection::where('status', 'pending')->count();

        // 🔹 Pending Lembur
        $pendingLembur = OvertimeRequest::where('status', 'pending')->count();

        // Kirim ke semua view
        $view->with(compact(
            'pendingCuti',
            'pendingSakit',
            'pendingKoreksi',
            'pendingLembur'
        ));
    });
    }
}
