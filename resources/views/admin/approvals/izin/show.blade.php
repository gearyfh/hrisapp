@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Detail Pengajuan Izin / Sakit</h1>
    </div>

    <!-- Detail Data -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-8">
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

        <div class="md:col-span-2 bg-gray-50 p-5 rounded-lg border border-gray-100">
            <p class="text-gray-500 mb-1">📝 Alasan</p>
            <p class="font-semibold text-gray-800 leading-relaxed">{{ $leave->reason ?? '-' }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <p class="text-gray-500">Status</p>
            <div class="mt-2">
                @if($leave->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">⏳ Pending</span>
                @elseif($leave->status == 'approved')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">✅ Approved</span>
                @else
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">❌ Rejected</span>
                @endif
            </div>
        </div>

        @if($leave->attachment)
        <div class="md:col-span-2 bg-gray-50 p-5 rounded-lg border border-gray-100">
            <p class="text-gray-500 mb-2">📎 Lampiran</p>
            <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank"
               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Lihat Lampiran
            </a>
        </div>
        @endif
    </div>

    <!-- Form Approve / Reject (jika masih pending) -->
    @if($leave->status === 'pending')
        <form method="POST" action="{{ route('admin.approvals.update', $leave->id) }}" class="space-y-4">
            @csrf
            <input type="hidden" name="status" id="statusInput">

            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                    Komentar (opsional)
                </label>
                <textarea name="comment" id="comment" rows="3"
                    placeholder="Tuliskan komentar atau alasan..."
                    class="w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg px-3 py-2 text-sm"></textarea>
            </div>

            <div class="flex justify-between items-center pt-4">
                <div class="space-x-2">
                    <button type="submit" onclick="setStatus('approved')" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                        Approve
                    </button>
                    <button type="submit" onclick="setStatus('rejected')" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                        Reject
                    </button>
                </div>

                <div class="space-x-2">
                    <a href="{{ route('admin.approvals.izin_sakit') }}" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
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
        <!-- Jika status sudah final -->
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-5 text-sm text-gray-700">
            <p><strong>Status akhir:</strong> 
                @if($leave->status === 'approved')
                    ✅ Approved
                @elseif($leave->status === 'rejected')
                    ❌ Rejected
                @else
                    ⏳ Pending
                @endif
            </p>
            <p class="mt-1"><strong>Komentar Admin:</strong> {{ $leave->comment ?? '-' }}</p>
        </div>
    @endif
</div>
@endsection
