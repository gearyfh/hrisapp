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
    <div class="grid grid-cols-2 gap-6 text-sm">

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Nama Karyawan</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->employee->name ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Jenis Izin / Sakit</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->leaveType->name ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Tanggal Mulai</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->start_date }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Tanggal Selesai</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->end_date }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Total Hari</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->total_days }} hari</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Status</p>
            <p class="font-semibold mt-2">
                @if($leave->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">⏳ Pending</span>
                @elseif($leave->status == 'approved')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">✅ Approved</span>
                @elseif($leave->status == 'rejected')
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">❌ Rejected</span>
                @else
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium shadow-sm">-</span>
                @endif
            </p>
        </div>

        <div class="md:col-span-2">
            <div class="mt-2 bg-gray-50 p-5 rounded-lg border border-gray-100">
                <p class="text-gray-500 mb-1">📝 Alasan Izin / Sakit</p>
                <p class="font-semibold text-gray-800 leading-relaxed">{{ $leave->reason ?? '-' }}</p>
            </div>
        </div>

        @if($leave->attachment)
         <div class="md:col-span-2">
            <div class="mt-2 bg-gray-50 p-5 rounded-lg border border-gray-100">
                <p class="text-gray-500 mb-2">📎 Lampiran Surat Dokter / Bukti</p>
                <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4v16m8-8H4" />
                    </svg>
                    Lihat Lampiran
                </a>
            </div>
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
        <p>Approved oleh: <span class="text-gray-700 font-medium">{{ $leave->approved_by ?? '-' }}</span></p>
        <p>Pada: <span class="text-gray-700 font-medium">{{ $leave->approved_at ?? '-' }}</span></p>
    </div>
</div>
@endsection
