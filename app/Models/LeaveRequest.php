<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestApproval;
use App\Models\LeaveType;

class LeaveRequest extends Model
{
    protected $fillable = [
        'employee_id', 'leave_type_id', 'start_date', 'end_date', 'total_days', 'reason', 'attachment','status','comment','approved_by','approved_at'
    ];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function leaveType() { return $this->belongsTo(LeaveType::class); }

    public function approvals() {
        return $this->morphMany(RequestApproval::class, 'module', 'module_type', 'module_id');
    }
}
