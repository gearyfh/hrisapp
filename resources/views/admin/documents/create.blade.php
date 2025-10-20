@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10 border border-gray-100">

    <!-- Header -->
    <div class="flex flex-col items-center mb-8">
        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 text-center">Upload Dokumen</h1>
        <p class="text-gray-500 text-sm mt-1 text-center">Unggah dokumen karyawan atau dokumen umum dengan mudah</p>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Nama Dokumen -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Nama Dokumen</label>
            <input type="text" name="nama_file" placeholder="Masukkan nama dokumen..."
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition" required>
        </div>

        <!-- Jenis Dokumen -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Jenis Dokumen</label>
            <select name="tipe"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition bg-white" required>
                <option value="general">Dokumen Umum</option>
                <option value="private">Dokumen Pribadi</option>
            </select>
        </div>

        <!-- Pilih Karyawan -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Pilih Karyawan (opsional)</label>
            <select name="employee_id"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition bg-white">
                <option value="">- Tidak Dihubungkan -</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Upload File -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Upload File</label>
            <div id="uploadBox"
                class="flex items-center justify-between border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 hover:bg-indigo-50 transition cursor-pointer">
                <input type="file" name="file" id="fileInput" class="hidden" required>
                <div class="flex items-center gap-3 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 108 0M12 12V4m0 8l3 3m-3-3l-3 3" />
                    </svg>
                    <span id="fileLabel">Klik di sini untuk memilih file</span>
                </div>
                <span id="fileName" class="text-sm text-gray-500 italic truncate ml-2">Tidak ada file yang dipilih</span>
            </div>
        </div>


        <!-- Tombol -->
        <div class="flex justify-end items-center gap-3 pt-6">
            <a href="{{ route('admin.documents.index') }}"
            class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-200 transition">
                Kembali
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow-sm transition">
                Upload
            </button>
        </div>
    </form>
</div>

{{-- Script kecil untuk menampilkan nama file --}}
<script>
    const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    const fileLabel = document.getElementById('fileLabel');

    // Klik di area mana saja langsung trigger input file
    uploadBox.addEventListener('click', () => fileInput.click());

    // Tampilkan nama file saat dipilih
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
            fileLabel.textContent = 'File terpilih:';
        } else {
            fileName.textContent = 'Tidak ada file yang dipilih';
            fileLabel.textContent = 'Klik di sini untuk memilih file';
        }
    });
</script>

@endsection
