@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Koreksi Absensi</h1>

        <a href="{{ route('employees.corrections.select') }}"
           class="inline-flex items-center border border-green-500 text-green-600 px-5 py-2.5 rounded-full text-sm font-medium hover:bg-green-600 hover:text-white transition-all duration-200 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajukan Koreksi
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Manual -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <input type="text" id="filterTanggal" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Tanggal">
        <input type="text" id="filterClockInLama" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Clock In Lama">
        <input type="text" id="filterClockInBaru" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Clock In Baru">
        <input type="text" id="filterClockOutLama" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Clock Out Lama">
        <input type="text" id="filterClockOutBaru" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Clock Out Baru">
        <input type="text" id="filterAlasan" class="border border-gray-300 rounded-lg p-2 text-sm" placeholder="Cari Alasan">
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
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Clock In Lama</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Clock In Baru</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Clock Out Lama</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Clock Out Baru</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Alasan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($corrections as $correction)
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $no++ }}</td>
                        <td class="p-4 text-gray-700">{{ $correction->date }}</td>
                        <td class="p-4 text-gray-700">{{ $correction->old_clock_in ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $correction->new_clock_in ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $correction->old_clock_out ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $correction->new_clock_out ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $correction->reason ?? '-' }}</td>
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
                        <td class="p-4">
                            <a href="{{ route('employees.corrections.show', $correction->id) }}"
                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-gray-500">
                            Belum ada pengajuan koreksi absensi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<!-- ✅ DataTables & Buttons CDN -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

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
    $('#filterTanggal').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });
    $('#filterClockInLama').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });
    $('#filterClockInBaru').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });
    $('#filterClockOutLama').on('keyup', function() {
        table.column(4).search(this.value).draw();
    });
    $('#filterClockOutBaru').on('keyup', function() {
        table.column(5).search(this.value).draw();
    });
    $('#filterAlasan').on('keyup', function() {
        table.column(6).search(this.value).draw();
    });
    $('#filterStatus').on('change', function() {
        table.column(7).search(this.value).draw();
    });
    $('#resetFilter').on('click', function() {
        $('#filterTanggal, #filterClockInLama, #filterClockInBaru, #filterClockOutLama, #filterClockOutBaru, #filterAlasan').val('');
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