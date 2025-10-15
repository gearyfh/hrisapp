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
        <div class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Notifikasi</h2>

            <a href="{{ route('notifications.index') }}" 
            class="relative inline-block text-gray-700 hover:text-blue-600 transition">
                <!-- Icon Lonceng -->
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="1.5" 
                    stroke="currentColor" 
                    class="w-7 h-7">
                    <path stroke-linecap="round" 
                        stroke-linejoin="round" 
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V8.25A6.75 6.75 0 005.25 8.25v1.5a8.967 8.967 0 01-2.311 6.022c1.75.66 3.554 1.105 5.454 1.31m6.464 0a24.255 24.255 0 01-6.464 0m6.464 0a3 3 0 11-6.464 0" />
                </svg>

                <!-- Badge jumlah notifikasi -->
                @if($unreadCount ?? 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
        </div>


    </div>

    <!-- History Absensi -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
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
    

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Kolom Kiri -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">History Pengajuan Cuti</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Durasi</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
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
                            <td colspan="3" class="text-center px-4 py-3 text-gray-500">
                                Belum ada data cuti
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">History Pengajuan Izin / Sakit</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Durasi</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
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
                            <td colspan="3" class="text-center px-4 py-3 text-gray-500">
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
