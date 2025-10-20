@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-8">
    <!-- Header -->
    <div class="mb-6 border-b border-gray-100 pb-3">
        <h1 class="text-2xl font-bold text-gray-800">Form Pengajuan Cuti</h1>
        <p class="text-gray-500 text-sm mt-1">Isi data berikut untuk mengajukan cuti dengan mudah dan cepat</p>
    </div>

    <!-- Error Validation -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-6 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('leave.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Jenis Cuti -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Jenis Cuti</label>
            <select name="leave_type_id"
                class="w-full border border-gray-300 rounded-xl p-3 mt-1 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">-- Pilih Jenis Cuti --</option>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Grid untuk tanggal mulai & selesai -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    required>
            </div>
        </div>

        <!-- Alasan -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Alasan</label>
            <textarea name="reason" rows="4"
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"
                placeholder="Tuliskan alasan pengajuan cuti...">{{ old('reason') }}</textarea>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('leave.index') }}"
                class="px-5 py-2.5 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition">
                Batal
            </a>
            <button type="submit"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm transition">
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>
@endsection
