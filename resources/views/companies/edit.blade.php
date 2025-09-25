@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit Company</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('companies.update', $company) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block font-medium">Company Code</label>
            <input type="text" name="company_code" 
                   value="{{ old('company_code', $company->company_code) }}"
                   class="border p-2 w-full rounded" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Company Name</label>
            <input type="text" name="company_name" 
                   value="{{ old('company_name', $company->company_name) }}"
                   class="border p-2 w-full rounded" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
            Update
        </button>

        <!-- Tambahkan Cancel -->
        <a href="{{ route('companies.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded">
            Cancel
        </a>
    </form>
</div>
@endsection
