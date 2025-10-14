@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-semibold text-gray-800">Ajukan Koreksi Absensi</h1>
        <a href="{{ route('employees.corrections.select') }}" 
           class="text-gray-500 hover:text-gray-700 text-sm flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <div class="">
        <div>
                <label class="block text-gray-600 mb-1 font-medium">Status Saat Ini</label>
                <span class="inline-block px-3 py-2 bg-gray-100 rounded-lg text-gray-700">
                    {{ $attendances->status ?? 'Hadir' }}
                </span>
            </div>
    </div>

    <form action="{{ route('employees.corrections.store') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <label class="block text-gray-600 mb-1 font-medium">Tanggal Masuk Lama</label>
                <input type="text" value="{{ $attendance->tanggal_masuk }}" disabled
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-gray-700">
            </div>
            <div>
        <label for="new_date_in" class="block text-gray-600 mb-1 font-medium">Tanggal Masuk Baru</label>
        <input type="date" name="new_date_in" id="new_date_in"
               class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2"
               value="{{ old('new_date_in') }}">
    </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
                 <div>
                <label class="block text-gray-600 mb-1 font-medium">Tanggal Keluar Lama</label>
                <input type="text" value="{{ $attendance->tanggal_keluar }}" disabled
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-gray-700">
            </div>
    <div>
        <label for="new_date_out" class="block text-gray-600 mb-1 font-medium">Tanggal Keluar Baru</label>
        <input type="date" name="new_date_out" id="new_date_out"
               class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2"
               value="{{ old('new_date_out') }}">
    </div>
</div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <label class="block text-gray-600 mb-1 font-medium">Jam Masuk Lama</label>
                <input type="text" value="{{ $attendance->jam_masuk ?? '-' }}" disabled
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-gray-700">
            </div>
            <div>
                <label class="block text-gray-600 mb-1 font-medium">Jam Masuk Baru</label>
                <input type="time" name="new_clock_in" 
                       class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <label class="block text-gray-600 mb-1 font-medium">Jam Pulang Lama</label>
                <input type="text" value="{{ $attendance->jam_keluar ?? '-' }}" disabled
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-gray-700">
            </div>
            <div>
                <label class="block text-gray-600 mb-1 font-medium">Jam Pulang Baru</label>
                <input type="time" name="new_clock_out" 
                       class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block text-gray-600 mb-1 font-medium">Alasan Koreksi <span class="text-red-500">*</span></label>
            <textarea name="reason" rows="3" required
                      class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2 text-sm"
                      placeholder="Tuliskan alasan kenapa perlu koreksi absensi..."></textarea>
        </div>

        <div class="flex justify-end space-x-2 pt-3">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                Kirim Pengajuan
            </button>
            <a href="{{ route('employees.corrections.select') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
