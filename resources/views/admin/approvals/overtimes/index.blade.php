@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Persetujuan Lembur</h2>
    </div>

    <!-- 🔍 Filter Manual -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <input type="text" id="filterKaryawan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Karyawan">
        <input type="text" id="filterTanggal" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Tanggal">
        <input type="text" id="filterDurasi" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Durasi">
        <input type="text" id="filterAlasan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Alasan">
        <select id="filterStatus" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="">Semua Status</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
        </select>
        <button id="resetFilter"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
            Reset
        </button>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table id="overtimeTable" class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Karyawan</th>
                    <th class="border px-3 py-2">Tanggal</th>
                    <th class="border px-3 py-2">Durasi</th>
                    <th class="border px-3 py-2">Alasan</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overtimes as $overtime)
                <tr>
                    <td class="border px-3 py-2">{{ $overtime->employee->name ?? '-' }}</td>
                    <td class="border px-3 py-2">{{ $overtime->date }}</td>
                    <td class="border px-3 py-2">{{ $overtime->duration }} jam</td>
                    <td class="border px-3 py-2">{{ $overtime->reason ?? '-' }}</td>
                    <td class="border px-3 py-2">
                        <span class="px-2 py-1 rounded text-white 
                            {{ $overtime->status == 'approved' ? 'bg-green-500' : ($overtime->status == 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                            {{ ucfirst($overtime->status) }}
                        </span>
                    </td>
                    <td class="border px-3 py-2 text-center">
                        <a href="{{ route('admin.overtimes.show', $overtime->id) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
    {{-- DataTables & Buttons --}}
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
        var table = $('#overtimeTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            dom: 'Bfrtip', // ✅ tombol muncul di atas tabel
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export ke Excel',
                    className: 'bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700',
                    title: 'Daftar Pengajuan Lembur',
                    exportOptions: {
                            columns: [0, 1, 2, 3, 4] // kolom yang diexport (tanpa kolom Aksi)
                    }
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

        // 🔍 Filter manual
        $('#filterKaryawan').on('keyup', function() {
            table.column(0).search(this.value).draw();
        });
        $('#filterTanggal').on('keyup', function() {
            table.column(1).search(this.value).draw();
        });
        $('#filterDurasi').on('keyup', function() {
            table.column(2).search(this.value).draw();
        });
        $('#filterAlasan').on('keyup', function() {
            table.column(3).search(this.value).draw();
        });
        $('#filterStatus').on('change', function() {
            table.column(4).search(this.value).draw();
        });

        $('#resetFilter').on('click', function() {
        $('#filterKaryawan, #filterTanggal, #filterDurasi, #filterAlasan').val('');
        table.columns().search('').draw();
    });
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
