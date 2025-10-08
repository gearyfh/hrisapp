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
            @if(!$attendance)
            <p class="text-gray-600 mb-4">
                Status: <span class="font-bold text-red-600">Belum Check In</span>
            </p>
            <form action="{{ route('employees.absensi_create') }}" method="GET">
                @csrf
                <button type="submit" class="bg-black text-white px-6 py-2 rounded w-full hover:bg-gray-800"">
                    Check In
                </button>
            </form>
            @else
                <p class="text-gray-600 mb-4">
                    Status: <span class="font-bold text-green-600">Sudah Check In</span>
                </p>
            @csrf
                <button type="submit" class="bg-gray-500 text-white px-6 py-2 rounded w-full cursor-not-allowed">
                    Check In
                </button>
            @endif
            {{-- <a href="{{ route('employees.absensi_create') }}" 
                <button type="submit"
                    class="bg-black text-white px-6 py-2 rounded w-full hover:bg-gray-800">
                    Check In
                </button>
            </a> --}}
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

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Check In</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse ($attendances as $absen)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-3">{{ $absen->tanggal_masuk }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_masuk }}</td>
                            <td class="px-4 py-3">{{ $absen->jenis }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-4 py-3 text-gray-500">
                                Belum ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
