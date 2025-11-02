@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6 space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-500 mt-1">
                Selamat datang, 
                <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> 👋  
                <span class="text-gray-400">Anda login sebagai</span> 
                <span class="font-semibold text-indigo-600">Administrator</span>
            </p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-xl p-5 flex justify-between items-center shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div>
                <h2 class="text-sm opacity-80">Total Pegawai</h2>
                <p class="text-4xl font-semibold mt-1">{{ \App\Models\Employee::count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl p-5 flex justify-between items-center shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div>
                <h2 class="text-sm opacity-80">Total Absensi Hari Ini</h2>
                <p class="text-4xl font-semibold mt-1">{{ \App\Models\Attendance::whereDate('tanggal_masuk', now())->count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl p-5 flex justify-between items-center shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div>
                <h2 class="text-sm opacity-80">Pengajuan Pending</h2>
                <p class="text-4xl font-semibold mt-1">{{ \App\Models\LeaveRequest::where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fa-solid fa-hourglass-half text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filter Bulan -->
    <div class="flex justify-end mt-4">
        <form method="GET" action="{{ route('admin') }}" class="flex items-center gap-3">
            <label for="month" class="text-sm font-medium text-gray-700">Pilih Bulan:</label>
            <select id="month" name="month" class="border rounded-lg px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $m == $targetMonth ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white text-sm px-3 py-2 rounded-lg hover:bg-indigo-700 transition">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Grafik Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">
        <!-- Kehadiran Bulanan -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-700 mb-3">Kehadiran Bulanan</h2>
            <div class="h-44">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Jenis Absensi -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-700 mb-3">Jenis Absensi</h2>
            <div class="h-44">
                <canvas id="typeChart"></canvas>
            </div>
        </div>

        <!-- Status Cuti / Izin -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h2 class="text-sm font-semibold text-gray-700 mb-3">Status Cuti / Izin</h2>
            <div class="h-44">
                <canvas id="leaveChart"></canvas>
            </div>
        </div>
    </div>


    <!-- Data Absensi -->
    <div class="bg-white rounded-xl shadow-sm p-6 transition hover:shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock text-indigo-600"></i> Data Absensi Pegawai
        </h2>

        <div class="overflow-x-auto">
            <table id="absensitable" class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold">Check In</th>
                        <th class="px-4 py-3 text-left font-semibold">Check Out</th>
                        <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @foreach ($attendances as $absen)
                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium">{{ $absen->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $absen->tanggal_masuk }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $absen->jam_keluar ?? '-' }}</td>
                            <td class="px-4 py-3">{{ ucfirst($absen->jenis) ?? '-' }}</td>
                        </tr>
                    {{-- @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500 italic">Belum ada data absensi</td>
                        </tr> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Data Pengajuan -->
    <div class="bg-white rounded-xl shadow-sm p-6 transition hover:shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-envelope-open-text text-indigo-600"></i> Pengajuan Cuti / Izin / Sakit
        </h2>

        <div class="overflow-x-auto">
            <table id="cutitable" class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold">Durasi</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @foreach ($leaves as $leave)
                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium">{{ $leave->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $leave->leaveType->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                            <td class="px-4 py-3">{{ $leave->total_days }} hari</td>
                            <td class="px-4 py-3">
                                @if($leave->status === 'pending')
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                @elseif($leave->status === 'approved')
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">Approved</span>
                                @else
                                    <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-medium">Rejected</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 flex space-x-2">
                                @if($leave->status === 'pending')
                                    <form action="{{ route('admin.approvals.approve', $leave->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-medium transition">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.approvals.reject', $leave->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1 rounded-full text-xs font-medium transition">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    {{-- @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500 italic">Belum ada pengajuan cuti atau izin</td>
                        </tr> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
    // ✅ Inisialisasi DataTable
    const absentable = $('#absensitable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'lrtip',
    });
    const cutitable = $('#cutitable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'lrtip',
    });
});
</script>
<script>
    // Grafik Kehadiran Bulanan
    const ctx1 = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($attendanceDates),
            datasets: [{
                label: 'Jumlah Kehadiran',
                data: @json($attendanceCounts),
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Grafik Jenis Absensi
    const ctx2 = document.getElementById('typeChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: Object.keys(@json($typeCounts)),
            datasets: [{
                label: 'Jumlah',
                data: Object.values(@json($typeCounts)),
                backgroundColor: ['#4F46E5', '#10B981', '#F59E0B'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Grafik Status Pengajuan
    const ctx3 = document.getElementById('leaveChart').getContext('2d');
    new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: Object.keys(@json($leaveStatusCounts)),
            datasets: [{
                data: Object.values(@json($leaveStatusCounts)),
                backgroundColor: ['#FBBF24', '#10B981', '#EF4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
<style>
    /* 📊 Table styling lembut */
    table.dataTable thead th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    table.dataTable tbody td {
        border-bottom: 1px solid #f1f5f9;
        padding: 0.9rem 1rem;
    }

    table.dataTable tbody tr:hover {
        background-color: #f9fafb;
        transition: background 0.2s ease;
    }

    /* 📎 Pagination dan info text */
    .dataTables_wrapper .dataTables_info {
        color: #4b5563;
        font-size: 0.875rem;
        margin-top: 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: none;
        border-radius: 0.375rem;
        padding: 5px 10px;
        margin: 0 2px;
        background: #f3f4f6;
        color: #4b5563 !important;
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e5e7eb;
        color: #111827 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #E6E6E6 !important;
        font-weight: 500;
    }

    /* 📱 Responsif */
    @media (max-width: 768px) {
        .dt-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
        }
    }

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
