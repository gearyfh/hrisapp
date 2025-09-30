@extends('layouts.app')

@php use Illuminate\Support\Facades\Auth; @endphp

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Super Admin Dashboard</h1>

    @if(Auth::check())
        <p class="text-gray-600 mb-6">Welcome, <span class="font-semibold">{{ Auth::user()->name }}</span> (Super Admin)</p>
    @else
        <p class="text-gray-600 mb-6">Welcome, Guest</p>
    @endif

    <!-- Grid Menu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Create Company -->
        <a href="{{ route('companies.index') }}" 
           class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition">
            <div class="bg-blue-100 text-blue-600 rounded-full p-4 mb-4">
                <!-- Icon Company -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h18M9 21V3h6v18M3 21h18"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold">Create Company</h2>
            <p class="text-sm text-gray-500 mt-1">Tambah data perusahaan baru</p>
        </a>

        <!-- Card Create Karyawan -->
        <a href="{{ route('users.index') }}" 
           class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-lg transition">
            <div class="bg-green-100 text-green-600 rounded-full p-4 mb-4">
                <!-- Icon User -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold">Create Karyawan</h2>
            <p class="text-sm text-gray-500 mt-1">Tambah data karyawan baru</p>
        </a>
    </div>
</div>
@endsection
