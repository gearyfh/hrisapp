@extends('layouts.app')

@section('title', 'Add Company')

@section('content')
<h2 class="text-xl font-bold mb-4">Add New Company</h2>

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('companies.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block">Company Code</label>
        <input type="text" name="company_code" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">Company Name</label>
        <input type="text" name="company_name" class="border p-2 w-full" required>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
    <!-- Tambahkan Cancel -->
        <a href="{{ route('companies.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded">
            Cancel
        </a>
</form>
@endsection
