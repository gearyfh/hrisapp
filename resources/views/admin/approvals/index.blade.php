@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Pengajuan Cuti / Izin / Sakit</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border">Pegawai</th>
                    <th class="p-3 border">Jenis</th>
                    <th class="p-3 border">Tanggal</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 border">{{ $req->employee->name ?? '-' }}</td>
                        <td class="p-3 border">{{ $req->leaveType->name ?? '-' }}</td>
                        <td class="p-3 border">{{ $req->start_date }} - {{ $req->end_date }}</td>
                        <td class="p-3 border capitalize">
                            <span class="
                                @if($req->status == 'pending') text-yellow-600
                                @elseif($req->status == 'approved') text-green-600
                                @else text-red-600 @endif
                            ">
                                {{ $req->status }}
                            </span>
                        </td>
                        <td class="p-3 border text-center space-x-2">
                            @if($req->status === 'pending')
                                <form action="{{ route('admin.approvals.approve', $req->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.approvals.reject', $req->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Reject
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 italic">Sudah diproses</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-3 text-center text-gray-500">Tidak ada pengajuan saat ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
