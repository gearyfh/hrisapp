@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-8">
    <div class="mb-6 border-b border-gray-100 pb-3">

        {{-- Header --}}
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center gap-2">
                <span class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                    <i class="fas fa-clipboard-list"></i>
                </span>
                <h1 class="text-2xl font-semibold text-gray-800">Form Koreksi Absensi</h1>
            </div>
            <a href="{{ route('employees.corrections.select') }}" 
               class="text-sm text-gray-500 hover:text-gray-700 transition flex items-center gap-1">
                ← Kembali
            </a>
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <label class="block text-gray-600 font-medium mb-1">Status Saat Ini</label>
            <span class="inline-block px-3 py-2 bg-gray-100 rounded-lg text-gray-700 text-sm">
                {{ $attendances->status ?? 'Hadir' }}
            </span>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-6">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('employees.corrections.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">

            {{-- Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <label class="block text-gray-600 mb-1 font-medium">Tanggal Masuk Lama</label>
                    <input type="text" value="{{ $attendance->tanggal_masuk }}" disabled
                           class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded-lg px-3 py-2.5">
                </div>
                <div>
                    <label for="new_date_in" class="block text-gray-600 mb-1 font-medium">Tanggal Masuk Baru</label>
                    <input type="date" name="new_date_in" id="new_date_in" value="{{ old('new_date_in') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none hover:border-blue-400 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <label class="block text-gray-600 mb-1 font-medium">Tanggal Keluar Lama</label>
                    <input type="text" value="{{ $attendance->tanggal_keluar }}" disabled
                           class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded-lg px-3 py-2.5">
                </div>
                <div>
                    <label for="new_date_out" class="block text-gray-600 mb-1 font-medium">Tanggal Keluar Baru</label>
                    <input type="date" name="new_date_out" id="new_date_out" value="{{ old('new_date_out') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none hover:border-blue-400 transition">
                </div>
            </div>

            {{-- Jam --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <label class="block text-gray-600 mb-1 font-medium">Jam Masuk Lama</label>
                    <input type="text" value="{{ $attendance->jam_masuk ?? '-' }}" disabled
                           class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded-lg px-3 py-2.5">
                </div>
                <div>
                    <label class="block text-gray-600 mb-1 font-medium">Jam Masuk Baru</label>
                    <input type="time" name="new_clock_in"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none hover:border-blue-400 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <label class="block text-gray-600 mb-1 font-medium">Jam Pulang Lama</label>
                    <input type="text" value="{{ $attendance->jam_keluar ?? '-' }}" disabled
                           class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded-lg px-3 py-2.5">
                </div>
                <div>
                    <label class="block text-gray-600 mb-1 font-medium">Jam Pulang Baru</label>
                    <input type="time" name="new_clock_out"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none hover:border-blue-400 transition">
                </div>
            </div>

            {{-- Alasan --}}
            <div>
                <label class="block text-gray-600 mb-1 font-medium">
                    Alasan Koreksi <span class="text-red-500">*</span>
                </label>
                <textarea name="reason" rows="3" required
                    placeholder="Tuliskan alasan kenapa perlu koreksi absensi..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none hover:border-blue-400 transition resize-none">{{ old('reason') }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('employees.corrections.select') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow-md transition">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
