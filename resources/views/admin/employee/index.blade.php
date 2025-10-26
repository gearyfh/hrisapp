@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-5">
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
        <input type="text" id="filterNama" placeholder="Cari Nama" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
        <input type="text" id="filterEmail" placeholder="Cari Email" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
        <input type="text" id="filterTelepon" placeholder="Cari Telepon" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
        <select id="filterStatus" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
        <input type="text" id="filterTanggal" placeholder="Cari Tanggal Masuk" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
        <button id="resetFilter"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
                Reset
        </button>
        <div></div> {{-- biar grid tetap rapi --}}
    </div>

    {{-- 🧮 Tabel --}}
    <div class="overflow-x-auto">
        <table id="employeeTable" class="min-w-full text-sm border">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Email</th>
                    <th class="p-3 border">Telepon</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Tanggal Masuk</th>
                    <th class="p-3 border text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr class="text-gray-700 hover:bg-gray-50">
                        <td class="border p-3">{{ $employee->name }}</td>
                        <td class="border p-3">{{ $employee->user->email ?? '-' }}</td>
                        <td class="border p-3">{{ $employee->phone ?? '-' }}</td>
                        <td class="border p-3">
                            <span class="px-3 py-1 rounded-full text-xs 
                                {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                        <td class="border p-3">{{ $employee->hire_date ?? '-' }}</td>
                        <td class="border p-3 text-center">
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

<script>
$(document).ready(function() {
    // ✅ Inisialisasi DataTable
    const table = $('#employeeTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', text: 'Export Excel', className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700' },
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            paginate: { previous: "Sebelumnya", next: "Berikutnya" },
            zeroRecords: "Tidak ditemukan data."
        },
        columnDefs: [
            { orderable: false, targets: [5] } // kolom aksi tidak bisa di-sort
        ]
    });

    // ✅ Filter manual
    $('#filterNama').on('keyup', function() {
        table.column(0).search(this.value).draw();
    });
    $('#filterEmail').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });
    $('#filterTelepon').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });
    $('#filterStatus').on('change', function() {
        table.column(3).search(this.value).draw();
    });
    $('#filterTanggal').on('keyup', function() {
        table.column(4).search(this.value).draw();
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
@endsection
