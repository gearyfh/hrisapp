@extends('layouts.app')

@section('content')
<div class="min-h-screen py-4 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 p-8 transition hover:shadow-xl">
        
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                🗂️ Detail Pengajuan Cuti
            </h1>
            <a href="{{ route('leave.index') }}" 
               class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1 transition">
               ← Kembali
            </a>
        </div>

        {{-- Informasi Utama --}}
        <div class="grid grid-cols-2 gap-6 text-sm">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <p class="text-gray-500">Nama Karyawan</p>
                <p class="font-semibold text-gray-800 mt-1">{{ $leave->employee->name ?? '-' }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <p class="text-gray-500">Jenis Cuti</p>
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
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">✅ Disetujui</span>
                    @elseif($leave->status == 'rejected')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">❌ Ditolak</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium shadow-sm">-</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Alasan Cuti --}}
        <div class="mt-6 bg-gray-50 p-5 rounded-lg border border-gray-100">
            <p class="text-gray-500 mb-1">📝 Alasan</p>
            <p class="font-semibold text-gray-800 leading-relaxed">{{ $leave->reason ?? '-' }}</p>
        </div>

        {{-- Lampiran (jika ada) --}}
        @if($leave->attachment)
        <div class="mt-5 bg-gray-50 p-5 rounded-lg border border-gray-100">
            <p class="text-gray-500 mb-2">📎 Lampiran</p>
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
        @endif

        {{-- Komentar HR / Atasan --}}
        @if($leave->comment)
        <div class="mt-5 bg-gray-50 p-5 rounded-lg border border-gray-100">
            <p class="text-gray-500 mb-1">💬 Komentar HR / Atasan</p>
            <p class="font-semibold text-gray-800">{{ $leave->comment }}</p>
        </div>
        @endif

        {{-- Info Persetujuan --}}
        <div class="mt-8 text-right text-sm text-gray-500 border-t pt-4">
            <p>Disetujui oleh: <span class="font-medium text-gray-700">{{ $leave->approved_by ?? '-' }}</span></p>
            <p>Pada: <span class="font-medium text-gray-700">{{ $leave->approved_at ?? '-' }}</span></p>
        </div>
    </div>
</div>
@endsection
