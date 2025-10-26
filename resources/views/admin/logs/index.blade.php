@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-4">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-semibold text-gray-800">🪵 Activity Logs</h2>
    </div>

    {{-- 🔍 Filter Manual --}}
    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl mb-5">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 text-sm">
            <input type="text" id="filterTanggal" placeholder="Cari tanggal..."
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <input type="text" id="filterUser" placeholder="Cari user..."
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <input type="text" id="filterAksi" placeholder="Cari aksi..."
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <input type="text" id="filterDeskripsi" placeholder="Cari deskripsi..."
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <button id="resetFilter"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-3 py-2 rounded-lg font-medium transition">
                Reset
        </button>
        </div>
    </div>

    {{-- 🧮 Tabel Data --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
        <table id="logTable" class="min-w-full text-sm text-gray-700 border-collapse">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                    <th class="px-4 py-2 text-left">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="border-b hover:bg-gray-100 transition">
                    <td class="px-4 py-2">{{ $log->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2">{{ $log->user->name ?? 'System' }}</td>
                    <td class="px-4 py-2 font-semibold">{{ ucfirst($log->action) }}</td>
                    <td class="px-4 py-2">{{ $log->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
{{-- ✅ DataTables & Buttons --}}
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
    const table = $('#logTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', text: 'Export Excel', className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700' },
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ entri",
            paginate: { previous: "Sebelumnya", next: "Berikutnya" },
            zeroRecords: "Tidak ditemukan data."
        }
    });

    // ✅ Filter Manual per Kolom
    $('#filterTanggal').on('keyup change', function() {
        table.column(0).search(this.value).draw();
    });
    $('#filterUser').on('keyup change', function() {
        table.column(1).search(this.value).draw();
    });
    $('#filterAksi').on('keyup change', function() {
        table.column(2).search(this.value).draw();
    });
    $('#filterDeskripsi').on('keyup change', function() {
        table.column(3).search(this.value).draw();
    });
});
</script>

{{-- 💅 Tambahan gaya agar serasi dengan Tailwind --}}
<style>
    .dt-buttons {
        margin-bottom: 1rem;
    }
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
</style>
@endsection
