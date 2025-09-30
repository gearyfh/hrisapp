<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List users
    public function index()
    {
        $users = User::with(['company', 'employee'])->get();
        return view('users.index', compact('users'));
    }

    // Show form create
    public function create()
    {
        $companies = Company::all();
        $employees = Employee::all();
        return view('users.create', compact('companies', 'employees'));
    }

    // Store user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'  => 'nullable|exists:companies,company_id',
            'employee_id' => 'nullable|exists:employees,employee_id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
            'role'        => 'required|in:employee,admin,superadmin',
        ]);

        $user = User::create([
            'company_id'  => $validated['company_id'] ?? null,
            'employee_id' => $validated['employee_id'] ?? null,
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
        ]);

            // 2. Jika role employee → buat juga di tabel employees
        if ($validated['role'] === 'employee') {
        $employee = Employee::create([
            'company_id' => $validated['company_id'] ?? null,
            'user_id'    => $user->user_id,   // FK ke users
            'name'       => $validated['name'],
            'status'     => 'active',
        ]);

        // Update user supaya ada relasi employee_id
        $user->update(['employee_id' => $employee->employee_id]);
    }


        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }
}
