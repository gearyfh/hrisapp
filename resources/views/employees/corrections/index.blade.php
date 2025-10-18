@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Koreksi Absensi</h1>

        <a href="{{ route('employees.corrections.select') }}"
           class="bg-white hover:bg-green-700 hover:text-white hover:border-none border border-gray-400 text-black px-4 py-2 rounded-full transition">
            + Ajukan Koreksi
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border">Tanggal</th>
                    <th class="p-3 border">Clock In Lama</th>
                    <th class="p-3 border">Clock In Baru</th>
                    <th class="p-3 border">Clock Out Lama</th>
                    <th class="p-3 border">Clock Out Baru</th>
                    <th class="p-3 border">Alasan</th>
                    <th class="p-3 border text-center">Status</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($corrections as $correction)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 border">{{ $correction->date }}</td>
                        <td class="p-3 border">{{ $correction->old_clock_in ?? '-' }}</td>
                        <td class="p-3 border">{{ $correction->new_clock_in ?? '-' }}</td>
                        <td class="p-3 border">{{ $correction->old_clock_out ?? '-' }}</td>
                        <td class="p-3 border">{{ $correction->new_clock_out ?? '-' }}</td>
                        <td class="p-3 border">{{ $correction->reason ?? '-' }}</td>
                        <td class="p-3 border text-center">
                            @if($correction->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Pending</span>
                            @elseif($correction->status == 'approved')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Disetujui</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Ditolak</span>
                            @endif
                        </td>
                        <td class="p-3 border text-center">
                            <a href="{{ route('employees.corrections.show', $correction->id) }}"
                               class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-3 text-center text-gray-500">
                            Belum ada pengajuan koreksi absensi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
