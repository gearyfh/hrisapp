@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Pilih Absensi untuk Koreksi</h1>
        <a href="{{ route('employees.corrections.index') }}" 
           class="text-gray-500 hover:text-gray-700 text-sm flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    @if($attendances->isEmpty())
        <div class="text-center text-gray-600 py-8">
            Tidak ada data absensi yang dapat dikoreksi.
        </div>
    @else
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal Masuk</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Jam Masuk</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal Keluar</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Jam Pulang</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                    @php
                        $hasPending = $attendance->corrections()
                            ->whereIn('status', ['pending', 'approved'])
                            ->exists();
                    @endphp

                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $attendance->tanggal_masuk }}</td>
                        <td class="p-4 text-gray-700">{{ $attendance->jam_masuk }}</td>
                        <td class="p-4 text-gray-700">{{ $attendance->tanggal_keluar }}</td>
                        <td class="p-4 text-gray-700">{{ $attendance->jam_keluar }}</td>
                        <td class="p-4">
                            @if($hasPending)
                                <span class="text-gray-400 font-medium text-sm transition">Sudah diajukan</span>
                            @else
                                <a href="{{ route('employees.corrections.create', $attendance->id) }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">Ajukan Koreksi</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
