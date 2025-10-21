@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <h2 class="text-xl font-semibold mb-4">Persetujuan Lembur</h2>

    <table class="w-full text-sm border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-3 py-2">Karyawan</th>
                <th class="border px-3 py-2">Tanggal</th>
                <th class="border px-3 py-2">Durasi</th>
                <th class="border px-3 py-2">Alasan</th>
                <th class="border px-3 py-2">Status</th>
                <th class="border px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overtimes as $overtime)
            <tr>
                <td class="border px-3 py-2">{{ $overtime->employee->name ?? '-' }}</td>
                <td class="border px-3 py-2">{{ $overtime->date }}</td>
                <td class="border px-3 py-2">{{ $overtime->duration }} jam</td>
                <td class="border px-3 py-2">{{ $overtime->reason ?? '-' }}</td>
                <td class="border px-3 py-2">
                    <span class="px-2 py-1 rounded text-white 
                        {{ $overtime->status == 'approved' ? 'bg-green-500' : ($overtime->status == 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                        {{ ucfirst($overtime->status) }}
                    </span>
                </td>
                <td class="border px-3 py-2 text-center">
                    <a href="{{ route('admin.overtimes.show', $overtime->id) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
