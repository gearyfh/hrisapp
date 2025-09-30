@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded p-6">
    <h2 class="text-xl font-bold mb-4">Tambah User Baru</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="block font-semibold">Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Company</label>
            <select name="company_id" class="w-full border rounded p-2">
                <option value="">-- Pilih Company --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Employee</label>
            <select name="employee_id" class="w-full border rounded p-2">
                <option value="">-- Pilih Employee --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->employee_id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Role</label>
            <select name="role" class="w-full border rounded p-2">
                <option value="employee">Employee</option>
                <option value="admin">Admin</option>
                <option value="superadmin">Super Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>      

        <a href="{{ route('users.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                Cancel
            </a>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>
@endsection
