@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Izin / Sakit</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🔍 Filter Manual --}}
    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl mb-5">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <input type="text" id="filterJenis" placeholder="Cari Jenis"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <input type="text" id="filterTanggal" placeholder="Cari Tanggal"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <input type="text" id="filterHari" placeholder="Cari Total Hari"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <select id="filterStatus"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
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
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table id="sickTable" class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">No</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Jenis</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Total Hari</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($requests as $leave)
                    @if($leave->leaveType->type !== 'izin_sakit')
                        @continue
                    @endif
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $no++ }}</td>
                        <td class="p-4 text-gray-700">{{ $leave->leaveType->name ?? '-' }}</td>
                        <td class="p-4 text-gray-700">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                        <td class="p-4 text-gray-700">{{ $leave->total_days }} hari</td>
                        <td class="p-4">
                            @if($leave->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                            @elseif($leave->status == 'approved')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Approved</span>
                            @elseif($leave->status == 'rejected')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Rejected</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('admin.approvals.izin_sakit.show', $leave->id) }}" 
                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center text-gray-500">Belum ada pengajuan.</td>
                    </tr>
                @endforelse
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
        $(document).ready(function () {
            const table = $('#sickTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                dom: 'Bfrtip', // ✅ tombol muncul di atas tabel
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export ke Excel',
                        className: 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm',
                        title: 'Daftar Pengajuan Izin/Sakit',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // kolom yang diexport (tanpa kolom Aksi)
                        }
                    }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: { previous: "Sebelumnya", next: "Berikutnya" },
                    zeroRecords: "Tidak ditemukan data.",
                },
                columnDefs: [
                    { orderable: false, targets: [5] }
                ]
            });

            // Filter Manual
            $('#filterJenis').on('keyup change', function() {
                table.column(1).search(this.value).draw();
            });

            $('#filterTanggal').on('keyup change', function() {
                table.column(2).search(this.value).draw();
            });

            $('#filterHari').on('keyup change', function() {
                table.column(3).search(this.value).draw();
            });

            $('#filterStatus').on('change', function() {
                table.column(4).search(this.value).draw();
            });

            $('#resetFilter').on('click', function() {
                $('#filterJenis, #filterTanggal, #filterHari, #filterStatus').val('');
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