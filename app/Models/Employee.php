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

}
