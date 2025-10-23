@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold mb-6">🪵 Activity Logs</h2>

    <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                    <th class="px-4 py-2 text-left">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-4 py-2">{{ $log->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2">{{ $log->user->name ?? 'System' }}</td>
                    <td class="px-4 py-2 font-semibold">{{ ucfirst($log->action) }}</td>
                    <td class="px-4 py-2">{{ $log->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
