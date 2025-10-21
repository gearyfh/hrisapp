<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeCreateController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $employees = Employee::where('company_id', $companyId)
            ->with('user')
            ->latest()
            ->get();

        return view('admin.employee.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employee.create');
    }

    public function store(Request $request)
    {
       // dd($request->all());
        //try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:20',
            'hire_date' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        $companyId = Auth::user()->company_id;

        // 1️⃣ Buat user baru untuk employee
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'company_id' => $companyId,
        ]);

        // 2️⃣ Buat data employee terkait
        Employee::create([
            'user_id' => $user->id,
            'company_id' => $companyId,
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone' => $request->phone,
            'nik' => $request->nik,
            'npwp' => $request->npwp,
            'hire_date' => $request->hire_date,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.employee.index')->with('success', 'Karyawan berhasil ditambahkan.');
    //     } catch (\Throwable $e) {
    //     dd('ERROR:', $e->getMessage());
    // }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::all();
        return view('admin.employee.edit', compact('employee', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:20',
            'hire_date' => 'nullable|date',
            'status' => 'required|string|in:active,inactive',
        ]);

        $employee->update($validated);

        return redirect()->route('admin.employee.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employee.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }

}
