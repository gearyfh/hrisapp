<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS App</title>
    @vite('resources/css/app.css')
    <style>
    /* Sidebar Transition */
    #sidebar {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    /* Saat tertutup */
    .sidebar-collapsed {
        width: 0 !important;
        padding: 0 !important;
        opacity: 0;
    }

    /* Saat terbuka */
    .sidebar-expanded {
        width: 16rem; /* sama seperti w-64 */
        opacity: 1;
    }

    /* Dropdown muncul saat hover */
    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>

</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-expanded bg-gray-900 text-white min-h-screen p-4 flex flex-col">
            <h2 class="text-xl font-bold mb-6">Menu</h2>

            <a href="/dashboard" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dashboard</a>

            {{-- Superadmin --}}
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('employees.attendance.absensi') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Absensi</a>
                <a href="/company" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Company</a>
                <a href="/karyawan" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Karyawan</a>
                <a href="/dokumen" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>

            {{-- Admin --}}
            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('admin.employee.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Karyawan</a>
                <a href="{{ route('admin.documents.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>

                <div x-data="{ open: false }" class="mb-2">
    <!-- Tombol utama -->
    <button @click="open = !open"
        class="flex justify-between items-center w-full text-left py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg focus:outline-none">
        <span>Approval</span>
        <svg xmlns="http://www.w3.org/2000/svg"
            :class="{ 'rotate-180': open }"
            class="w-5 h-5 transform transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Submenu -->
    <div
        x-show="open"
        x-transition
        class="pl-6 mt-1 space-y-1"
        @click.away="open = false"
    >
        <a href="{{ route('admin.approvals.cuti.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Cuti Karyawan</a>
                <a href="{{ route('admin.approvals.izin_sakit') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Izin / Sakit Karyawan</a>
                <a href="{{ route('admin.corrections.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Koreksi Absensi Karyawan</a>

                            <a href="{{ route('admin.overtimes.index') }}" 
                            class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
                            Jam Lembur Karyawan
                            </a>

        </a>
    </div>
</div>

                            <a href="{{ route('admin.data.absensi.index') }}" 
                            class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
                            Rekap Data Jam Karyawan
                            </a> 

                            
                            <a href="{{ route('admin.logs.index') }}" 
                            class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
                            Activity Logs
                            </a>

            {{-- Employee --}}
            @elseif(auth()->user()->role === 'employee')
                <a href="{{ route('employees.attendance.absensi') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Absensi</a>
                <a href="{{ route('employees.documents.show_documents', Auth::user()->id) }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Dokumen</a>
                {{-- <a href="{{ route('sick.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Izin/Sakit</a>
                <a href="{{ route('leave.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Cuti</a>
                <a href="{{ route('employees.corrections.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Koreksi Absensi</a>
                <a href="{{ route('employees.overtime.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">Pengajuan Lembur</a> --}}

                <div x-data="{ open: false }" class="mb-2">
    <!-- Tombol utama -->
    <button @click="open = !open"
        class="flex justify-between items-center w-full text-left py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg focus:outline-none">
        <span>Pengajuan</span>
        <svg xmlns="http://www.w3.org/2000/svg"
            :class="{ 'rotate-180': open }"
            class="w-5 h-5 transform transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Submenu -->
    <div
        x-show="open"
        x-transition
        class="pl-6 mt-1 space-y-1"
        @click.away="open = false"
    >
        <a href="{{ route('sick.index') }}" 
           class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">
           Izin / Sakit
        </a>
        <a href="{{ route('leave.index') }}" 
           class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">
           Cuti
        </a>
        <a href="{{ route('employees.corrections.index') }}" 
           class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">
           Koreksi Absensi
        </a>
        <a href="{{ route('employees.overtime.index') }}" 
           class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">
           Lembur
        </a>
    </div>
</div>

            @endif
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <nav class="bg-gray-900 shadow px-6 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <!-- Tombol Hamburger -->
                    <button id="toggleSidebar" class="text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="text-xl text-white font-bold">HRIS Dashboard</div>
                </div>

                <!-- User Menu -->
                <div class="relative" id="user-menu-container">
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
            <main class="p-6 flex-1 bg-gray-200">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');
        const nav = document.querySelector('nav');

        // Toggle class collapsed/expanded
        sidebar.classList.toggle('sidebar-collapsed');
        sidebar.classList.toggle('sidebar-expanded');
    });

    // Dropdown logic
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('user-menu-container');
        const menu = document.getElementById('dropdown-menu');
        let menuVisible = false;

        container.addEventListener('mouseenter', () => {
            menu.classList.remove('hidden');
            setTimeout(() => menu.classList.remove('opacity-0'), 10);
            menuVisible = true;
        });

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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script> --}}


</body>
</html>
