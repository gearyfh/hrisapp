@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <p class="text-gray-600 mb-6">
        Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span> 👋  
        Anda login sebagai <span class="font-semibold text-blue-600">Administrator</span>
    </p>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Total Pegawai</h2>
            <p class="text-4xl font-bold text-blue-600">{{ \App\Models\Employee::count() }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Total Absensi Hari Ini</h2>
            <p class="text-4xl font-bold text-green-600">{{ \App\Models\Attendance::whereDate('tanggal_masuk', now())->count() }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Pengajuan Pending</h2>
            <p class="text-4xl font-bold text-yellow-600">{{ \App\Models\LeaveRequest::where('status', 'pending')->count() }}</p>
        </div>
    </div>

    <!-- Data Absensi -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Data Absensi Pegawai</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 border-b text-left font-semibold">Pegawai</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Check In</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Check Out</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse ($attendances as $absen)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $absen->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $absen->tanggal_masuk }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_keluar ?? '-' }}</td>
                            <td class="px-4 py-3">{{ ucfirst($absen->jenis) ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-3 text-gray-500">
                                Belum ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Data Pengajuan -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Pengajuan Cuti / Izin / Sakit</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 border-b text-left font-semibold">Pegawai</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Jenis</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Durasi</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Status</th>
                        <th class="px-4 py-3 border-b text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse ($leaves as $leave)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $leave->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $leave->leaveType->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                            <td class="px-4 py-3">{{ $leave->total_days }} hari</td>
                            <td class="px-4 py-3">
                                @if($leave->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">Pending</span>
                                @elseif($leave->status === 'approved')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Disetujui</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 flex space-x-2">
                                @if($leave->status === 'pending')
                                    <form action="{{ route('admin.approvals.approve', $leave->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.approvals.reject', $leave->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-3 text-gray-500">
                                Belum ada pengajuan cuti atau izin
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
