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

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label class="block font-semibold">Nama</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter name" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter email" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="block font-semibold">Password</label>
            <input type="password" name="password" id="password"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter new password (leave blank to keep current)">
        </div>

        {{-- Company --}}
        <select name="company_name" class="w-full border rounded p-2" required>
            <option value="">-- Pilih Company --</option>
            @foreach($companies as $company)
                <option value="{{ $company->company_name }}" 
                    {{ old('company_name', $user->company->company_name ?? '') == $company->company_name ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
            @endforeach
        </select>


        {{-- Role --}}
        <select id="role" name="role" class="w-full border rounded p-2" required>
            <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}>Employee</option>
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
        </select>


        {{-- Status --}}
        <select name="status" class="w-full border rounded p-2">
            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>


        {{-- Bagian khusus Employee --}}
        <div id="employee-fields" class="hidden">
            {{-- Birth Date --}}
            <div class="mb-3">
                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                <input type="date" name="birth_date" id="birth_date"
                   value="{{ old('birth_date', $employee->birth_date) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter birth date" required>
            </div>

            {{-- Address --}}
                <div class="mb-3">
                    <label class="block font-semibold">Alamat</label>
                    <textarea name="address" class="w-full border rounded p-2">{{ old('address', $employee->address) }}</textarea>
                </div>

            {{-- Phone --}}
            <div class="mb-3">
                <label class="block font-semibold">No. Telepon</label>
                <input type="text" name="phone" id="phone"
                   value="{{ old('phone', $employee->phone) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter phone number" required>
            </div>

            {{-- NIK --}}
            <div class="mb-3">
                <label class="block font-semibold">NIK</label>
                <input type="text" name="nik" id="nik"
                   value="{{ old('nik', $employee->nik) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter NIK">
            </div>

            {{-- NPWP --}}
            <div class="mb-3">
                <label class="block font-semibold">NPWP</label>
                <input type="text" name="npwp" id="npwp"
                   value="{{ old('npwp', $employee->npwp) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter NPWP">
            </div>

            {{-- Hire Date --}}
            <div class="mb-3">
                <label class="block font-semibold">Tanggal Masuk</label>
                <input type="date" name="hire_date" id="hire_date"
                   value="{{ old('hire_date', $employee->hire_date) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   placeholder="Enter hire date" required>
            </div>
        </div>

        {{-- Buttons --}}
        <a href="{{ route('users.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
            Cancel
        </a>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
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

document.addEventListener('DOMContentLoaded', function () {
    let roleSelect = document.getElementById('role');
    let employeeFields = document.getElementById('employee-fields');
    if (roleSelect.value === 'employee') {
        employeeFields.classList.remove('hidden');
    } else {
        employeeFields.classList.add('hidden');
    }
});

</script>
@endsection
