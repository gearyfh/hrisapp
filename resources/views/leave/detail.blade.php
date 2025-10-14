@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan Cuti</h1>
        <a href="{{ route('leave.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-600">Nama Karyawan:</p>
            <p class="font-semibold">{{ $leave->employee->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-gray-600">Jenis Cuti:</p>
            <p class="font-semibold">{{ $leave->leaveType->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-gray-600">Tanggal Mulai:</p>
            <p class="font-semibold">{{ $leave->start_date }}</p>
        </div>

        <div>
            <p class="text-gray-600">Tanggal Selesai:</p>
            <p class="font-semibold">{{ $leave->end_date }}</p>
        </div>

        <div>
            <p class="text-gray-600">Total Hari:</p>
            <p class="font-semibold">{{ $leave->total_days }} hari</p>
        </div>

        <div>
            <p class="text-gray-600">Status:</p>
            <p class="font-semibold capitalize">
                @if($leave->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">Pending</span>
                @elseif($leave->status == 'approved')
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Disetujui</span>
                @elseif($leave->status == 'rejected')
                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Ditolak</span>
                @else
                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">-</span>
                @endif
            </p>
        </div>

        <div class="col-span-2">
            <p class="text-gray-600">Alasan:</p>
            <p class="font-semibold">{{ $leave->reason ?? '-' }}</p>
        </div>

        @if($leave->attachment)
        <div class="col-span-2">
            <p class="text-gray-600">Lampiran:</p>
            <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank"
               class="text-blue-600 hover:underline">
               Lihat Lampiran
            </a>
        </div>
        @endif

        @if($leave->comment)
        <div class="col-span-2">
            <p class="text-gray-600">Komentar HR / Atasan:</p>
            <p class="font-semibold">{{ $leave->comment }}</p>
        </div>
        @endif
    </div>

    <div class="mt-6 text-right">
        <p class="text-gray-500 text-sm">
            Disetujui oleh: {{ $leave->approved_by ?? '-' }} <br>
            Pada: {{ $leave->approved_at ?? '-' }}
        </p>
    </div>
</div>
@endsection
