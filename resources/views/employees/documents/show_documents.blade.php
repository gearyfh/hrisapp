@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Dokumen Karyawan</h1>
    </div>

    @if ($employee->documents->isEmpty())
        <p>Tidak ada dokumen yang diunggah.</p>
    @else
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Nama File</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal Upload</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee->documents as $index => $doc)
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $index + 1 }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->nama_file }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->tipe ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->created_at->format('d M Y') }}</td>
                        <td class="p-4">
                            <a href="{{ asset($doc->path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
