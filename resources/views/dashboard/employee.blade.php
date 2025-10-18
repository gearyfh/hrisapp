@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Employee Dashboard</h1>
            <p class="text-gray-500 mt-2">
                Selamat datang, <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span> 👋
            </p>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <!-- Absensi Hari Ini -->
        <div class="relative bg-gradient-to-r from-orange-400 to-orange-500 text-white rounded-2xl p-6 shadow-lg overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-lg font-semibold mb-2">Absensi Hari Ini</h2>
                
                @if(!$attendance)
                    <p class="text-sm mb-4">
                        Status: <span class="font-bold">Belum Check In</span>
                    </p>
                    <form action="{{ route('employees.absensi_create') }}" method="GET">
                        @csrf
                        <button type="submit" class="border border-white text-white px-5 py-2 rounded-full hover:bg-white hover:text-orange-600 transition text-sm font-medium">
                            Check In
                        </button>
                    </form>
                @else
                    <p class="text-sm mb-4">
                        Status: <span class="font-bold">Sudah Check In</span>
                    </p>
                    <button type="button" class="border border-white text-white px-5 py-2 rounded-full opacity-60 cursor-not-allowed text-sm font-medium">
                        Check In
                    </button>
                @endif
            </div>
            <div class="absolute right-4 bottom-2 opacity-25">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-20 h-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Sisa Cuti -->
        <div class="relative bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl p-6 shadow-lg overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-lg font-semibold mb-2">Sisa Cuti</h2>
                <p class="text-4xl font-bold">{{ $remainingLeave ?? 12 }}</p>
                <p class="text-sm mt-1">hari tersisa</p>
            </div>
            <div class="absolute right-4 bottom-2 opacity-25">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-20 h-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-9 4h6m-9 4h10" />
                </svg>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="relative bg-gradient-to-r from-sky-400 to-sky-500 text-white rounded-2xl p-6 shadow-lg overflow-hidden flex justify-between items-start">
            <div class="relative z-10">
                <h2 class="text-lg font-semibold">Notifikasi</h2>
                <p class="text-sm mt-1">Cek notifikasi terbaru kamu</p>
            </div>
            <a href="{{ route('notifications.index') }}" class="relative z-10 text-white hover:text-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.657A4.5 4.5 0 0112 18.75a4.5 4.5 0 01-2.857-1.093m5.714 0A4.478 4.478 0 0012 15.75c-1.126 0-2.158.413-2.857 1.093m5.714 0L18 21m-6-3.75L6 21m6-18v1.5M3 9l1.5 1.5M21 9l-1.5 1.5" />
                </svg>
                @if($unreadCount ?? 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

            <div class="absolute right-4 bottom-2 opacity-25">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-20 h-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
        </div>
    </div>

    <!-- History Absensi -->
    <div class="bg-white shadow hover:shadow-lg transition rounded-2xl p-6 mb-8 border border-gray-100 mt-10">
        <h2 class="text-lg font-semibold mb-4 flex items-center gap-2 text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 012 2h2a2 2 0 012-2m-6 0H5m14 0h-2" />
            </svg>
            History Absensi
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-100 rounded-lg overflow-hidden text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Check In</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-100">
                    @forelse ($attendances as $absen)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-3">{{ $absen->tanggal_masuk }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_masuk }}</td>
                            <td class="px-4 py-3">{{ $absen->jenis }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-4 py-3 text-gray-400">
                                Belum ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- History Cuti & Izin/Sakit -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow hover:shadow-lg transition rounded-2xl p-6 border border-gray-100">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">History Pengajuan Cuti</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-100 rounded-lg overflow-hidden text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                            <th class="px-4 py-3 border-b text-left font-semibold">Durasi</th>
                            <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-100">
                        @forelse ($leaves as $leave)
                            @if($leave->leaveType->type === 'cuti')
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-3">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                                    <td class="px-4 py-3">{{ $leave->total_days }} hari</td>
                                    <td class="px-4 py-3">{{ $leave->leaveType->name ?? '-' }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3" class="text-center px-4 py-3 text-gray-400">
                                    Belum ada data cuti
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white shadow hover:shadow-lg transition rounded-2xl p-6 border border-gray-100">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">History Pengajuan Izin / Sakit</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-100 rounded-lg overflow-hidden text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                            <th class="px-4 py-3 border-b text-left font-semibold">Durasi</th>
                            <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-100">
                        @forelse ($leaves as $leave)
                            @if($leave->leaveType->type === 'izin_sakit')
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-3">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                                    <td class="px-4 py-3">{{ $leave->total_days }} hari</td>
                                    <td class="px-4 py-3">{{ $leave->leaveType->name ?? '-' }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3" class="text-center px-4 py-3 text-gray-400">
                                    Belum ada data izin/sakit
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
