@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded p-6">
    <h2 class="text-xl font-bold mb-4">Tambah User Baru</h2>

    @if ($errors->any())
    <div class="bg-red-200 text-red-800 p-2 rounded mb-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label class="block font-semibold">Nama</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="block font-semibold">Password</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>

        {{-- Company --}}
        <div class="mb-3">
            <label class="block font-semibold">Company</label>
            <select name="company_name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
                <option value="">-- Pilih Company --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label class="block font-semibold">Role</label>
            <select id="role" name="role" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
                <option value="employee">Employee</option>
                <option value="admin">Admin</option>
                <option value="superadmin">Super Admin</option>
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="block font-semibold">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>    

        {{-- Bagian khusus Employee --}}
        <div id="employee-fields" class="hidden">
            {{-- Birth Date --}}
            <div class="mb-3">
                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                <input type="date" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none  " id="birth_date" name="birth_date">
            </div>

            {{-- Address --}}
            <div class="mb-3">
                <label class="block font-semibold">Alamat</label>
                <textarea name="address" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
            </div>

            {{-- Phone --}}
            <div class="mb-3">
                <label class="block font-semibold">No. Telepon</label>
                <input type="text" name="phone" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- NIK --}}
            <div class="mb-3">
                <label class="block font-semibold">NIK</label>
                <input type="text" name="nik" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- NPWP --}}
            <div class="mb-3">
                <label class="block font-semibold">NPWP</label>
                <input type="text" name="npwp" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            {{-- Hire Date --}}
            <div class="mb-3">
                <label class="block font-semibold">Tanggal Masuk</label>
                <input type="date" name="hire_date" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
        </div>

        {{-- Buttons --}}
                <div class="flex justify-end space-x-3">
            <a href="{{ route('users.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                Cancel
            </a>
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
                Create
            </button>
        </div>

{{-- Script untuk toggle --}}
<script>
document.getElementById('role').addEventListener('change', function () {
    let employeeFields = document.getElementById('employee-fields');
    if (this.value === 'employee') {
        employeeFields.classList.remove('hidden');
    } else {
        employeeFields.classList.add('hidden');
    }
});

// Trigger awal saat halaman load
document.addEventListener('DOMContentLoaded', function () {
    let roleSelect = document.getElementById('role');
    let employeeFields = document.getElementById('employee-fields');
    if (roleSelect.value === 'employee') {
        employeeFields.classList.remove('hidden');
    }
});
</script>
@endsection
