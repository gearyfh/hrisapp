@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <h2 class="text-lg font-semibold mb-4">Detail Pengajuan Lembur</h2>

    <div class="space-y-2">
        <p><strong>Karyawan:</strong> {{ $overtime->employee->nama ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ $overtime->date }}</p>
        <p><strong>Jam Mulai:</strong> {{ $overtime->start_time }}</p>
        <p><strong>Jam Selesai:</strong> {{ $overtime->end_time }}</p>
        <p><strong>Durasi:</strong> {{ $overtime->duration }} jam</p>
        <p><strong>Alasan:</strong> {{ $overtime->reason ?? '-' }}</p>
        <p><strong>Status:</strong> 
            <span class="px-2 py-1 rounded text-white 
                {{ $overtime->status == 'approved' ? 'bg-green-500' : ($overtime->status == 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                {{ ucfirst($overtime->status) }}
            </span>
        </p>
    </div>

   <form action="{{ route('admin.overtimes.update', $overtime->id) }}" method="POST" class="mt-4 inline">
    @csrf
    <input type="hidden" name="status" value="approved">
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
        Setujui
    </button>
</form>

<form action="{{ route('admin.overtimes.update', $overtime->id) }}" method="POST" class="mt-4 inline">
    @csrf
    <input type="hidden" name="status" value="rejected">
    <input type="text" name="comment" placeholder="Alasan penolakan" class="border rounded p-1 text-sm">
    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
        Tolak
    </button>
</form>

</div>
@endsection
