@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6">
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-semibold text-gray-800">Detail Pengajuan Koreksi Absensi</h1>
        <a href="{{ route('admin.corrections.index') }}" class="text-gray-500 hover:text-gray-700 text-sm flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <div class="space-y-2 text-sm text-gray-700">
        <div class="grid grid-cols-2">
            <span class="font-semibold">Pegawai</span>
            <span>{{ $correction->employee->name ?? '-' }}</span>
        </div>
        <div class="grid grid-cols-2">
            <span class="font-semibold">Tanggal</span>
            <span>{{ $correction->date }}</span>
        </div>
        <div class="grid grid-cols-2">
            <span class="font-semibold">Masuk Lama</span>
            <span>{{ $correction->old_clock_in ?? '-' }}</span>
        </div>
        <div class="grid grid-cols-2">
            <span class="font-semibold">Masuk Baru</span>
            <span>{{ $correction->new_clock_in ?? '-' }}</span>
        </div>
        <div class="grid grid-cols-2">
            <span class="font-semibold">Pulang Lama</span>
            <span>{{ $correction->old_clock_out ?? '-' }}</span>
        </div>
        <div class="grid grid-cols-2">
            <span class="font-semibold">Pulang Baru</span>
            <span>{{ $correction->new_clock_out ?? '-' }}</span>
        </div>
        <div class="grid grid-cols-2">
            <span class="font-semibold">Alasan</span>
            <span>{{ $correction->reason ?? '-' }}</span>
        </div>
        <div class="grid grid-cols-2">
            <span class="font-semibold">Status</span>
            <span>
                @if($correction->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-xs font-medium">Pending</span>
                @elseif($correction->status == 'approved')
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-medium">Approved</span>
                @else
                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-medium">Rejected</span>
                @endif
            </span>
        </div>
    </div>

    {{-- Hanya tampil jika masih pending --}}
    @if($correction->status === 'pending')
        <hr class="my-6">

        <form method="POST" action="{{ route('admin.corrections.update', $correction->id) }}" class="space-y-4">
            @csrf
            <input type="hidden" name="status" id="statusInput" value="">

            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar (opsional)</label>
                <textarea name="comment" id="comment" rows="3"
                    placeholder="Tuliskan komentar atau alasan..."
                    class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2 text-sm"></textarea>
            </div>

            <div class="flex justify-between items-center pt-2">
                <div class="space-x-2">
                    <button type="button" onclick="setStatus('approved')" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                        Approve
                    </button>
                    <button type="button" onclick="setStatus('rejected')" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                        Reject
                    </button>
                </div>

                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                    Submit
                </button>
            </div>
        </form>

        <script>
            function setStatus(value) {
                document.getElementById('statusInput').value = value;
            }
        </script>
    @else
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
            <p><strong>Status akhir:</strong> {{ ucfirst($correction->status) }}</p>
            <p><strong>Komentar Admin:</strong> {{ $correction->comment ?? '-' }}</p>
        </div>
    @endif
</div>
@endsection
