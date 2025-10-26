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
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <input type="text" id="filterFile" placeholder="Cari File"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <input type="text" id="filterKategori" placeholder="Cari Kategori"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <input type="text" id="filterTanggal" placeholder="Cari Tanggal Upload"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
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
        lengthMenu: [5, 10, 25, 50],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                className: 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm',
                title: 'Daftar Dokumen Karyawan',
                exportOptions: { columns: [0, 1, 2, 3]
                }
            },
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: { previous: "‹", next: "›" },
            zeroRecords: "Tidak ditemukan data yang cocok"
        },
        columnDefs: [
            { orderable: false, targets: [4] }
        ]
    });

    // Filter Manual
    $('#filterFile').on('keyup change', function() {
        table.column(1).search(this.value).draw();
    });

    $('#filterKategori').on('keyup change', function() {
        table.column(2).search(this.value).draw();
    });

    $('#filterTanggal').on('keyup change', function() {
        table.column(3).search(this.value).draw();
    });
    
    $('#resetFilter').on('click', function() {
        $('#filterFile, #filterKategori, #filterTanggal').val('');
        table.columns().search('').draw();
    });

    // // Filter manual per kolom
    // $('#documentsTable thead tr:eq(1) th input').on('keyup change', function () {
    //     table
    //         .column($(this).parent().index())
    //         .search(this.value)
    //         .draw();
    // });
});
</script>

{{-- Styling tambahan untuk DataTables agar serasi dengan Tailwind --}}
    <style>
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 6px 10px;
            margin-left: 0.5em;
            outline: none;
            transition: all 0.2s;
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
