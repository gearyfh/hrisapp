@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Koreksi Absensi</h1>
    </div>

    @if($corrections->isEmpty())
        <p class="text-gray-500 text-center py-6">Belum ada pengajuan koreksi absensi.</p>
    @else
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Pegawai</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal Masuk  </th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Masuk Lama</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Masuk Baru</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Pulang Lama</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Pulang Baru</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($corrections as $correction)
                        <tr class="border-b hover:bg-indigo-50 transition">
                            <td class="p-4 text-gray-700">{{ $loop->iteration }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->employee->name ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->tanggal_masuk }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->old_clock_in ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->new_clock_in ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->old_clock_out ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->new_clock_out ?? '-' }}</td>
                            <td class="p-4">
                                @if($correction->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                @elseif($correction->status == 'approved')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Approved</span>
                                @elseif($correction->status == 'rejected')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Rejected</span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">-</span>
                                @endif
                            </td>
                            <td class="px-4">
                                <a href="{{ route('admin.corrections.show', $correction->id) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">
                                Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
