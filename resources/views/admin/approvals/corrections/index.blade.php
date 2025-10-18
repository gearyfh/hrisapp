@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Koreksi Absensi</h1>
    </div>

    @if($corrections->isEmpty())
        <p class="text-gray-500 text-center py-6">Belum ada pengajuan koreksi absensi.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Pegawai</th>
                        <th class="px-4 py-2 border">Tanggal Masuk  </th>
                        <th class="px-4 py-2 border">Masuk Lama</th>
                        <th class="px-4 py-2 border">Masuk Baru</th>
                        <th class="px-4 py-2 border">Pulang Lama</th>
                        <th class="px-4 py-2 border">Pulang Baru</th>
                        <th class="px-4 py-2 border text-center">Status</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($corrections as $correction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $correction->employee->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $correction->tanggal_masuk }}</td>
                            <td class="px-4 py-2 border">{{ $correction->old_clock_in ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $correction->new_clock_in ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $correction->old_clock_out ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $correction->new_clock_out ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">
                                @if($correction->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Pending</span>
                                @elseif($correction->status == 'approved')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Approved</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Rejected</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('admin.corrections.show', $correction->id) }}"
                                   class="text-blue-600 hover:underline text-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
