@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Dokumen</h2>
        <a href="{{ route('admin.documents.select') }}" class="inline-flex items-center border border-green-500 text-green-600 px-5 py-2.5 rounded-full text-sm font-medium hover:bg-green-600 hover:text-white transition-all duration-200 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
             Upload Baru
        </a>
    </div>

        <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    
     @if($documents->isEmpty())
        <p class="text-gray-500 text-center py-6">Belum ada dokumen.</p>
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
            <input type="text" id="filterDokumen" placeholder="Cari Dokumen"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <input type="text" id="filterKaryawan" placeholder="Cari Karyawan"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
            <button id="resetFilter"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
                Reset
            </button>
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
        <table id="documentTable" class="stripe hover w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Nama Dokumen</th>
                    <th class="px-4 py-2 text-left">Jenis</th>
                    <th class="px-4 py-2 text-left">Karyawan</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="p-4 text-gray-700">{{ $doc->nama_file }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->tipe }}</td>
                        <td class="p-4 text-gray-700">{{ $doc->employee->name ?? '-' }}</td>
                        <td class="p-4 text-gray-700">
                            <a href="{{ asset($doc->path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function () {
            const table = $('#documentTable').DataTable({
                responsive: true,
                pageLength: 10,
                dom: 'lrtip',
            });

            // Filter Manual
            $('#filterDokumen').on('keyup change', function() {
                table.column(0).search(this.value).draw();
            });

            $('#filterKaryawan').on('keyup change', function() {
                table.column(2).search(this.value).draw();
            });

            $('#resetFilter').on('click', function() {
                $('#filterDokumen, #filterKaryawan').val('');
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