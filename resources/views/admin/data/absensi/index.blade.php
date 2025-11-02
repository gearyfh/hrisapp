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
    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl mb-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M3 4a1 1 0 011-1h12a1 1 0 01.894 1.447l-4.382 8.764A1 1 0 0111 13v3a1 1 0 01-1.447.894l-2-1A1 1 0 017 15v-2.236L2.106 4.447A1 1 0 013 4z"
                clip-rule="evenodd" />
        </svg>
        Filter
    </h2>
    <form method="GET" action="{{ route('admin.data.absensi.index') }}" class="flex items-center gap-2 mb-4">

        {{-- Input bulan --}}
        <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

        {{-- Search nama --}}
        <input type="text" name="search" placeholder="Cari nama..."
               value="{{ request('search') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

        {{-- Sorting --}}
        <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
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
    </div>

    <table id="recapTable" class="min-w-full border border-gray-200 text-sm text-left">
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
                    <td class="p-2 text-center">{{ $data->work_days }}</td>
                    <td class="p-2 text-center">{{ number_format($data->work_hours, 1) }}</td>
                    <td class="p-2 text-center">{{ number_format($data->overtime_hours, 1) }}</td>
                    <td class="p-2 text-center font-semibold">
                        {{ number_format($data->total_hours, 1) }}
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
@section('scripts')
{{-- ✅ DataTables & Buttons --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.6/sorting/natural.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
$(document).ready(function() {
    // ✅ Inisialisasi DataTable
    const table = $('#recapTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: '<"flex justify-between items-center mb-3"B>lrtip', // Tambahkan posisi tombol
        buttons: [
            {
                extend: 'excelHtml5',
                text: '📊 Export to Excel',
                className: 'bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition text-sm',
                title: 'Activity Logs',
                exportOptions: {
                    columns: ':not(:last-child)' // ⛔ tidak export kolom aksi
                }
            }
        ],
        language: {
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "‹", next: "›" },
        },
        columnDefs: [
            { type: 'natural', targets: 0 } // 👈 kolom pertama (Nama)
        ]
    });
});
</script>

{{-- 💅 Tambahan gaya agar serasi dengan Tailwind --}}
<style>
    /* 📋 Tombol Excel modern */
    .dt-button {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(to right, #16a34a, #22c55e) !important;
        color: white !important;
        border: none !important;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        box-shadow: 0 2px 6px rgba(34, 197, 94, 0.3);
        transition: all 0.25s ease;
    }

    .dt-button:hover {
        background: linear-gradient(to right, #15803d, #16a34a);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(34, 197, 94, 0.4);
    }

    /* 📊 Table styling lembut */
    table.dataTable thead th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    table.dataTable tbody td {
        border-bottom: 1px solid #f1f5f9;
        padding: 0.9rem 1rem;
    }

    table.dataTable tbody tr:hover {
        background-color: #f9fafb;
        transition: background 0.2s ease;
    }

    /* 📎 Pagination dan info text */
    .dataTables_wrapper .dataTables_info {
        color: #4b5563;
        font-size: 0.875rem;
        margin-top: 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: none;
        border-radius: 0.375rem;
        padding: 5px 10px;
        margin: 0 2px;
        background: #f3f4f6;
        color: #4b5563 !important;
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e5e7eb;
        color: #111827 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #E6E6E6 !important;
        font-weight: 500;
    }

    /* 📱 Responsif */
    @media (max-width: 768px) {
        .dt-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
        }
    }

    .dataTables_wrapper .top {
        margin-bottom: 10px;
    }

    .dataTables_wrapper .bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    .dataTables_length select {
        min-width: 70px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px #c7d2fe;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 4px 6px;
        outline: none;
    }
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 0.75rem;
    }
    .dt-button {
        margin-bottom: 10px !important;
    }
</style>
@endsection
