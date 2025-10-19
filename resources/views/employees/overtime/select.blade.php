@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-semibold text-gray-800">Pilih Jadwal untuk Pengajuan Lembur</h1>
        <a href="{{ route('employees.overtime.index') }}" 
           class="text-gray-500 hover:text-gray-700 text-sm flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal Masuk</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Jam Masuk</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Jam Keluar</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $attendance->tanggal_masuk }}</td>
                        <td class="p-4 text-gray-700">{{ $attendance->jam_masuk }}</td>
                        <td class="p-4 text-gray-700">{{ $attendance->jam_keluar }}</td>
                        <td class="p-4 text-gray-700">
                            <a href="{{ route('employees.overtime.create', $attendance->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                            Pilih
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border text-center py-3 text-gray-500">
                            Tidak ada data absensi ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
