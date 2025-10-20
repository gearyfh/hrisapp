@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-xl p-6">
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-semibold text-gray-800">Notifikasi</h1>
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline text-sm">← Kembali</a>
    </div>

    @if($notifications->isEmpty())
        <p class="text-gray-500 text-center py-10">Belum ada notifikasi.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($notifications as $notif)
            <li class="py-4 px-3 hover:bg-gray-50 transition rounded-lg {{ $notif->is_read ? 'opacity-70' : '' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">{{ $notif->title }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $notif->message }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>

                    @if(!$notif->is_read)
                    <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                        @csrf
                        <button class="text-xs bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 shadow-sm">
                            Tandai Dibaca
                        </button>
                    </form>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
