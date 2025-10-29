@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Karyawan</h1>
        <a href="{{ route('admin.employee.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ Tambah Karyawan</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

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
        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M3 4a1 1 0 011-1h12a1 1 0 01.894 1.447l-4.382 8.764A1 1 0 0111 13v3a1 1 0 01-1.447.894l-2-1A1 1 0 017 15v-2.236L2.106 4.447A1 1 0 013 4z"
                clip-rule="evenodd" />
        </svg>
        Filter
    </h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input type="text" id="filterNama" placeholder="Cari Nama" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
        <input type="text" id="dateRange" placeholder="Rentang Tanggal"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400" />
        <select id="filterStatus" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
        <button id="resetFilter"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
                Reset
        </button>
    </div>
    </div>

    {{-- 🧮 Tabel --}}
    <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
        <table id="employeeTable" class="stripe hover w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Telepon</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Tanggal Masuk</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $employee->name }}</td>
                        <td class="px-4 py-2">{{ $employee->user->email ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $employee->phone ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-3 py-1 rounded-full text-xs 
                                {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $employee->hire_date ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.employee.edit', $employee->id) }}" 
                               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 mr-2">
                                Edit
                            </a>
                            <form action="{{ route('admin.employee.destroy', $employee->id) }}" 
                                  method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-800 delete-btn">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Belum ada karyawan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- DataTables + Buttons --}}
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
    // ✅ Inisialisasi DataTable
    const table = $('#employeeTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'lrtip',
    });

    // ✅ Filter manual
    $('#filterNama').on('keyup', function() {
        table.column(0).search(this.value).draw();
    });
    $('#filterStatus').on('change', function() {
        table.column(3).search(this.value).draw();
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

    // ✅ Reset all filter
    $('#resetFilter').click(function () {
        $('#filterNama, #filterStatus, #dateRange').val('');
        table.search('').columns().search('').draw();
    });

    // ✅ SweetAlert konfirmasi hapus
    $('.delete-btn').on('click', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data karyawan akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
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
