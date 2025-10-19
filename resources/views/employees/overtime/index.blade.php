@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Lembur</h1>
        <a href="{{ route('employees.overtime.select') }}" 
           class="inline-flex items-center border border-indigo-500 text-indigo-600 px-5 py-2.5 rounded-full text-sm font-medium hover:bg-indigo-600 hover:text-white transition-all duration-200 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajukan Lembur
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($overtimes->isEmpty())
        <div class="text-center text-gray-500 py-8">
            Belum ada pengajuan lembur.
        </div>
    @else
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Jam Mulai</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Jam Selesai</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Durasi</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Alasan</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($overtimes as $overtime)
                        <tr class="border-b hover:bg-indigo-50 transition">
                            <td class="p-4 text-gray-700">{{ $no++ }}</td>
                            <td class="p-4 text-gray-700">{{ \Carbon\Carbon::parse($overtime->date)->format('d M Y') }}</td>
                            <td class="p-4 text-gray-700">{{ $overtime->start_time }}</td>
                            <td class="p-4 text-gray-700">{{ $overtime->end_time }}</td>
                            <td class="p-4 text-gray-700">{{ $overtime->duration }} jam</td>
                            <td class="p-4 text-gray-700">{{ $overtime->reason }}</td>
                            <td class="p-4">
                                @if($overtime->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                @elseif($overtime->status == 'approved')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Disetujui</span>
                                @elseif($overtime->status == 'rejected')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Ditolak</span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">-</span>
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
