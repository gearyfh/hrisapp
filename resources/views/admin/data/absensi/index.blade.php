@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <h2 class="text-lg font-semibold mb-4">Rekap Total Jam Kerja Karyawan</h2>

    <table class="min-w-full border border-gray-200 text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border text-center">Total Hari Absen</th>
                <th class="p-2 border text-center">Total Lembur (jam)</th>
                <th class="p-2 border text-center">Total Jam Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $data)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $data['nama'] }}</td>
                    <td class="p-2 text-center">{{ $data['total_absen'] }}</td>
                    <td class="p-2 text-center">{{ $data['total_lembur'] }}</td>
                    <td class="p-2 text-center font-semibold">{{ (int) $data['total_jam_kerja'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
