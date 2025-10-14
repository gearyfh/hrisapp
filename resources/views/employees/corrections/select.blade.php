@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-5">
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
        <table class="w-full text-sm text-gray-700 border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal Masuk</th>
                    <th class="px-4 py-2 text-left">Jam Masuk</th>
                    <th class="px-4 py-2 text-left">Tanggal Keluar</th>
                    <th class="px-4 py-2 text-left">Jam Pulang</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                    @php
                        $hasPending = $attendance->corrections()
                            ->whereIn('status', ['pending', 'approved'])
                            ->exists();
                    @endphp

                    <tr>
                        <td class="px-4 py-2 text-left">{{ $attendance->tanggal_masuk }}</td>
                        <td class="px-4 py-2 text-left">{{ $attendance->jam_masuk }}</td>
                        <td class="px-4 py-2 text-left">{{ $attendance->tanggal_keluar }}</td>
                        <td class="px-4 py-2 text-left">{{ $attendance->jam_keluar }}</td>
                        <td class="px-4 py-2 text-center">
                            @if($hasPending)
                                <span class="text-gray-400 text-sm italic">Sudah diajukan</span>
                            @else
                                <a href="{{ route('employees.corrections.create', $attendance->id) }}"
                                class="text-blue-600 hover:underline">Ajukan Koreksi</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
