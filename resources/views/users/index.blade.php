@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
    <h2 class="text-xl font-bold mb-4">Daftar User</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

        <a href="{{ route('users.create') }}" 
    class="bg-blue-600 text-white px-3 py-1 rounded">
    + Tambah User
    </a>


    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Nama</th>
                <th class="border px-2 py-1">Email</th>
                <th class="border px-2 py-1">Role</th>
                <th class="border px-2 py-1">Status</th>
                <th class="border px-2 py-1">Company</th>
                <th class="border px-2 py-1">Employee</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="border px-2 py-1">{{ $user->name }}</td>
                    <td class="border px-2 py-1">{{ $user->email }}</td>
                    <td class="border px-2 py-1">{{ $user->role }}</td>
                    <td class="border px-2 py-1">{{ $user->status }}</td>
                    <td class="border px-2 py-1">{{ $user->company->name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $user->employee->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
