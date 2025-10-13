@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-gray-700 font-semibold">#</th>
                    <th class="p-3 text-gray-700 font-semibold">Jenis</th>
                    <th class="p-3 text-gray-700 font-semibold">Tanggal</th>
                    <th class="p-3 text-gray-700 font-semibold">Total Hari</th>
                    <th class="p-3 text-gray-700 font-semibold">Status</th>
                    <th class="p-3 text-gray-700 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($requests as $leave)
                    @if($leave->leaveType->type !== 'cuti')
                        @continue
                    @endif
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $no++ }}</td>
                        <td class="p-3">{{ $leave->leaveType->name ?? '-' }}</td>
                        <td class="p-3">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                        <td class="p-3">{{ $leave->total_days }} hari</td>
                        <td class="p-3">
                            @if($leave->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">Pending</span>
                            @elseif($leave->status == 'approved')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Ditolak</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            <a href="{{ route('admin.approvals.cuti.show', $leave->id) }}" 
                               class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                Detail
                            </a>
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
