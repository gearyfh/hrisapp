@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Rekap Total Jam Kerja Karyawan</h2>

        {{-- ✅ Tombol update realtime --}}
        <form action="{{ route('admin.work-summary.update') }}" method="POST">
            @csrf
            <input type="hidden" name="month" value="{{ request('month', now()->format('Y-m')) }}">
            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 text-sm">
                Update Sekarang ⟳
            </button>
        </form>
    </div>

    {{-- Filter Bulan --}}
    <form method="GET" action="{{ route('admin.data.absensi.index') }}" class="flex items-center gap-2 mb-4">

        {{-- Input bulan --}}
        <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}"
               class="border rounded-md px-3 py-1">

        {{-- Search nama --}}
        <input type="text" name="search" placeholder="Cari nama..."
               value="{{ request('search') }}"
               class="border rounded-md px-3 py-1">

        {{-- Sorting --}}
        <select name="sort" class="border rounded-md px-2 py-1">
            <option value="">Urutan Default</option>
            <option value="name_asc" {{ request('sort')=='name_asc'?'selected':'' }}>Nama A → Z</option>
            <option value="name_desc" {{ request('sort')=='name_desc'?'selected':'' }}>Nama Z → A</option>
            <option value="hours_desc" {{ request('sort')=='hours_desc'?'selected':'' }}>Total Jam Tertinggi</option>
            <option value="hours_asc" {{ request('sort')=='hours_asc'?'selected':'' }}>Total Jam Terendah</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
            Filter
        </button>

    </form>

    <table class="min-w-full border border-gray-200 text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border text-center">Hari Kerja</th>
                <th class="p-2 border text-center">Jam Kerja</th>
                <th class="p-2 border text-center">Jam Lembur</th>
                <th class="p-2 border text-center">Total Jam</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekap as $data)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $data->employee->name }}</td>
                    <td class="p-2 text-center">{{ $data->total_days_worked }}</td>
                    <td class="p-2 text-center">{{ number_format($data->total_work_hours, 1) }}</td>
                    <td class="p-2 text-center">{{ number_format($data->total_overtime_hours, 1) }}</td>
                    <td class="p-2 text-center font-semibold">
                        {{ number_format($data->total_work_hours + $data->total_overtime_hours, 1) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-3 text-gray-500">
                        Tidak ada data ditemukan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
@endsection
