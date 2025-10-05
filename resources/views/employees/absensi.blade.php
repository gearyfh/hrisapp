@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Absensi</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-200 p-6 rounded-2xl shadow-lg text-center">
            <h2 class="text-2xl font-semibold mb-4">Absensi</h2>
            <hr class="border-black mb-4">

            <div class="grid grid-cols-2 divide-x divide-black">
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
                        <form action="{{ route('employees.absensi_create') }}" method="GET">
                            @csrf
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-full hover:bg-green-600">
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
                        <form action="{{ route('employees.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-full hover:bg-red-600">
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
        <div class="bg-gray-200 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">History Absensi</h2>
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jam</th>
                        <th class="px-4 py-2">Jenis</th>
                        <th class="px-4 py-2">Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $absen)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $absen->tanggal_masuk }}</td>
                            <td class="px-4 py-2">{{ $absen->jam_masuk }}</td>
                            <td class="px-4 py-2">{{ $absen->jenis }}</td>
                            <td class="px-4 py-2">{{ $absen->lokasi }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">
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
