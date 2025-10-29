@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Persetujuan Lembur</h2>
    </div>

    <!-- 🔍 Filter Manual -->
    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl mb-5">
        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M3 4a1 1 0 011-1h12a1 1 0 01.894 1.447l-4.382 8.764A1 1 0 0111 13v3a1 1 0 01-1.447.894l-2-1A1 1 0 017 15v-2.236L2.106 4.447A1 1 0 013 4z"
                clip-rule="evenodd" />
        </svg>
        Filter
    </h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
            <input type="text" id="filterKaryawan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400" placeholder="Cari Karyawan">
            <input type="text" id="dateRange" placeholder="Rentang Tanggal"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400" />
            <select id="filterStatus" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400">
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
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
        <table id="overtimeTable" class="stripe hover w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Karyawan</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Durasi</th>
                    <th class="px-4 py-2 text-left">Alasan</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overtimes as $overtime)
                <tr>
                    <td class="px-4 py-2">{{ $overtime->employee->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $overtime->date }}</td>
                    <td class="px-4 py-2">{{ $overtime->duration }} jam</td>
                    <td class="px-4 py-2">{{ $overtime->reason ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @if($overtime->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                        @elseif($overtime->status == 'approved')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Approved</span>
                        @elseif($overtime->status == 'rejected')
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Rejected</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.overtimes.show', $overtime->id) }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition">Detail</a>
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
    $(document).ready(function() {
        var table = $('#overtimeTable').DataTable({
            responsive: true,
            pageLength: 10,
            dom: 'lrtip',
        });

        // 🔍 Filter manual
        $('#filterKaryawan').on('keyup', function() {
            table.column(0).search(this.value).draw();
        });
       
        $('#filterStatus').on('change', function() {
            table.column(4).search(this.value).draw();
        });

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
        $('#filterKaryawan, #filterTanggal, #filterDurasi, #filterAlasan').val('');
        table.columns().search('').draw();
    });
    });
    </script>

    {{-- Styling tambahan untuk DataTables agar serasi dengan Tailwind --}}
    <style>
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
