<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrection extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'employee_id',
        'date_in',
        'date_out',
        'old_clock_in',
        'new_clock_in',
        'old_clock_out',
        'new_clock_out',
        'reason',
        'status',
        'comment',
        'approved_by',
        'approved_at',
    ];

    public function attendance()
{
    return $this->belongsTo(Attendance::class);
}

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}


