@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Absensi</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Check In / Check Out --}}
        <div class="bg-gray-100 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4 text-center">Check In</h2>
            <hr class="mb-4">

            <p class="text-center text-gray-600">
                {{ \Carbon\Carbon::now()->format('l, d M Y') }}
            </p>
            <p class="text-center text-3xl font-bold my-4">
                {{ \Carbon\Carbon::now()->format('H:i') }}
            </p>

            <div class="flex justify-center">
                <a href="{{ route('employees.absensi_create') }}" 
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-full hover:bg-gray-800">
                        Check In
                    </button>
                </a>
            </div>
        </div>

        {{-- History --}}
        <div class="bg-gray-100 p-6 rounded-lg shadow">
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
                            <td class="px-4 py-2">{{ $absen->tanggal }}</td>
                            <td class="px-4 py-2">{{ $absen->jam }}</td>
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
