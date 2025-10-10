<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'deduct_quota',
    ];

    /**
     * Relasi ke LeaveRequest (1 jenis cuti bisa punya banyak pengajuan)
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
