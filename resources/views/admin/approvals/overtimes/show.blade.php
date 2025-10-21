@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100 relative">
    <!-- Header dengan tombol Kembali di kanan -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Detail Pengajuan Lembur</h2>
        <a href="{{ route('admin.overtimes.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow-sm transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Detail Lembur -->
    <div class="space-y-2">
        <p><strong>Karyawan:</strong> {{ $overtime->employee->nama ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ $overtime->date }}</p>
        <p><strong>Jam Mulai:</strong> {{ $overtime->start_time }}</p>
        <p><strong>Jam Selesai:</strong> {{ $overtime->end_time }}</p>
        <p><strong>Durasi:</strong> {{ $overtime->duration }} jam</p>
        <p><strong>Alasan:</strong> {{ $overtime->reason ?? '-' }}</p>
        <p><strong>Status:</strong> 
            <span class="px-2 py-1 rounded text-white 
                {{ $overtime->status == 'approved' ? 'bg-green-500' : ($overtime->status == 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                {{ ucfirst($overtime->status) }}
            </span>
        </p>
    </div>

    <!-- Tombol Setujui -->
    <form action="{{ route('admin.overtimes.update', $overtime->id) }}" method="POST" class="mt-4 inline">
        @csrf
        <input type="hidden" name="status" value="approved">
        <button type="submit" 
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                {{ in_array($overtime->status, ['approved', 'rejected']) ? 'disabled' : '' }}>
            Setujui
        </button>
    </form>

    <!-- Tombol Tolak -->
    <form action="{{ route('admin.overtimes.update', $overtime->id) }}" method="POST" class="mt-4 inline">
        @csrf
        <input type="hidden" name="status" value="rejected">
        <input type="text" name="comment" placeholder="Alasan penolakan" 
               class="border rounded p-1 text-sm"
               {{ in_array($overtime->status, ['approved', 'rejected']) ? 'disabled' : '' }}>
        <button type="submit" 
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                {{ in_array($overtime->status, ['approved', 'rejected']) ? 'disabled' : '' }}>
            Tolak
        </button>
    </form>
</div>
@endsection
