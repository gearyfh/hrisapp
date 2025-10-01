@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">User List</h1>
        <a href="{{ route('users.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Add Users
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

        {{-- <a href="{{ route('users.create') }}" 
    class="bg-blue-600 text-white px-3 py-1 rounded">
    + Tambah User
    </a> --}}


    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Role</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Company</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            {{-- Loop through users --}}
            @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->role }}</td>
                    {{-- <td class="p-3">{{ $user->employee?->status ?? '-' }}</td> --}}
                        <td class="p-3 text-center">
                        @if($user->employee?->status === 'active')
                            <span class="flex items-center justify-center gap-1">
                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-green-600 text-sm"></span>
                            </span>
                        @elseif($user->employee?->status === 'inactive')
                            <span class="flex items-center justify-center gap-1">
                                <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                                <span class="text-red-600 text-sm"></span>
                            </span>
                        @else
                            <span class="flex items-center justify-center gap-1">
                                <span class="inline-block w-3 h-3 bg-gray-400 rounded-full"></span>
                                <span class="text-gray-600 text-sm"></span>
                            </span>
                        @endif
                    </td>
                    <td class="p-3">{{ $user->company->name ?? '-' }}</td>
                    <td class="p-3 text-center"><a href="{{ route('users.edit', $user->id) }}" 
                           class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm shadow transition">
                            Edit
                        </a>
                    <form action="{{ route('users.destroy', $user->id) }}" 
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                    class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm shadow transition">
                                Delete
                            </button></td>
                                                </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
