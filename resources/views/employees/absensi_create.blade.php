@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center mt-[10%]">
    <div class="w-full max-w-md bg-gray-100 p-8 rounded-lg shadow-lg ">
        <h1 class="text-2xl font-bold mb-6 text-center">Form Absensi</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="" method="POST" class="space-y-4">
            @csrf

            {{-- Jenis Absensi (WFH / WFO) --}}
            <div>
                <label class="block font-medium mb-1">Jenis Absensi</label>
                <select name="jenis" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
                    <option value="">-- Pilih --</option>
                    <option value="WFO">Work From Office (WFO)</option>
                    <option value="WFH">Work From Home (WFH)</option>
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block font-medium mb-1">Tanggal</label>
                <input type="date" name="tanggal" 
                       value="{{ old('tanggal', \Carbon\Carbon::now()->toDateString()) }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- Jam --}}
            <div>
                <label class="block font-medium mb-1">Jam</label>
                <input type="time" name="jam"
                       value="{{ old('jam', \Carbon\Carbon::now()->format('H:i')) }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="block font-medium mb-1">Lokasi</label>
                <input type="text" name="lokasi" placeholder="Masukkan lokasi anda"
                       value="{{ old('lokasi') }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between">
                <a href="{{ route('employees.absensi') }}"
                   class="bg-gray-500 text-white px-5 py-2 rounded-full hover:bg-gray-600 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-green-600 text-white px-5 py-2 rounded-full hover:bg-green-700 transition">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
