<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
        'company_name'  => 'required|exists:companies,company_name',
        'name'        => 'required|string|max:255',
        'birth_date'  => 'nullable|date',
        'email'       => 'required|email|unique:users,email',
        'password'    => 'required|min:6',
        'role'        => 'required|in:employee,admin,superadmin',
        'status'      => 'nullable|in:active,inactive',
        'address'     => 'nullable|string',
        'phone'       => 'nullable|string',
        'nik'         => [
        'nullable',
        'digits:16', // harus tepat 16 digit jika diisi
        'unique:employees,nik', // harus unique
    ],
        'npwp'        => 'nullable|string',
        'hire_date'   => 'nullable|date',
    ]);

    DB::transaction(function () use ($validated, $request) {
        // 1. Buat user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        // 2. Kalau role employee → buat juga employee
        if ($request->role === 'employee') {
            $company = Company::where('company_name', $validated['company_name'])->first();

            $employee = Employee::create([
                'company_id' => $company->id,
                'user_id'    => $user->id,
                'name'       => $user->name,
                'birth_date' => $validated['birth_date'] ?? null,
                'address'    => $validated['address'] ?? null,
                'nik'        => $validated['nik'] ?? null,
                'npwp'       => $validated['npwp'] ?? null,
                'hire_date'  => $validated['hire_date'] ?? null,
                'status'     => $validated['status'] ?? 'active',
            ]);
        }
    });

    return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
}

     public function edit($id)
    {
        // load user beserta relasi company & employee
            // load user beserta relasi
    $user = User::with('company', 'employee')->findOrFail($id);

    // ambil semua companies buat dropdown
    $companies = \App\Models\Company::all();
    $employee = $user->employee; // bisa null kalau bukan employee
    //dd($user,$employee);
    return view('users.edit', compact('user', 'companies', 'employee'));
}

        public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // $emailRules = ['required', 'email'];

        // if ($request->email !== $user->email) {
        //     $emailRules[] = Rule::unique('users', 'email');
        // }
        // dd($user);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required',
        'email',
        Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'company_name' => 'required|string',
            'role' => 'required|in:employee,admin,superadmin',
            'status' => 'required|in:active,inactive',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'nik' => [
            'nullable',
            'digits:16', // harus tepat 16 angka
            Rule::unique('employees', 'nik')->ignore(optional($user->employee)->id), 
        ],
            'npwp' => 'nullable|string',
            'hire_date' => 'nullable|date',
        ]);

        // ambil company_id dari company_name
        $company = Company::where('company_name', $validated['company_name'])->firstOrFail();

        // update user
        $user->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => $request->filled('password') ? bcrypt($request->password) : $user->password,
            'role'       => $validated['role'],
            'status'     => $validated['status'],
            'company_id' => $company->id,
        ]);

        // kalau role employee, update/insert ke employees
            if ($validated['role'] === 'employee') {
                Employee::updateOrCreate(
                    ['user_id' => $user->id], // share ID dengan users
                    [
                        'company_id' => $company->id,
                        'user_id' => $user->id,
                        'name'       => $validated['name'],
                        'birth_date' => $validated['birth_date'] ?? null,
                        'address'    => $validated['address'] ?? null,
                        'phone'      => $validated['phone'] ?? null,
                        'nik'        => $validated['nik'] ?? null,
                        'npwp'       => $validated['npwp'] ?? null,
                        'hire_date'  => $validated['hire_date'] ?? null,
                        'status'     => $validated['status'],
                    ]
                );
        } else {
            // kalau bukan employee, pastikan tidak ada sisa data employee
            $user->employee()?->delete();
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
