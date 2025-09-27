<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('employees.absensi');
    }

    public function create()
    {
        return view('employees.absensi_create');
    }
}