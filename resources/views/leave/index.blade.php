@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Cuti / Izin / Sakit</h1>
        <a href="{{ route('leave.cuti.create') }}"
            class="inline-flex items-center border border-blue-500 text-blue-600 px-5 py-2.5 rounded-full text-sm font-medium hover:bg-blue-600 hover:text-white transition-all duration-200 shadow-sm">
            + Ajukan Cuti
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Pengajuan -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Jenis</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Total Hari</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($leaves as $leave)
                @if($leave->leaveType->type != 'cuti')
                    @continue
                @endif
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $no++
                         }}</td>
                        <td class="p-4 text-gray-700">{{ $leave->leaveType->name ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                        <td class="p-4 text-gray-700">{{ $leave->total_days }} hari</td>
                        <td class="p-4 text-gray-700">
                            @if($leave->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                            @elseif($leave->status == 'approved')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Disetujui</span>
                            @elseif($leave->status == 'rejected')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Ditolak</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('leave.detail', $leave->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">Belum ada pengajuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
