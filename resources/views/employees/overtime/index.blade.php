@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan Lembur</h1>
        <a href="{{ route('employees.overtime.select') }}" 
           class="inline-flex items-center border border-indigo-500 text-indigo-600 px-5 py-2.5 rounded-full text-sm font-medium hover:bg-indigo-600 hover:text-white transition-all duration-200 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajukan Lembur
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($overtimes->isEmpty())
        <div class="text-center text-gray-500 py-8">
            Belum ada pengajuan lembur.
        </div>
    @else

    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <input type="text" id="filterTanggal" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Tanggal">
        <input type="text" id="filterMulai" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Jam Mulai">
        <input type="text" id="filterSelesai" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Jam Selesai">
        <input type="text" id="filterDurasi" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Durasi">
        <input type="text" id="filterAlasan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Alasan">
        <select id="filterStatus" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="">Semua Status</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
        </select>
        <input type="text" id="filterKomentar" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Cari Komentar">
        <button id="resetFilter"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
            Reset
        </button>
    </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table id="overtimeTable" class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Jam Mulai</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Jam Selesai</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Durasi</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Alasan</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($overtimes as $overtime)
                        <tr class="border-b hover:bg-indigo-50 transition">
                            <td class="p-4 text-gray-700">{{ $no++ }}</td>
                            <td class="p-4 text-gray-700">{{ \Carbon\Carbon::parse($overtime->date)->format('d M Y') }}</td>
                            <td class="p-4 text-gray-700">{{ $overtime->start_time }}</td>
                            <td class="p-4 text-gray-700">{{ $overtime->end_time }}</td>
                            <td class="p-4 text-gray-700">{{ $overtime->duration }} jam</td>
                            <td class="p-4 text-gray-700">{{ $overtime->reason }}</td>
                            <td class="p-4">
                                @if($overtime->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                @elseif($overtime->status == 'approved')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Approved</span>
                                @elseif($overtime->status == 'rejected')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Rejected</span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b text-center">
                                {{ $overtime->comment ?? '-' }}
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7] // kolom yang diexport (tanpa kolom Aksi)
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
        $('#filterTanggal').on('keyup', function() {
            table.column(1).search(this.value).draw();
        });
        $('#filterMulai').on('keyup', function() {
            table.column(2).search(this.value).draw();
        });
        $('#filterSelesai').on('keyup', function() {
            table.column(3).search(this.value).draw();
        });
        $('#filterDurasi').on('keyup', function() {
            table.column(4).search(this.value).draw();
        });
        $('#filterAlasan').on('keyup', function() {
            table.column(5).search(this.value).draw();
        });
        $('#filterStatus').on('change', function() {
            table.column(6).search(this.value).draw();
        });
        $('#filterKomentar').on('change', function() {
            table.column(7).search(this.value).draw();
        });
        
        $('#resetFilter').on('click', function() {
        $('#filterTanggal, #filterMulai, #filterSelesai, #filterDurasi, #filterAlasan, #filterKomentar').val('');
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
