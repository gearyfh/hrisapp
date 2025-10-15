@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <h2 class="text-lg font-semibold mb-4">Ajukan Lembur</h2>

    <form action="{{ route('employees.overtime.store') }}" method="POST" class="space-y-4 center">
        @csrf
        <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">

        <div>
            <label class="block font-medium">Tanggal</label>
            <input type="date" name="date" value="{{ $attendance->tanggal_masuk }}" 
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium">Jam Mulai Lembur</label>
            <input type="time" name="start_time" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium">Durasi Lembur</label>
            <select name="duration_option" id="duration_option" 
                    class="w-full border rounded p-2">
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

        <div>
            <label class="block font-medium">Alasan Lembur</label>
            <textarea name="reason" rows="3" class="w-full border rounded p-2"
                      placeholder="Tuliskan alasan lembur..."></textarea>
        </div>

        <div class="text-right">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>
@endsection
