@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-semibold">Daftar Dokumen</h2>
        <a href="{{ route('admin.documents.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            + Upload Baru
        </a>
    </div>

    <table class="min-w-full border text-left">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border">Nama Dokumen</th>
                <th class="p-3 border">Jenis</th>
                <th class="p-3 border">Karyawan</th>
                <th class="p-3 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $doc)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border">{{ $doc->nama_file }}</td>
                    <td class="p-3 border capitalize">{{ $doc->tipe }}</td>
                    <td class="p-3 border">{{ $doc->employee->name ?? '-' }}</td>
                    <td class="p-3 border">
                        <a href="{{ asset($doc->path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
