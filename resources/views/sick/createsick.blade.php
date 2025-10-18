@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-8">
    <div class="mb-6 border-b border-gray-100 pb-3">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">📝 Form Pengajuan Izin / Sakit</h1>
        <p class="text-center text-gray-500 mb-8 text-sm">Isi data berikut untuk mengajukan izin atau sakit</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-6">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Jenis Pengajuan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Jenis Pengajuan</label>
                <select name="leave_type_id" required
                    class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none transition">
                    <option value="">-- Pilih Jenis Pengajuan --</option>
                    @foreach($leaveTypes as $type)
                        <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal Mulai dan Selesai --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" required
                        class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none transition">
                </div>
            </div>

            {{-- Alasan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Alasan</label>
                <textarea name="reason" rows="3" placeholder="Tuliskan alasan pengajuan..."
                    class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none transition resize-none">{{ old('reason') }}</textarea>
            </div>

            {{-- Lampiran --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Lampiran Surat Dokter (Khusus Sakit)</label>
                <div class="border border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-400 transition">
                    <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf" id="attachment" class="hidden" />
                    <label for="attachment" class="cursor-pointer text-green-600 font-semibold hover:underline">
                        Klik untuk pilih file
                    </label>
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, atau PDF (maks 2MB)</p>
                    <p id="file-name" class="text-sm text-gray-700 mt-2"></p>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-200 ease-in-out">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Preview Nama File --}}
<script>
    document.getElementById('attachment').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'Tidak ada file yang dipilih';
        document.getElementById('file-name').textContent = fileName;
    });
</script>
@endsection
