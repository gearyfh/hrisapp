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
        return $this->hasMany(Attendance::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'employee_id');
    }

    public function overtimeRequests()
    {
        return $this->hasMany(OvertimeRequest::class);
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

        // ✅ Jumlah total work_hours dari attendance
        $attendanceHours = $this->attendances()
            ->whereYear('tanggal_masuk', $year)
            ->whereMonth('tanggal_masuk', $month)
            ->sum('work_hours');

        // ✅ Hitung total lembur yang disetujui
        $overtimeHours = $this->overtimeRequests()
            ->where('status', 'approved')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('duration');

        return [
            'attendance_hours' => $attendanceHours ?? 0,
            'overtime_hours' => $overtimeHours ?? 0,
            'total_hours' => ($attendanceHours ?? 0) + ($overtimeHours ?? 0),
        ];
    }
}
