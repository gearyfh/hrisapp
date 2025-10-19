@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row gap-6">
        {{-- Card Absensi --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg w-full md:w-1/2 self-start">
            <h2 class="text-2xl font-semibold mb-4 text-center">Absensi</h2>
            <hr class="border-gray-400 mb-4">

            <div class="grid grid-cols-2 divide-x divide-black text-center">
                {{-- Check In --}}
                <div>
                    <p class="text-sm text-gray-700">
                        {{ $attendance ? \Carbon\Carbon::parse($attendance->tanggal_masuk)->translatedFormat('l, d M Y') : \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
                    </p>

                    <p class="text-4xl font-bold my-3">
                        @if($attendance && $attendance->jam_masuk)
                            {{ \Carbon\Carbon::parse($attendance->jam_masuk)->format('H.i') }}
                        @else
                            {{ \Carbon\Carbon::now()->format('H.i') }}
                        @endif
                    </p>

                    @if(!$attendance)
                        <form action="{{ route('employees.attendance.absensi_create') }}" method="GET">
                            @csrf
                            <button type="submit"
                                class="border border-gray-400 text-black px-6 py-2 rounded-full hover:bg-green-600 hover:text-white hover:border-none transition">
                                Check In
                            </button>
                        </form>
                    @else
                        <button class="bg-gray-400 text-white px-6 py-2 rounded-full cursor-not-allowed">
                            Checked In
                        </button>
                    @endif
                </div>

                {{-- Check Out --}}
                <div>
                    <p class="text-sm text-gray-700">
                        {{ $attendance && $attendance->tanggal_keluar ? \Carbon\Carbon::parse($attendance->tanggal_keluar)->translatedFormat('l, d M Y') : \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
                    </p>

                    <p class="text-4xl font-bold my-3">
                        @if($attendance && $attendance->jam_keluar)
                            {{ \Carbon\Carbon::parse($attendance->jam_keluar)->format('H.i') }}
                        @else
                            {{ \Carbon\Carbon::now()->format('H.i') }}
                        @endif
                    </p>

                    @if($attendance && !$attendance->jam_keluar)
                        <form action="{{ route('employees.checkout') }}" method="POST" class="checkout-form">
                            @csrf
                            <button type="submit"
                                class="checkout-btn border border-gray-400 text-black px-6 py-2 rounded-full hover:bg-red-600 hover:text-white hover:border-none transition">
                                Check Out
                            </button>
                        </form>
                    @elseif($attendance && $attendance->jam_keluar)
                        <button class="bg-gray-400 text-white px-6 py-2 rounded-full cursor-not-allowed">
                            Checked Out
                        </button>
                    @else
                        <button class="bg-gray-400 text-white px-6 py-2 rounded-full cursor-not-allowed">
                            Check Out
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- History --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg w-full md:w-3/4 overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">History Absensi</h2>

            <table class="w-full border-collapse text-sm text-gray-700">
                <thead class="bg-gray-300 text-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left">Jenis</th>
                        <th class="px-4 py-2 text-left">Tanggal Masuk</th>
                        <th class="px-4 py-2 text-left">Jam Masuk</th>
                        <th class="px-4 py-2 text-left">Tanggal Keluar</th>
                        <th class="px-4 py-2 text-left">Jam Keluar</th>
                        <th class="px-4 py-2 text-left">Lokasi</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-100 divide-y divide-gray-300">
                    @forelse ($attendances as $absen)
                        <tr class="hover:bg-white transition">
                            <td class="px-4 py-2">{{ $absen->jenis }}</td>
                            <td class="px-4 py-2">{{ $absen->tanggal_masuk }}</td>
                            <td class="px-4 py-2">{{ $absen->jam_masuk }}</td>
                            <td class="px-4 py-2">{{ $absen->tanggal_keluar }}</td>
                            <td class="px-4 py-2">{{ $absen->jam_keluar }}</td>
                            <td class="px-4 py-2 truncate max-w-[250px]" title="{{ $absen->lokasi }}">{{ $absen->lokasi }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                Belum ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".checkout-form").forEach(form => {
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin ingin Check Out?',
                text: "Pastikan Anda sudah menyelesaikan pekerjaan hari ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Check Out',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'swal-popup-rounded',
                    confirmButton: 'swal-btn-confirm',
                    cancelButton: 'swal-btn-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

<style>
.swal-popup-rounded {
    border-radius: 1.5rem !important;
    padding: 2rem !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
.swal-btn-confirm, .swal-btn-cancel {
    border-radius: 9999px !important;
    padding: 0.5rem 1.5rem !important;
    font-weight: 600;
    transition: all 0.2s ease;
}
.swal-btn-confirm:hover { background-color: #b91c1c !important; }
.swal-btn-cancel:hover { background-color: #2563eb !important; }
</style>
@endsection
