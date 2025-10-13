@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $employee->nama }}</h1>

    <h2 class="text-xl font-semibold mb-2">Dokumen Karyawan</h2>

    @if ($employee->documents->isEmpty())
        <p>Tidak ada dokumen yang diunggah.</p>
    @else
        <table class="w-full border border-gray-300 mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Nama File</th>
                    <th class="p-2 border">Kategori</th>
                    <th class="p-2 border">Tanggal Upload</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee->documents as $index => $doc)
                    <tr>
                        <td class="p-2 border text-center">{{ $index + 1 }}</td>
                        <td class="p-2 border">{{ $doc->nama_file }}</td>
                        <td class="p-2 border">{{ $doc->tipe ?? '-' }}</td>
                        <td class="p-2 border text-center">{{ $doc->created_at->format('d M Y') }}</td>
                        <td class="p-2 border text-center">
                            <a href="{{ asset($doc->path) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
