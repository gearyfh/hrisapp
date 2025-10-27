<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSummary extends Model
{
    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'work_days',
        'work_hours',
        'overtime_hours',
        'total_hours',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
