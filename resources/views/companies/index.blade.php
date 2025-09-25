@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Company List</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('companies.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded">Add Company</a>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Code</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
@foreach($companies as $company)
    <tr>
        <td class="p-2 border">{{ $company->company_code }}</td>
        <td class="p-2 border">{{ $company->company_name }}</td>
        <td class="p-2 border">
            <a href="{{ route('companies.edit', $company->id) }}" 
               class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>

            <form action="{{ route('companies.destroy', $company->id) }}" 
                  method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Are you sure?')"
                        class="bg-red-600 text-white px-3 py-1 rounded">
                    Delete
                </button>
            </form>
        </td>
    </tr>
@endforeach
        </tbody>
    </table>
</div>
@endsection
