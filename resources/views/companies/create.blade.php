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
                   placeholder="Enter company code | (Ex: XXX)" required>
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

                <!-- Company Address -->
        <div>
            <label for="company_address" class="block text-gray-700 font-semibold mb-1">
                Company Address
            </label>
            <input type="text" name="company_address" id="company_address" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                   placeholder="Enter company address" required>
        </div>

                <!-- Company Phone -->
        <div>
            <label for="company_phone" class="block text-gray-700 font-semibold mb-1">
                Company Phone
            </label>
            <input type="text" name="company_phone" id="company_phone" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                   placeholder="Enter company phone" required>
        </div>

                <!-- Company Name -->
        <div>
            <label for="company_email" class="block text-gray-700 font-semibold mb-1">
                Company Email
            </label>
            <input type="email" name="company_email" id="company_email" 
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                   placeholder="Enter company email" required>
        </div>

            <!-- Hidden lat/lng fields -->
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">

    <!-- Map -->
    <div class="mt-4">
        <label class="block text-gray-700 font-semibold mb-1">
            Select Location
        </label>
        <div id="map" class="w-full h-64 rounded-lg border"></div>
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

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Default location (Jakarta)
    var map = L.map('map').setView([-6.200000, 106.816666], 12);
    console.log(map);
    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    // On map click
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(6);
        var lng = e.latlng.lng.toFixed(6);

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng]).addTo(map);

        // Set values in hidden input
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });
</script>
