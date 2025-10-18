@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Dokumen</h2>
        <a href="{{ route('admin.documents.create') }}" class="bg-white border border-gray-400 text-black px-4 py-2 rounded-full hover:bg-green-600 hover:text-white">
            + Upload Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-gray-700 font-semibold">Nama Dokumen</th>
                    <th class="p-3 text-gray-700 font-semibold">Jenis</th>
                    <th class="p-3 text-gray-700 font-semibold">Karyawan</th>
                    <th class="p-3 text-gray-700 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                    <tr class="border-b hover:bg-gray-50">
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
</div>
@endsection
