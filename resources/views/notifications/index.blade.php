@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">← Kembali</a>
    </div>

    @if($notifications->isEmpty())
        <p class="text-gray-500 text-center">Belum ada notifikasi.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($notifications as $notif)
            <li class="py-3 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800">{{ $notif->title }}</p>
                    <p class="text-sm text-gray-600">{{ $notif->message }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                </div>

                @if(!$notif->is_read)
                    <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                        @csrf
                        <button class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            Tandai Dibaca
                        </button>
                    </form>
                @endif
            </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
