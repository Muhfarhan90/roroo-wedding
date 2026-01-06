<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ROROO MUA Admin</title>
    <meta name="description" content="RORO MUA Admin Login">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gray-50 antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <img src="{{ asset('logo/logo-roroo-wedding.png') }}" alt="RORO MUA Logo"
                    class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-[#d4b896] object-cover">
                <h1 class="text-3xl font-bold text-[#d4b896] tracking-wider">ROROO MUA Admin</h1>
                <p class="text-gray-500 text-sm mt-1">Please log in to your account</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-8 shadow-lg">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-black mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">email</span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                autofocus
                                class="w-full pl-12 pr-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('email') border-red-500 @enderror"
                                placeholder="Miminroro1@gmail.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-black mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">lock</span>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-12 pr-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 text-[#d4b896] border-gray-300 rounded focus:ring-[#d4b896]">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-semibold shadow-sm">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
