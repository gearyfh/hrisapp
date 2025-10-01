<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

     protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'employee_id',
        'name',
        'email',
        'password',
        'role',
        'birth_date',
    ];

        public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Hapus employee kalau ada
            $user->employee()->delete();
        });
    }

}
