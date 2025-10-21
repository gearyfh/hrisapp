@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <h2 class="text-lg font-semibold mb-4">Rekap Total Jam Kerja Karyawan</h2>

    {{-- Filter bulan --}}
    <form method="GET" action="{{ route('admin.data.absensi.index') }}" class="flex items-center gap-2 mb-4">
        <input type="month" name="month" value="{{ $month }}" class="border rounded-md px-2 py-1">
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
            Tampilkan
        </button>
    </form>

    <table class="min-w-full border border-gray-200 text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border text-center">Hari Kerja (work_days)</th>
                <th class="p-2 border text-center">Jam Kerja (work_hours)</th>
                <th class="p-2 border text-center">Jam Lembur</th>
                <th class="p-2 border text-center">Total Jam</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekap as $data)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $data['nama'] }}</td>
                    <td class="p-2 text-center">{{ number_format($data['hari_kerja'] ?? 0, 1) }}</td>
                    <td class="p-2 text-center">{{ number_format($data['jam_kerja'] ?? 0, 1) }}</td>

                    <td class="p-2 text-center">{{ number_format($data['jam_lembur'] ?? 0, 1) }}</td>
                    <td class="p-2 text-center font-semibold">{{ number_format($data['total_jam'] ?? 0, 1) }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-3 text-gray-500">Tidak ada data untuk bulan ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
