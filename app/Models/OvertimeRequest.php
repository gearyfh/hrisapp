<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'reason',
        'status',
        'comment',
        'approved_by',
        'approved_at',
    ];

    /**
     * Hitung durasi lembur otomatis sebelum disimpan
     */
    protected static function booted()
    {
        static::saving(function ($overtime) {
            if ($overtime->start_time && $overtime->end_time) {
                $start = strtotime($overtime->start_time);
                $end = strtotime($overtime->end_time);

                // hitung jam lembur dalam jam desimal
                $hours = round(($end - $start) / 3600, 2);
                $overtime->duration = max($hours, 0);
            }
        });
    }

    /** 🔗 Relasi ke employee */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /** 🔗 Relasi ke attendance (absensi harian) */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    /** 🔗 Relasi ke user yang menyetujui (admin/hrd) */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
