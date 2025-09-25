@extends('layouts.app')

@php use Illuminate\Support\Facades\Auth; @endphp

@section('content')
<div class="container">
    <h1>Super Admin Dashboard</h1>
    @if(Auth::check())
        <p>Welcome, {{ Auth::user()->name }} (Super Admin)</p>
    @else
        <p>Welcome, Guest   </p>
    @endif

    <div class="card p-3 mt-3">
        <h4>Manajemen Perusahaan</h4>
        <ul>
            <li><a href="#">Tambah Company</a></li>
            <li><a href="#">Lihat Daftar Company</a></li>
            <li><a href="#">Hapus Company</a></li>
        </ul>
    </div>

    <div class="card p-3 mt-3">
        <h4>Manajemen User Admin</h4>
        <ul>
            <li><a href="#">Tambah Admin Company</a></li>
            <li><a href="#">Reset Password Admin</a></li>
        </ul>
    </div>
</div>
@endsection
