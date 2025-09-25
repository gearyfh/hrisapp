<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['company_code','company_name'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id','id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'company_id','id');
    }
}
