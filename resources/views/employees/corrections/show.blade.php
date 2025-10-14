@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <h1 class="text-2xl font-semibold text-gray-800 mb-5">Detail Pengajuan Koreksi Absensi</h1>

    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-600 font-medium">Tanggal Masuk Lama:</p>
            <p class="text-gray-800">{{ $correction->attendance->tanggal_masuk ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">Tanggal Masuk Baru:</p>
            <p class="text-gray-800">{{ $correction->new_date_in ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">Jam Masuk Lama:</p>
            <p class="text-gray-800">{{ $correction->old_clock_in ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">Jam Masuk Baru:</p>
            <p class="text-gray-800">{{ $correction->new_clock_in ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">Jam Pulang Lama:</p>
            <p class="text-gray-800">{{ $correction->old_clock_out ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">Jam Pulang Baru:</p>
            <p class="text-gray-800">{{ $correction->new_clock_out ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-5">
        <p class="text-gray-600 font-medium">Alasan Koreksi:</p>
        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg">{{ $correction->reason }}</p>
    </div>

    <div class="mt-5">
        <p class="text-gray-600 font-medium">Status:</p>
        <span class="px-3 py-1 text-sm rounded-lg 
            @if($correction->status == 'approved') bg-green-100 text-green-700
            @elseif($correction->status == 'rejected') bg-red-100 text-red-700
            @else bg-yellow-100 text-yellow-700 @endif">
            {{ ucfirst($correction->status) }}
        </span>
    </div>

    <div class="mt-5 flex justify-end">
        <a href="{{ route('employees.corrections.index') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
           ← Kembali
        </a>
    </div>
</div>
@endsection
