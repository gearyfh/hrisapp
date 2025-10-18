@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Detail Pengajuan Izin / Sakit</h1>
        <a href="{{ route('sick.index') }}"
           class="inline-flex items-center text-indigo-600 font-medium hover:text-indigo-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Grid Detail -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <p class="text-gray-500 text-sm">Nama Karyawan</p>
            <p class="text-gray-900 font-semibold text-lg">{{ $leave->employee->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Jenis Izin / Sakit</p>
            <p class="text-gray-900 font-semibold text-lg">{{ $leave->leaveType->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Tanggal Mulai</p>
            <p class="text-gray-900 font-semibold">{{ $leave->start_date }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Tanggal Selesai</p>
            <p class="text-gray-900 font-semibold">{{ $leave->end_date }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Total Hari</p>
            <p class="text-gray-900 font-semibold">{{ $leave->total_days }} hari</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Status</p>
            @if($leave->status == 'pending')
                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Pending</span>
            @elseif($leave->status == 'approved')
                <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Disetujui</span>
            @elseif($leave->status == 'rejected')
                <span class="inline-block bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Ditolak</span>
            @else
                <span class="inline-block bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full">-</span>
            @endif
        </div>

        <div class="md:col-span-2">
            <p class="text-gray-500 text-sm">Alasan Izin / Sakit</p>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-1">
                <p class="text-gray-800">{{ $leave->reason ?? '-' }}</p>
            </div>
        </div>

        @if($leave->attachment)
        <div class="md:col-span-2">
            <p class="text-gray-500 text-sm mb-1">Lampiran Surat Dokter / Bukti</p>
            <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank"
               class="inline-block text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition">
                📎 Lihat Lampiran
            </a>
        </div>
        @endif

        @if($leave->comment)
        <div class="md:col-span-2">
            <p class="text-gray-500 text-sm mb-1">Komentar HR / Atasan</p>
            <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3">
                <p class="text-gray-800">{{ $leave->comment }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Footer Info -->
    <div class="mt-8 border-t pt-4 text-right text-sm text-gray-500">
        <p>Disetujui oleh: <span class="text-gray-700 font-medium">{{ $leave->approved_by ?? '-' }}</span></p>
        <p>Pada: <span class="text-gray-700 font-medium">{{ $leave->approved_at ?? '-' }}</span></p>
    </div>
</div>
@endsection
