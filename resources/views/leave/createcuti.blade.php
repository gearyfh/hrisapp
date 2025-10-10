@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Form Pengajuan Cuti</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leave.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium">Jenis Cuti</label>
            <select name="leave_type_id" class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400">
                @foreach($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}"
                class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Tanggal Selesai</label>
            <input type="date" name="end_date" value="{{ old('end_date') }}"
                class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Alasan</label>
            <textarea name="reason" rows="3"
                class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400"
                placeholder="Tuliskan alasan pengajuan cuti">{{ old('reason') }}</textarea>
        </div>

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
            Kirim Pengajuan
        </button>
    </form>
</div>
@endsection
