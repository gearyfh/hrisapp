<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/Logo_app.png') }}">
    <title>HRIS App</title>
    @vite('resources/css/app.css')
    <style>
    /* ---------- Existing sidebar styles (keamanan: tetap dipakai di desktop) ---------- */
    #sidebar {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    /* Saat tertutup (desktop behavior) */
    .sidebar-collapsed {
        width: 0 !important;
        padding: 0 !important;
        opacity: 0;
    }

    /* Saat terbuka (desktop behavior) */
    .sidebar-expanded {
        width: 16rem; /* sama seperti w-64 */
        opacity: 1;
    }

    /* Dropdown muncul saat hover */
    .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* ---------- Mobile-only helpers (tidak memengaruhi desktop) ---------- */
    /* class ini akan ditambahkan hanya saat device mobile membuka sidebar */
    .mobile-fullscreen {
        position: fixed;
        inset: 0;             /* top:0; right:0; bottom:0; left:0; */
        width: 100%;
        height: 100vh;
        z-index: 60;
        overflow-y: auto;     /* biar bisa scroll menu di mobile */
    }

    /* overlay visibility */
    #sidebar-overlay {
        transition: opacity 0.2s ease;
    }
    .overlay-hidden {
        opacity: 0;
        pointer-events: none;
    }
    .overlay-visible {
        opacity: 1;
        pointer-events: auto;
    }

    /* Pastikan di desktop (>= md) overlay selalu tersembunyi */
    @media (min-width: 768px) {
        #sidebar-overlay { display: none !important; }
    }

    /* Sidebar full screen untuk mobile */
    @media (max-width: 768px) {
        #sidebar.sidebar-expanded {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%; /* Full layar */
            height: 100%;
            z-index: 50;
        }
    }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Overlay for mobile (initial hidden). md:hidden tidak diperlukan karena media query CSS di atas -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 overlay-hidden z-40"></div>
        
        <!-- Sidebar -->
        <!-- NOTE: class default tetap sidebar-expanded (desktop tampil normal). Kita akan menambahkan class mobile-fullscreen hanya saat mobile buka. -->
        <aside id="sidebar" class="sidebar-expanded bg-gray-900 text-white min-h-screen p-4 flex flex-col">
            <!-- Tombol Close (hanya muncul di mobile) -->
            <button id="closeSidebar"
                class="absolute top-4 right-4 text-white text-2xl md:hidden focus:outline-none">
                &times;
            </button>
            <h2 class="text-xl font-bold mb-6">Menu</h2>

            <a href="/dashboard" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10h16V10" />
    </svg>
    Dashboard
</a>

{{-- Superadmin --}}
@if(auth()->user()->role === 'superadmin')
    <a href="{{ route('employees.attendance.absensi') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M9 17H3V9h6m0 8v-6m6 0h1" />
        </svg>
        Absensi
    </a>

    <a href="/company" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
        </svg>
        Company
    </a>

    <a href="/karyawan" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
        </svg>
        Karyawan
    </a>

    <a href="/dokumen" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
        </svg>
        Dokumen
    </a>

{{-- Admin --}}
@elseif(auth()->user()->role === 'admin')
    <a href="{{ route('admin.employee.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
        </svg>
        Karyawan
    </a>

    <a href="{{ route('admin.documents.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
        </svg>
        Dokumen
    </a>

    <div x-data="{ open: false }" class="mb-2">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                </svg>
                Approval
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-transition class="pl-6 mt-1 space-y-1" @click.away="open = false">
            <a href="{{ route('admin.approvals.cuti.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Cuti Karyawan</a>
            <a href="{{ route('admin.approvals.izin_sakit') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Izin / Sakit Karyawan</a>
            <a href="{{ route('admin.corrections.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Koreksi Absensi</a>
            <a href="{{ route('admin.overtimes.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Jam Lembur Karyawan</a>
        </div>
    </div>

    <a href="{{ route('admin.data.absensi.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
        Rekap Data Jam Karyawan
    </a>

    <a href="{{ route('admin.logs.index') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Activity Logs
    </a>

