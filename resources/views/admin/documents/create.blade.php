@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow">
    <h2 class="text-2xl font-semibold mb-4">Upload Dokumen</h2>

    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Nama Dokumen</label>
            <input type="text" name="nama_file" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Jenis Dokumen</label>
            <select name="tipe" class="w-full border rounded-lg px-3 py-2" required>
                <option value="general">Dokumen Umum</option>
                <option value="private">Dokumen Pribadi</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Pilih Karyawan (opsional)</label>
            <select name="employee_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">- Tidak Dihubungkan -</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Upload File</label>
            <input type="file" name="file" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Upload
        </button>
    </form>
</div>
@endsection
