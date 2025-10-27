<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'company_id',
        'user_id',
        'name',
        'birth_date',
        'address',
        'phone',
        'nik',
        'npwp',
        'hire_date',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function attendances()
{
    return $this->hasMany(Attendance::class, 'employee_id', 'id');
}

public function overtimeRequests()
{
    return $this->hasMany(OvertimeRequest::class, 'employee_id', 'id');
}


    public function documents()
    {
        return $this->hasMany(Document::class, 'employee_id');
    }


    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function attendanceCorrection()
    {
        return $this->hasMany(AttendanceCorrection::class);
    }

    /**
     * 🔹 Hitung total jam kerja berdasarkan work_hours di tabel attendance
     */
    public function getTotalWorkingHours($month = null, $year = null)
{
    $month = $month ?? now()->month;
    $year = $year ?? now()->year;

    $attendanceHours = $this->attendances()
        ->whereYear('tanggal_masuk', $year)
        ->whereMonth('tanggal_masuk', $month)
        ->get()
        ->sum(function ($item) {
            if ($item->work_hours == 0 && $item->jam_masuk && $item->jam_keluar) {
                $in = strtotime($item->jam_masuk);
                $out = strtotime($item->jam_keluar);
                return max(($out - $in) / 3600, 0);
            }
            return $item->work_hours;
        });

    $overtimeHours = $this->overtimeRequests()
        ->where('status', 'approved')
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->sum('duration');

    return [
        'attendance_hours' => $attendanceHours,
        'overtime_hours' => $overtimeHours,
        'total_hours' => $attendanceHours + $overtimeHours,
    ];
}
}
