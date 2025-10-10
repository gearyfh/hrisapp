@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Ajukan Cuti / Izin / Sakit</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('leave.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium">Jenis Cuti</label>
            <select name="leave_type_id" required
                class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Jenis --</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Tanggal Mulai</label>
            <input type="date" name="start_date"
                   class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400"
                   required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Tanggal Selesai</label>
            <input type="date" name="end_date"
                   class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400"
                   required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Alasan</label>
            <textarea name="reason" rows="3"
                      class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400"
                      placeholder="Tuliskan alasan pengajuan cuti..."></textarea>
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition">
            Kirim Pengajuan
        </button>
    </form>
</div>
@endsection
