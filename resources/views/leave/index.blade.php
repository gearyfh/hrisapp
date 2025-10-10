@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti / Izin / Sakit</h1>

        <div class="space-x-2">
            <a href="{{ route('leave.cuti.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                + Ajukan Cuti
            </a>

            <a href="{{ route('leave.izin_sakit.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                + Ajukan Izin / Sakit
            </a>
        </div>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Pengajuan -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-gray-700 font-semibold">#</th>
                    <th class="p-3 text-gray-700 font-semibold">Jenis</th>
                    <th class="p-3 text-gray-700 font-semibold">Tanggal</th>
                    <th class="p-3 text-gray-700 font-semibold">Total Hari</th>
                    <th class="p-3 text-gray-700 font-semibold">Status</th>
                    <th class="p-3 text-gray-700 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $leave->leaveType->name ?? '-' }}</td>
                        <td class="p-3">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                        <td class="p-3">{{ $leave->total_days }} hari</td>
                        <td class="p-3">
                            @if($leave->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">Pending</span>
                            @elseif($leave->status == 'approved')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Disetujui</span>
                            @elseif($leave->status == 'rejected')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Ditolak</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">-</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <a href="#" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center text-gray-500">Belum ada pengajuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
