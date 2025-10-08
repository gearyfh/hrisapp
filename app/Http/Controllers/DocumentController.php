<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'Anda bukan employee!');
        }

        // // Ambil semua dokumen milik employee yang login
        // $documents = Document::where('employee_id', $employee->id)
        //     ->latest()
        //     ->get();

        return view('document.index');
    }
}
