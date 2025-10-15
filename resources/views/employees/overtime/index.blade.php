@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Lembur</h1>
        <a href="{{ route('employees.overtime.select') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
            + Ajukan Lembur
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if ($overtimes->isEmpty())
        <div class="text-center text-gray-500 py-10">
            Belum ada pengajuan lembur.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-b">Tanggal</th>
                        <th class="px-4 py-2 border-b">Jam Mulai</th>
                        <th class="px-4 py-2 border-b">Jam Selesai</th>
                        <th class="px-4 py-2 border-b">Durasi</th>
                        <th class="px-4 py-2 border-b">Alasan</th>
                        <th class="px-4 py-2 border-b text-center">Status</th>
                        <th class="px-4 py-2 border-b text-center">Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($overtimes as $overtime)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($overtime->date)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border-b">{{ $overtime->start_time }}</td>
                            <td class="px-4 py-2 border-b">{{ $overtime->end_time }}</td>
                            <td class="px-4 py-2 border-b">{{ $overtime->duration }} jam</td>
                            <td class="px-4 py-2 border-b">{{ $overtime->reason }}</td>
                            <td class="px-4 py-2 border-b text-center">
                                @if ($overtime->status === 'pending')
                                    <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Menunggu</span>
                                @elseif ($overtime->status === 'approved')
                                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Disetujui</span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b text-center">
                                {{ $overtime->comment ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
