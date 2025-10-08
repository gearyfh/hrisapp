<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PT </title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center">

    <div class="flex w-full max-w-5xl bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <!-- Kiri -->
        <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-indigo-600 p-10 text-white">
            <img src="{{ asset('images/logo-pt.png') }}" alt="Logo PT" class="w-40 h-auto mb-6">
            <h1 class="text-3xl font-bold">PT .....</h1>
            <p class="text-indigo-100 mt-3">Selamat datang di sistem HRIS kami</p>
        </div>

        <!-- Kanan -->
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-center mb-8 text-white">Login ke Akun Anda</h2>

            @if (session('status'))
                <div class="bg-green-500 text-white text-center p-2 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input id="email" name="email" type="email" required autofocus
                        class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm">
                        <input type="checkbox" name="remember" class="mr-2 text-indigo-600">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition duration-200">
                    Login
                </button>
            </form>
        </div>
    </div>

</body>
</html>
