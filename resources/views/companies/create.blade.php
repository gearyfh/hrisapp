@extends('layouts.app')

@section('title', 'Add Company')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Company</h2>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('companies.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Company Code -->
        <div>
            <label for="company_code" class="block text-gray-700 font-semibold mb-1">
                Company Code
            </label>
            <input type="text" name="company_code" id="company_code" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                   placeholder="Enter company code" required>
        </div>

        <!-- Company Name -->
        <div>
            <label for="company_name" class="block text-gray-700 font-semibold mb-1">
                Company Name
            </label>
            <input type="text" name="company_name" id="company_name" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                   placeholder="Enter company name" required>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('companies.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
