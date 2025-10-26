@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Koreksi Absensi</h1>
    </div>

    @if($corrections->isEmpty())
        <p class="text-gray-500 text-center py-6">Belum ada pengajuan koreksi absensi.</p>
    @else
        <!-- Filter Manual -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
            <input type="text" id="filterPegawai" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Pegawai">
            <input type="text" id="filterTanggal" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Tanggal">
            <input type="text" id="filterMasukBaru" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Masuk Baru">
            <input type="text" id="filterPulangBaru" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Pulang Baru">
            <select id="filterStatus" class="border border-gray-300 rounded-lg p-2 text-sm">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
             <button id="resetFilter"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
                Reset
            </button>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table id="correctionTable" class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Pegawai</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal Masuk</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Masuk Lama</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Masuk Baru</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Pulang Lama</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Pulang Baru</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($corrections as $correction)
                        <tr class="border-b hover:bg-indigo-50 transition">
                            <td class="p-4 text-gray-700">{{ $loop->iteration }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->employee->name ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->tanggal_masuk }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->old_clock_in ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->new_clock_in ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->old_clock_out ?? '-' }}</td>
                            <td class="p-4 text-gray-700">{{ $correction->new_clock_out ?? '-' }}</td>
                            <td class="p-4">
                                @if($correction->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                @elseif($correction->status == 'approved')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Approved</span>
                                @elseif($correction->status == 'rejected')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Rejected</span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">-</span>
                                @endif
                            </td>
                            <td class="px-4">
                                <a href="{{ route('admin.corrections.show', $correction->id) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">
                                   Detail
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
<!-- ✅ DataTables & Buttons CDN -->
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
$(document).ready(function() {
    var table = $('#correctionTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                className: 'bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700'
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            },
            emptyTable: "Tidak ada data yang tersedia"
        }
    });

    // Filter manual
    $('#filterPegawai').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });
    $('#filterTanggal').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });
    $('#filterMasukBaru').on('keyup', function() {
        table.column(4).search(this.value).draw();
    });
    $('#filterPulangBaru').on('keyup', function() {
        table.column(6).search(this.value).draw();
    });
    $('#filterStatus').on('change', function() {
        table.column(7).search(this.value).draw();
    });
    $('#resetFilter').on('click', function() {
        $('#filterPegawai, #filterTanggal, #filterMasukBaru, #filterPulangBaru').val('');
        table.columns().search('').draw();
    });
});
</script>
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
