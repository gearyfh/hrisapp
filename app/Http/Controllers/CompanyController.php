<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_code' => 'required|unique:companies,company_code|regex:/^[0-9]{3}$/', // hanya 3 digit angka
            'company_name' => 'required|string|max:255',
        ]);

        Company::create($request->only('company_code', 'company_name'));

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

     public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'company_code' => [
                'required',
                'regex:/^[0-9]{3}$/',
                'unique:companies,company_code,' . $company->id, // abaikan kode miliknya sendiri
            ],
            'company_name' => 'required|string|max:255',
        ]);

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

}
