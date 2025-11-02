@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Dokumen Karyawan</h1>
    </div>

    @if ($employee->documents->isEmpty())
        <p>Tidak ada dokumen yang diunggah.</p>
    @else

    {{-- 🔍 Filter Manual --}}
    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl mb-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M3 4a1 1 0 011-1h12a1 1 0 01.894 1.447l-4.382 8.764A1 1 0 0111 13v3a1 1 0 01-1.447.894l-2-1A1 1 0 017 15v-2.236L2.106 4.447A1 1 0 013 4z"
                clip-rule="evenodd" />
        </svg>
        Filter
    </h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <input type="text" id="filterFile" placeholder="Cari File"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <input type="text" id="filterKategori" placeholder="Cari Kategori"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <input type="text" id="dateRange" placeholder="Rentang Tanggal"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400" />
            <button id="resetFilter"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
                Reset
            </button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table id="documentsTable" class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Nama File</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal Upload</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee->documents as $index => $doc)
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $index + 1 }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->nama_file }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->tipe ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->created_at->format('d M Y') }}</td>
                        <td class="p-4">
                            <a href="{{ asset($doc->path) }}" target="_blank"
                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">
                                Lihat
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

@section('scripts')
{{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {
    // Inisialisasi DataTable
    var table = $('#documentsTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'lrtip',
        language: {
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "‹", next: "›" },
        },
    });

    // Filter Manual
    $('#filterFile').on('keyup change', function() {
        table.column(1).search(this.value).draw();
    });

    $('#filterKategori').on('keyup change', function() {
        table.column(2).search(this.value).draw();
    });

    // ✅ Date Range Picker Setup
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function() {
                table.draw();
            }
        });

        // ✅ Custom filter untuk tanggal
        $.fn.dataTable.ext.search.push(function(settings, data) {
            const range = $('#dateRange').val();
            if (!range.includes(" to ")) return true;

            const [startDate, endDate] = range.split(" to ");
            if (!startDate || !endDate) return true;

            const rowDate = data[2]?.split(" - ")[0] ?? null;
            if (!rowDate) return true;

            const date = new Date(rowDate);
            return date >= new Date(startDate) && date <= new Date(endDate);
        });

    $('#resetFilter').on('click', function() {
        $('#filterFile, #filterKategori, #dateRange').val('');
        table.columns().search('').draw();
    });
});
</script>

<style>
    /* 🌿 Area filter card */
    .filter-card {
        //background: linear-gradient(to right, #f9fafb, #f3f4f6);
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
    }

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
