{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HRIS App</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 text-white min-h-screen p-4 flex flex-col">

                <h2 class="text-lg font-bold mb-6">Menu</h2>
                <a href="/dashboard" class="mb-3 hover:underline">Dashboard</a>
                <a href="/absensi" class="mb-3 hover:underline">Absensi</a>
                <a href="/company" class="mb-3 hover:underline">Company</a>
                <a href="/karyawan" class="mb-3 hover:underline">Karyawan</a>
                <a href="/dokumen" class="mb-3 hover:underline">Dokumen</a>
                <div class="mt-auto">
                    <a href="/settings" class="hover:underline">Settings</a>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6">
                <header class="mb-6">
                    <h1 class="text-2xl">Hello, </h1>
                </header>
                <section>
                    @yield('content')
                </section>
            </main>
        </div>
    </body>
    </html>
