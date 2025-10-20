@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6">
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-semibold text-gray-800">Detail Pengajuan Koreksi Absensi</h1>
    </div>

    <!-- Grid Detail -->
    <div class="grid grid-cols-2 gap-6 text-sm">
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Nama Karyawan</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $correction->employee->name ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Tanggal</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $correction->date }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Masuk Lama</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $correction->old_clock_in ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Masuk Baru</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $correction->new_clock_in ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Pulang Lama</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $correction->old_clock_out ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Pulang Baru</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $correction->new_clock_out ?? '-' }}</p>
        </div>

        <div class="md:col-span-2">
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                <p class="text-gray-500 mb-1">📝 Alasan Koreksi</p>
                <p class="font-semibold text-gray-800 leading-relaxed">{{ $correction->reason ?? '-' }}</p>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                <p class="text-gray-500 mb-1">Status</p>
                <p class="font-semibold mt-2">
                    @if($correction->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">⏳ Pending</span>
                    @elseif($correction->status == 'approved')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">✅ Approved</span>
                    @elseif($correction->status == 'rejected')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">❌ Rejected</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium shadow-sm">-</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Jika status masih pending --}}
    @if($correction->status === 'pending')
        <hr class="my-6">

        <form method="POST" action="{{ route('admin.corrections.update', $correction->id) }}" class="space-y-4">
            @csrf
            <input type="hidden" name="status" id="statusInput" value="">

            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                    Komentar (opsional)
                </label>
                <textarea name="comment" id="comment" rows="3"
                    placeholder="Tuliskan komentar atau alasan..."
                    class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2 text-sm"></textarea>
            </div>

            <div class="flex justify-between items-center pt-2">
                <div class="space-x-2">
                    <button type="submit" onclick="setStatus('approved')" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                        Approve
                    </button>
                    <button type="submit" onclick="setStatus('rejected')" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                        Reject
                    </button>
                </div>

                <div class="space-x-2">
                    <a href="{{ route('admin.corrections.index') }}" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                        Back
                    </a>
                </div>
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
