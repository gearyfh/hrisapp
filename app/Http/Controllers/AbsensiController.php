<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;


class AbsensiController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('id', Auth::id())
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('employees.absensi', compact('attendances'));
    }

    public function create()
    {
        return view('employees.absensi_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis'   => 'required|in:WFH,WFO',
            'tanggal' => 'required|date',
            'jam'     => 'required|date_format:H:i',
            'lokasi'  => 'required|string|max:255',
        ]);

        Attendance::create([
            'id' => Auth::user()->id,
            'jenis'   => $validated['jenis'],
            'tanggal' => $validated['tanggal'],
            'jam'     => $validated['jam'],
            'lokasi'  => $validated['lokasi'],
        ]);

        return redirect()->route('employees.absensi')
                         ->with('success', 'Absensi berhasil disimpan!');
    }
}