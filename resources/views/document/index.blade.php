@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Dokumen Saya</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- @if($documents->isEmpty())
        <p class="text-gray-600 text-center py-6">Belum ada dokumen yang diunggah.</p>
    @else --}}
        <table class="w-full border-collapse text-sm md:text-base">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="border p-3 text-left">No</th>
                    <th class="border p-3 text-left">Nama Dokumen</th>
                    <th class="border p-3 text-left">Tanggal Upload</th>
                    <th class="border p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($documents as $index => $doc)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border p-3">{{ $index + 1 }}</td>
                        <td class="border p-3 font-medium">{{ $doc->nama_dokumen }}</td>
                        <td class="border p-3 text-gray-600">{{ $doc->created_at->format('d M Y, H:i') }}</td>
                        <td class="border p-3 text-center">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                class="inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                Lihat
                            </a>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" download
                                class="inline-block bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 transition ml-2">
                                Unduh
                            </a>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    {{-- @endif --}}
</div>
@endsection
