@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-10 border border-gray-100 transition hover:shadow-xl">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Pengajuan Cuti</h1>
        </div>
    </div>

    <!-- Detail Data -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-6">

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Pegawai</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->employee->name ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Jenis Izin</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->leaveType->name ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Tanggal</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->start_date }} – {{ $leave->end_date }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Total Hari</p>
            <p class="font-semibold text-gray-800 mt-1">{{ $leave->total_days }} hari</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 md:col-span-2 md:max-w-lg">
            <p class="text-gray-500">Status</p>
            <div class="mt-2">
                @if($leave->status == 'pending')
                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">
                        ⏳ Pending
                    </span>
                @elseif($leave->status == 'approved')
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">
                        ✅ Approved
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">
                        ❌ Rejected
                    </span>
                @endif
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                <p class="text-gray-500 mb-1">📝 Alasan</p>
                <p class="font-semibold text-gray-800 leading-relaxed">{{ $leave->reason ?? '-' }}</p>
            </div>
        </div>

        @if($leave->attachment)
        <div class="md:col-span-2">
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                <p class="text-gray-500 mb-2">📎 Lampiran</p>
                <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4v16m8-8H4" />
                    </svg>
                    Lihat Lampiran
                </a>
            </div>
        </div>
        @endif

        @if($leave->comment)
        <div class="md:col-span-2">
            <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4">
                <p class="text-gray-500 mb-1">💬 Komentar HR / Atasan</p>
                <p class="text-gray-800">{{ $leave->comment }}</p>
            </div>
        </div>
        @endif
    </div>


    {{-- Form hanya tampil jika status pending --}}
    @if($leave->status === 'pending')
        <form method="POST" action="{{ route('admin.approvals.update', $leave->id) }}" class="space-y-5">
            @csrf
            <input type="hidden" name="status" id="statusInput">

            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar (opsional)</label>
                <textarea name="comment" id="comment" rows="3"
                    placeholder="Tuliskan komentar atau alasan persetujuan/penolakan..."
                    class="w-full border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg px-3 py-2 text-sm bg-gray-50 transition"></textarea>
            </div>

            <div class="flex flex-wrap justify-between items-center pt-2">
                <div class="flex flex-wrap gap-2">
                    <button type="submit" onclick="setStatus('approved')"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                        Approve
                    </button>
                    <button type="submit" onclick="setStatus('rejected')"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                        Reject
                    </button>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.approvals.cuti') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition">
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
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-5 text-sm text-gray-700">
            <p><strong>Status akhir:</strong> {{ ucfirst($leave->status) }}</p>
            <p><strong>Komentar Admin:</strong> {{ $leave->comment ?? '-' }}</p>
        </div>
    @endif
</div>
@endsection
