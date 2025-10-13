<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS App</title>
    @vite('resources/css/app.css')
    <style>
        /* Dropdown muncul saat hover */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-4 flex flex-col">
            <h2 class="text-xl font-bold mb-6">Menu</h2>

            <a href="/dashboard" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dashboard</a>
            

            {{-- Superadmin --}}
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('employees.absensi') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Absensi</a>
                <a href="/company" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Company</a>
                <a href="/karyawan" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Karyawan</a>
                <a href="/dokumen" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>

            {{-- Admin --}}
            @elseif(auth()->user()->role === 'admin')
                <a href="/karyawan" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Karyawan</a>
                <a href="/dokumen" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>
                <a href="{{ route('admin.approvals.cuti') }}" 
                            class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
                            Cuti Karyawan
                            </a>

                            <a href="{{ route('admin.approvals.izin_sakit') }}" 
                            class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
                            Izin / Sakit Karyawan
                            </a>

            {{-- Employee --}}
            @elseif(auth()->user()->role === 'employee')
                <a href="{{ route('employees.absensi') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Absensi</a>
                <a href="{{ route('document.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>
                <a href="{{ route('sick.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Izin/Sakit</a>
                <a href="{{ route('leave.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Cuti</a>
            @endif
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <nav class="bg-gray-700 shadow px-6 py-4 flex justify-between items-center">
                <div class="text-xl text-white font-bold">HRIS Dashboard</div>

                <div class="relative" id="user-menu-container">
                    <!-- Avatar -->
                    <div id="user-menu-button" class="flex items-center space-x-3 cursor-pointer">
                        <span class="text-white">{{ Auth::user()->name }}</span>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                            class="w-10 h-10 rounded-full border-2 border-white" alt="User Avatar">
                    </div>

                    <!-- Dropdown -->
                    <div id="dropdown-menu"
                        class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg hidden z-50 opacity-0 transition-all duration-200">
                        <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-100 hover:text-red-600">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>


            <!-- Page Content -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('user-menu-button');
            const menu = document.getElementById('dropdown-menu');
            const container = document.getElementById('user-menu-container');

            let menuVisible = false;

            // Saat di-hover avatar → tampilkan menu
            container.addEventListener('mouseenter', () => {
                menu.classList.remove('hidden');
                setTimeout(() => menu.classList.remove('opacity-0'), 10);
                menuVisible = true;
            });

            // Saat klik di luar → sembunyikan menu
            document.addEventListener('click', (e) => {
                if (menuVisible && !container.contains(e.target)) {
                    menu.classList.add('opacity-0');
                    setTimeout(() => menu.classList.add('hidden'), 150);
                    menuVisible = false;
                }
            });
        });
    </script>
@yield('scripts')
</body>
</html>
