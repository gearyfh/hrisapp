@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center mt-[10%]">
    <div class="w-full max-w-md bg-gray-100 p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Form Absensi</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.checkin') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Jenis Absensi --}}
            <div>
                <label class="block font-medium mb-1">Jenis Absensi</label>
                <select name="jenis" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
                    <option value="">-- Pilih --</option>
                    <option value="WFO">Work From Office (WFO)</option>
                    <option value="WFH">Work From Home (WFH)</option>
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block font-medium mb-1">Tanggal</label>
                <input type="date" name="tanggal_masuk"
                       value="{{ \Carbon\Carbon::now()->toDateString() }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" disabled>
            </div>

            {{-- Jam --}}
            <div>
                <label class="block font-medium mb-1">Jam</label>
                <input type="time" name="jam_masuk"
                       value="{{ \Carbon\Carbon::now()->format('H:i') }}"
                       class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" disabled>
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="block font-medium mb-1">Lokasi</label>
                <div class="flex items-center gap-2">
                    <input type="text" name="lokasi" id="lokasi" placeholder="Deteksi lokasi anda"
                        value="{{ old('lokasi') }}"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400" readonly>

                    <button type="button" id="btnDetectLocation"
                        class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-md transition"
                        title="Deteksi Lokasi">
                        <!-- Heroicon: Map Pin -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </button>
                </div>

                <p id="location-status" class="text-sm text-gray-500 mt-1">Klik ikon 📍 untuk mendeteksi lokasi Anda</p>
            </div>


            {{-- Tombol --}}
            <div class="flex justify-between">
                <a href="{{ route('employees.absensi') }}"
                   class="bg-gray-500 text-white px-5 py-2 rounded-full hover:bg-gray-600 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-green-600 text-white px-5 py-2 rounded-full hover:bg-green-700 transition">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== Script Deteksi Lokasi ===== --}}
<script>
document.getElementById("btnDetectLocation").addEventListener("click", () => {
    const lokasiInput = document.getElementById("lokasi");
    const statusText = document.getElementById("location-status");

    if (navigator.geolocation) {
        statusText.textContent = "🔄 Mendeteksi lokasi...";
        navigator.geolocation.getCurrentPosition(success, error);
    } else {
        statusText.textContent = "❌ Browser tidak mendukung geolokasi.";
    }

    function success(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        fetch(`https://us1.locationiq.com/v1/reverse?key=pk.3a9e6e3a4c3a2c47dc8191c097c9c8ea&lat=${lat}&lon=${lon}&format=json`)
            .then(res => res.json())
            .then(data => {
                lokasiInput.value = data.display_name;
                statusText.textContent = "✅ Lokasi berhasil dideteksi.";
            })
            .catch(() => {
                lokasiInput.value = `${lat}, ${lon}`;
                statusText.textContent = "⚠️ Gagal mendapatkan alamat, hanya menampilkan koordinat.";
            });
    }

    function error() {
        statusText.textContent = "❌ Gagal mendeteksi lokasi.";
    }
});
</script>

@endsection
