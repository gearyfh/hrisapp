@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-100 mt-10">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">💼 Ajukan Lembur</h2>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.overtime.store') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">

        {{-- Input tanggal --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">📅 Tanggal</label>
            <input type="date" name="date" value="{{ $attendance->tanggal_masuk }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        {{-- Input jam mulai --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">🕒 Jam Mulai Lembur</label>
            <input type="time" name="start_time"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        {{-- Pilih durasi --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">⏳ Durasi Lembur</label>
            <select name="duration_option" id="duration_option"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">-- Pilih Durasi --</option>
                <option value="0.5">0 jam 30 menit</option>
                <option value="1">1 jam</option>
                <option value="1.5">1 jam 30 menit</option>
                <option value="2">2 jam</option>
                <option value="2.5">2 jam 30 menit</option>
                <option value="3">3 jam</option>
                <option value="3.5">3 jam 30 menit</option>
                <option value="4">4 jam</option>
            </select>
        </div>

        {{-- Alasan --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">📝 Alasan Lembur</label>
            <textarea name="reason" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none"
                      placeholder="Tuliskan alasan lembur dengan jelas..."></textarea>
        </div>

        {{-- Tombol submit --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium shadow-md transition duration-200 transform hover:scale-105 active:scale-95">
                🚀 Kirim Pengajuan
            </button>
        </div>
    </form>
</div>
@endsection