{{-- Employee --}}
@elseif(auth()->user()->role === 'employee')
    <a href="{{ route('employees.attendance.absensi') }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
        </svg>
        Absensi
    </a>

    <a href="{{ route('employees.documents.show_documents', Auth::user()->id) }}" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
        </svg>
        Dokumen
    </a>

    <div x-data="{ open: false }" class="mb-2">
        <button @click="open = !open" class="flex justify-between items-center w-full text-left py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-lg">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Pengajuan
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" x-transition class="pl-6 mt-1 space-y-1" @click.away="open = false">
            <a href="{{ route('sick.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Izin / Sakit</a>
            <a href="{{ route('leave.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Cuti</a>
            <a href="{{ route('employees.corrections.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Koreksi Absensi</a>
            <a href="{{ route('employees.overtime.index') }}" class="block py-2 px-3 rounded hover:bg-gray-100 hover:text-black text-base">Lembur</a>
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
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleButton = document.getElementById('toggleSidebar');
        const closeButton = document.getElementById('closeSidebar');
        // helper: apakah sedang di mobile ukuran (sama dengan md breakpoint)
        function isMobile() {
            return window.innerWidth < 768;
        }

        // close/open functions for mobile (these only affect mobile behavior)
        function mobileCloseSidebar() {
            // restore original desktop classes but keep mobile-only classes removed
            sidebar.classList.add('sidebar-collapsed');
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.remove('mobile-fullscreen');

            overlay.classList.add('overlay-hidden');
            overlay.classList.remove('overlay-visible');
        }

        function mobileOpenSidebar() {
            // on mobile: make it fullscreen + visible
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
            sidebar.classList.add('mobile-fullscreen');

            overlay.classList.remove('overlay-hidden');
            overlay.classList.add('overlay-visible');
        }

        // ✅ Tombol close di mobile
        closeButton.addEventListener('click', function () {
            sidebar.classList.add('sidebar-collapsed');
            sidebar.classList.remove('sidebar-expanded');
        });

        // Inisialisasi sesuai ukuran layar saat load:
        if (isMobile()) {
            // keep desktop markup intact but set mobile collapsed initially
            mobileCloseSidebar();
        } else {
            // Desktop: pastikan sidebar tetap sesuai previous desktop behavior
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
            // pastikan mobile classes tidak aktif
            sidebar.classList.remove('mobile-fullscreen');
            overlay.classList.add('overlay-hidden');
            overlay.classList.remove('overlay-visible');
        }

        // Toggle button: behave differently depending on device
        toggleButton.addEventListener('click', function () {
            if (isMobile()) {
                // mobile toggle uses fullscreen + overlay
                if (sidebar.classList.contains('mobile-fullscreen') && sidebar.classList.contains('sidebar-expanded')) {
                    mobileCloseSidebar();
                } else {
                    mobileOpenSidebar();
                }
            } else {
                // Desktop: keep original toggle behavior (width-based)
                sidebar.classList.toggle('sidebar-collapsed');
                sidebar.classList.toggle('sidebar-expanded');
            }
        });

        // Klik overlay -> tutup sidebar (mobile only)
        overlay.addEventListener('click', function () {
            if (isMobile()) mobileCloseSidebar();
        });

        // Resize handler: when resize crossing breakpoint, restore appropriate state
        window.addEventListener('resize', function () {
            if (isMobile()) {
                // switch to mobile default (closed)
                mobileCloseSidebar();
            } else {
                // switch to desktop default (open)
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                // remove mobile-only classes
                sidebar.classList.remove('mobile-fullscreen');
                overlay.classList.add('overlay-hidden');
                overlay.classList.remove('overlay-visible');
            }
        });

        // User dropdown (tetap seperti sebelumnya)
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

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    @yield('scripts')
</body>
</html>
