<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestApproval;

class AttendanceCorrection extends Model
{
    protected $fillable = [
        'employee_id', 'date', 'old_clock_in', 'new_clock_in', 'old_clock_out', 'new_clock_out', 'reason', 'status'
    ];

    public function employee() { return $this->belongsTo(Employee::class); }

    public function approvals() {
        return $this->morphMany(RequestApproval::class, 'module', 'module_type', 'module_id');
    }
}

