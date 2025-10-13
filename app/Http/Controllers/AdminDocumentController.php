<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;

class AdminDocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('employee')->latest()->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('admin.documents.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'nama_file' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'tipe' => 'required|in:private,general',
        ]);

        $companyId = null;
        if ($request->filled('employee_id')) {
            $employee = Employee::find($request->employee_id);
            $companyId = $employee ? $employee->company_id : null;
        }

        // Simpan file ke folder sesuai tipe
        $folder = $request->tipe === 'private' ? 'documents/private' : 'documents/general';
        $path = $request->file('file')->store("public/$folder");

        Document::create([
            'employee_id' => $request->employee_id,
            'company_id'  => $companyId,
            'nama_file' => $request->nama_file,
            'path' => str_replace('public/', 'storage/', $path),
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diupload!');
    }
}
