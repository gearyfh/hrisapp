@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6">
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Karyawan</h1>
        <a href="{{ route('admin.employee.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ Tambah Karyawan</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse text-sm">
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
                              method="POST" 
                              class="inline-block delete-form">
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

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.delete-form');

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
