@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-lg font-semibold mb-4">Pilih Jadwal untuk Pengajuan Lembur</h2>

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Tanggal Masuk</th>
                <th class="border px-4 py-2">Jam Masuk</th>
                <th class="border px-4 py-2">Jam Keluar</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <td class="border px-4 py-2">{{ $attendance->tanggal_masuk }}</td>
                    <td class="border px-4 py-2">{{ $attendance->jam_masuk }}</td>
                    <td class="border px-4 py-2">{{ $attendance->jam_keluar }}</td>
                    <td class="border px-4 py-2 text-center">
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
@endsection
