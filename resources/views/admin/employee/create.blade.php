@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6 mt-8">

    {{-- 🔔 Alert Error --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Terjadi kesalahan!</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ Alert Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block">{{ session('success') }}</span>
        </div>
    @endif

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Karyawan</h1>

    <form action="{{ route('admin.employee.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Lahir --}}
        <div>
            <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('birth_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Alamat --}}
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea name="address" id="address" rows="2"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
            @error('address')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Telepon --}}
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('phone')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- NIK --}}
        <div>
            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
            <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('nik')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- NPWP --}}
        <div>
            <label for="npwp" class="block text-sm font-medium text-gray-700">NPWP</label>
            <input type="text" name="npwp" id="npwp" value="{{ old('npwp') }}"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('npwp')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Masuk --}}
        <div>
            <label for="hire_date" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
            <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date') }}"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('hire_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                class="border border-gray-300 rounded-lg w-full p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
