@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Employee Dashboard</h1>

    <p class="text-gray-600 mb-6">
        Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span> 👋
    </p>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Absensi Hari Ini -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Absensi Hari Ini</h2>
            <p class="text-gray-600 mb-4">
                Status: <span class="font-bold text-green-600">Belum Check In</span>
            </p>
            <a href="{{ route('employees.absensi_create') }}" 
                <button type="submit"
                    class="bg-black text-white px-6 py-2 rounded w-full hover:bg-gray-800">
                    Check In
                </button>
            </a>
        </div>

        <!-- Sisa Cuti -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Sisa Cuti</h2>
            <p class="text-4xl font-bold text-blue-600">{{ $remainingLeave ?? 12 }}</p>
            <p class="text-gray-600">hari tersisa</p>
        </div>

        <!-- Info / Notifikasi -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Info Terbaru</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-2">
                <li>Slip gaji bulan September sudah tersedia</li>
                <li>Pengajuan cuti Anda sedang diproses</li>
            </ul>
        </div>
    </div>

    <!-- History Absensi -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">History Absensi</h2>
        
        <table class="w-full border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-left">Tanggal</th>
                    <th class="border p-2 text-left">Check In</th>
                    <th class="border p-2 text-left">Check Out</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2"></td>
                    <td class="border p-2"></td>
                    <td class="border p-2"></td>
                </tr>
                <tr>
                    <td colspan="3" class="border p-2 text-center text-gray-500">Belum ada data absensi</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
