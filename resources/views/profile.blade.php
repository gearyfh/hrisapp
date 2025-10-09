@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Profil Pengguna</h1>

    <!-- Informasi Pengguna -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-gray-600 font-medium">Nama</label>
            <p class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-1">{{ Auth::user()->name }}</p>
        </div>

        <div>
            <label class="block text-gray-600 font-medium">Email</label>
            <p class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-1">{{ Auth::user()->email }}</p>
        </div>

        <div>
            <label class="block text-gray-600 font-medium">Role</label>
            <p class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-1 capitalize">{{ Auth::user()->role }}</p>
        </div>

        <div class="flex items-center justify-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                 alt="User Avatar" class="w-24 h-24 rounded-full border-4 border-blue-200 shadow">
        </div>
    </div>

    <!-- Garis pembatas -->
    <hr class="my-6">

    <!-- Ubah Password -->
    <h2 class="text-lg font-semibold mb-4 text-gray-800">Ubah Password</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Ganti Password -->
    <form method="POST" action="{{ route('profile.update-password') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-600 font-medium">Password Lama</label>
            <input type="password" name="current_password"
                   class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400"
                   required placeholder="Masukkan password lama">
        </div>

        <div>
            <label class="block text-gray-600 font-medium">Password Baru</label>
            <input type="password" name="new_password"
                   class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400"
                   required placeholder="Masukkan password baru">
        </div>

        <div>
            <label class="block text-gray-600 font-medium">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation"
                   class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring-2 focus:ring-blue-400"
                   required placeholder="Ulangi password baru">
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
