<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

        public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
