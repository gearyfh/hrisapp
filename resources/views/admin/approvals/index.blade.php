@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Daftar Pengajuan Cuti / Izin / Sakit</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Karyawan</th>
                <th class="border px-3 py-2">Jenis</th>
                <th class="border px-3 py-2">Tanggal</th>
                <th class="border px-3 py-2">Durasi</th>
                <th class="border px-3 py-2">Alasan</th>
                <th class="border px-3 py-2">Status</th>
                <th class="border px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr class="border-b">
                    <td class="border px-3 py-2">{{ $req->employee->name }}</td>
                    <td class="border px-3 py-2">{{ $req->leaveType->name }}</td>
                    <td class="border px-3 py-2">{{ $req->start_date }} - {{ $req->end_date }}</td>
                    <td class="border px-3 py-2 text-center">{{ $req->total_days }} hari</td>
                    <td class="border px-3 py-2">{{ $req->reason }}</td>
                    <td class="border px-3 py-2 capitalize">{{ $req->status }}</td>
                    <td class="border px-3 py-2">
                        @if($req->status === 'pending')
                        <form method="POST" action="{{ route('admin.approvals.update', $req->id) }}" class="flex gap-2">
                            @csrf
                            <select name="status" class="border rounded px-2 py-1">
                                <option value="approved">Setujui</option>
                                <option value="rejected">Tolak</option>
                            </select>
                            <input type="text" name="note" placeholder="Catatan (opsional)"
                                   class="border rounded px-2 py-1">
                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Kirim</button>
                        </form>
                        @else
                            <span class="text-gray-500 italic">Sudah {{ $req->status }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-3">Belum ada pengajuan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
