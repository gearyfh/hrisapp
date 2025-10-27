<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'jenis',
        'tanggal_masuk',
        'tanggal_keluar',
        'jam_masuk',
        'jam_keluar',
        'lokasi',
        'work_hours',
        'is_corrected',
    ];

        public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function corrections()
{
    return $this->hasMany(AttendanceCorrection::class, 'attendance_id');
}
protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            if ($attendance->jam_masuk && $attendance->jam_keluar) {
                $start = Carbon::parse($attendance->jam_masuk);
                $end = Carbon::parse($attendance->jam_keluar);
                $attendance->work_hours = $start->floatDiffInHours($end);
            }
        });
}


}


