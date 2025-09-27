<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS App</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-4 flex flex-col">
            <h2 class="text-xl font-bold mb-6">Menu</h2>

            <a href="/dashboard" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dashboard</a>

            {{-- Superadmin --}}
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('employees.absensi.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Absensi</a>
                <a href="/company" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Company</a>
                <a href="/karyawan" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Karyawan</a>
                <a href="/dokumen" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>

            {{-- Admin --}}
            @elseif(auth()->user()->role === 'admin')
                <a href="/karyawan" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Karyawan</a>
                <a href="/dokumen" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>

            {{-- Employee --}}
            @elseif(auth()->user()->role === 'employee')
                <a href="{{ route('employees.absensi') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Absensi</a>
                <a href="/dokumen" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>
            @endif

            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-3 rounded hover:bg-red-600 text-lg">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <nav class="bg-gray-700 shadow px-6 py-4 flex justify-between items-center">
                <div class="text-xl text-white font-bold">HRIS Dashboard</div>
                <div class="flex items-center space-x-4">
                    <span class="text-white">
                        {{ Auth::user()->name }}
                    </span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" 
                         class="w-10 h-10 rounded-full" alt="User Avatar">
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
