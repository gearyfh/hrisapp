@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10 border border-gray-100">
    <!-- Header -->
    <div class="flex flex-col items-center mb-8">
        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 text-center">Pilih Karyawan untuk Upload Dokumen</h1>
        <p class="text-gray-500 text-sm mt-1 text-center">Kamu bisa memilih satu atau beberapa karyawan untuk diupload dokumennya</p>
    </div>

    <!-- Form Pilih Karyawan -->
    <form action="{{ route('admin.documents.create') }}" method="GET" id="selectForm" class="space-y-6">
        @csrf

        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">
                            <input type="checkbox" id="selectAll" class="mr-2">
                            Pilih Semua
                        </th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Nama</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">NIK</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr class="border-b hover:bg-indigo-50 transition">
                            <td class="p-4">
                                <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}" class="employeeCheckbox">
                            </td>
                            <td class="p-4 text-gray-700">{{ $employee->name }}</td>
                            <td class="p-4 text-gray-700">{{ $employee->nik ?? '-' }}</td>
                            <td class="p-4 text-gray-700">
                                <span class="px-3 py-1 text-xs rounded-full
                                    {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end items-center gap-3 pt-6">
            <a href="{{ route('admin.documents.index') }}"
               class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-200 transition">
                Kembali
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow-sm transition">
                Lanjut ke Upload
            </button>
        </div>
    </form>
</div>

<script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.employeeCheckbox');

    selectAll.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    });
</script>
@endsection
