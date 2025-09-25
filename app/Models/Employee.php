<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
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
        return $this->hasOne(User::class, 'employee_id');
    }
}
