@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6 space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-500 mt-1">
                Selamat datang, 
                <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> 👋  
                <span class="text-gray-400">Anda login sebagai</span> 
                <span class="font-semibold text-indigo-600">Administrator</span>
            </p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-xl p-5 flex justify-between items-center shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div>
                <h2 class="text-sm opacity-80">Total Pegawai</h2>
                <p class="text-4xl font-semibold mt-1">{{ \App\Models\Employee::count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl p-5 flex justify-between items-center shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div>
                <h2 class="text-sm opacity-80">Total Absensi Hari Ini</h2>
                <p class="text-4xl font-semibold mt-1">{{ \App\Models\Attendance::whereDate('tanggal_masuk', now())->count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl p-5 flex justify-between items-center shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div>
                <h2 class="text-sm opacity-80">Pengajuan Pending</h2>
                <p class="text-4xl font-semibold mt-1">{{ \App\Models\LeaveRequest::where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fa-solid fa-hourglass-half text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Data Absensi -->
    <div class="bg-white rounded-xl shadow-sm p-6 transition hover:shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock text-indigo-600"></i> Data Absensi Pegawai
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold">Check In</th>
                        <th class="px-4 py-3 text-left font-semibold">Check Out</th>
                        <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse ($attendances as $absen)
                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium">{{ $absen->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $absen->tanggal_masuk }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_keluar ?? '-' }}</td>
                            <td class="px-4 py-3">{{ ucfirst($absen->jenis) ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500 italic">Belum ada data absensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Data Pengajuan -->
    <div class="bg-white rounded-xl shadow-sm p-6 transition hover:shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-envelope-open-text text-indigo-600"></i> Pengajuan Cuti / Izin / Sakit
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold">Durasi</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse ($leaves as $leave)
                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium">{{ $leave->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $leave->leaveType->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                            <td class="px-4 py-3">{{ $leave->total_days }} hari</td>
                            <td class="px-4 py-3">
                                @if($leave->status === 'pending')
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                @elseif($leave->status === 'approved')
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">Disetujui</span>
                                @else
                                    <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-medium">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 flex space-x-2">
                                @if($leave->status === 'pending')
                                    <form action="{{ route('admin.approvals.approve', $leave->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-medium transition">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.approvals.reject', $leave->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1 rounded-full text-xs font-medium transition">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500 italic">Belum ada pengajuan cuti atau izin</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
