<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@mail.com',
        'password' => Hash::make('12345'),
        'role' => 'superadmin',
        ]);

    User::create([
        'name' => 'Admin',
        'email' => 'admin@mail.com',
        'password' => Hash::make('12345'),
        'role' => 'admin',
        'company_id' => 1
    ]);

    Employee::create([
        'company_id' => 1,
        'name' => 'Employee One',
        'birth_date' => '2000-01-01',
        'nik' => '123456789',
        'hire_date' => now(),
    ]);

    User::create([
        'name' => 'Employee User',
        'email' => 'employee@mail.com',
        'password' => Hash::make('12345'),
        'role' => 'employee',
        'company_id' => 1,
        'employee_id' => 1
    ]);


    }
}
