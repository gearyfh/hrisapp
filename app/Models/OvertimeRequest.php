<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestApproval;

class OvertimeRequest extends Model
{
    protected $fillable = [
        'employee_id', 'date', 'start_time', 'end_time', 'total_hours', 'reason', 'status'
    ];

    public function employee() { return $this->belongsTo(Employee::class); }

    public function approvals() {
        return $this->morphMany(RequestApproval::class, 'module', 'module_type', 'module_id');
    }
}

