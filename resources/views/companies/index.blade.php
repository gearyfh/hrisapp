@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Company List</h1>
        <a href="{{ route('companies.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Add Company
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="p-3 text-left">Code</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($companies as $company)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3">{{ $company->company_code }}</td>
                    <td class="p-3">{{ $company->company_name }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('companies.edit', $company->id) }}" 
                           class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm shadow transition">
                            Edit
                        </a>
                        <form action="{{ route('companies.destroy', $company->id) }}" 
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this company?')"
                                    class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm shadow transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">No companies found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
