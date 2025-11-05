<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0f1225] text-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-[#1a1f3b] rounded-2xl shadow-lg p-8">
        <div class="text-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-12 h-12 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 .828-.895 1.5-2 1.5S8 11.828 8 11V7a3 3 0 116 0v4z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 11v2a6 6 0 0012 0v-2" />
            </svg>
            <h2 class="text-xl font-semibold mt-4">Forgot your password?</h2>
            <p class="text-sm text-gray-400 mt-2">
                No problem. Enter your email below and we’ll send a reset link so you can create a new one.
            </p>
        </div>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email"
                    class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-200">
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </div>
</body>
</html>
