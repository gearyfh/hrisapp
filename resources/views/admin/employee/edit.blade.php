@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Edit Data Karyawan</h2>

    <form action="{{ route('admin.employee.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Perusahaan</label>
            <select name="company_id" class="w-full border-gray-300 rounded-lg">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $company->id == $employee->company_id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Nama</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded-lg" value="{{ old('name', $employee->name) }}">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Alamat</label>
            <input type="text" name="address" class="w-full border-gray-300 rounded-lg" value="{{ old('address', $employee->address) }}">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Nomor HP</label>
            <input type="text" name="phone" class="w-full border-gray-300 rounded-lg" value="{{ old('phone', $employee->phone) }}">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.employee.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Simpan</button>
        </div>
    </form>
</div>
@endsection
