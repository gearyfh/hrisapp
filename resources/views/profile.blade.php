@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-10 transition-all duration-300">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-3">Profil Pengguna</h1>

    <!-- Informasi Pengguna -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="space-y-4">
            <div>
                <label class="block text-gray-600 font-medium mb-1">Nama</label>
                <input type="text" value="{{ Auth::user()->name }}" disabled
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-gray-600 font-medium mb-1">Email</label>
                <input type="text" value="{{ Auth::user()->email }}" disabled
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-gray-600 font-medium mb-1">Role</label>
                <input type="text" value="{{ ucfirst(Auth::user()->role) }}" disabled
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed">
            </div>
        </div>

        <div class="flex flex-col items-center justify-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                 alt="User Avatar" class="w-28 h-28 rounded-full border-4 border-blue-200 shadow-md mb-3 transition-all duration-300 hover:scale-105">
            <p class="text-gray-700 font-semibold">{{ Auth::user()->name }}</p>
            <span class="text-sm text-gray-500 capitalize">{{ Auth::user()->role }}</span>
        </div>
    </div>

    <!-- Ubah Password -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 shadow-inner">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 11c0-1.105.895-2 2-2h4a2 2 0 012 2v6a2 2 0 01-2 2h-4a2 2 0 01-2-2v-6zM8 11V7a4 4 0 018 0v4" />
            </svg>
            Ubah Password
        </h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded-xl mb-4">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Ganti Password -->
        <form method="POST" action="{{ route('profile.update-password') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-gray-600 font-medium mb-1">Password Lama</label>
                <input type="password" name="current_password"
                       class="w-full border border-gray-300 rounded-xl p-3 mt-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required placeholder="Masukkan password lama">
            </div>

            <div>
                <label class="block text-gray-600 font-medium mb-1">Password Baru</label>
                <input type="password" name="new_password"
                       class="w-full border border-gray-300 rounded-xl p-3 mt-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required placeholder="Masukkan password baru">
            </div>

            <div>
                <label class="block text-gray-600 font-medium mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                       class="w-full border border-gray-300 rounded-xl p-3 mt-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required placeholder="Ulangi password baru">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-xl shadow-md transition-all duration-300 hover:scale-[1.02]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
