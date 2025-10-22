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

    /**
     * 🔹 Tahap 1: Menampilkan list karyawan untuk dipilih
     */
    public function selectEmployees()
    {
        $employees = Employee::orderBy('name')->get();
        return view('admin.documents.select', compact('employees'));
    }

    /**
     * 🔹 Tahap 2: Menampilkan form upload (setelah pilih karyawan)
     */
    public function create(Request $request)
    {
        // Ambil employee_ids dari query string (?employee_ids[]=1&employee_ids[]=2)
        $selectedEmployeeIds = $request->input('employee_ids', []);

        // Ambil data karyawan yang dipilih, kalau kosong tampilkan semua
        $employees = !empty($selectedEmployeeIds)
        ? Employee::whereIn('id', $selectedEmployeeIds)->get()
        : Employee::all();

        return view('admin.documents.create', compact('employees', 'selectedEmployeeIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|array',
            'employee_id.*' => 'exists:employees,id',
            'nama_file' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            'tipe' => 'required|in:private,general',
        ]);

        // Simpan file ke folder sesuai tipe
        $folder = $request->tipe === 'private' ? 'documents/private' : 'documents/general';
        $path = $request->file('file')->store("public/$folder");

        // Jika user memilih beberapa karyawan
        if ($request->filled('employee_id')) {
            foreach ($request->employee_id as $empId) {
                $employee = Employee::find($empId);
                Document::create([
                    'employee_id' => $empId,
                    'company_id' => $employee->company_id,
                    'nama_file' => $request->nama_file,
                    'path' => str_replace('public/', 'storage/', $path),
                    'tipe' => $request->tipe,
                ]);
            }
        } else {
            // Jika tidak ada karyawan dipilih → dokumen umum
            Document::create([
                'employee_id' => null,
                'company_id' => null,
                'nama_file' => $request->nama_file,
                'path' => str_replace('public/', 'storage/', $path),
                'tipe' => $request->tipe,
            ]);
        }

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diupload!');
    }
}
