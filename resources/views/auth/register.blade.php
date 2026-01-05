<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - {{ config('app.name', 'Sistem Arsip Surat') }}</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Inter'] text-gray-900 antialiased">
<div class="min-h-screen flex">

    <!-- LEFT PANEL -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-700 via-blue-600 to-blue-800 text-white p-14">
        <div class="flex flex-col justify-center max-w-lg">

            <p class="uppercase tracking-widest text-sm text-blue-100 mb-4">
                Badan Pertanahan Nasional
            </p>

            <h1 class="text-4xl font-extrabold leading-tight mb-4">
                Sistem Arsip Surat
            </h1>

            <p class="text-blue-100 text-base max-w-md">
                Aplikasi pengelolaan arsip surat berbasis digital untuk mendukung administrasi
                yang cepat, aman, dan terstruktur.
            </p>

            <div class="mt-12 text-sm text-blue-200">
                © Badan Pertanahan Nasional 2025
            </div>
        </div>
    </div>

   <!-- RIGHT SIDE -->
    <div class="flex-1 flex items-center justify-center px-6">
        <div class="w-full max-w-md">

            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                Selamat Datang
            </h2>
            <p class="text-gray-500 mb-8">
                Silakan Daftar Akun Anda
            </p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nama -->
                <input type="text" name="name" placeholder="Nama Lengkap" required
                       class="w-full h-14 px-5 rounded-2xl
                              border border-gray-300
                              text-gray-700 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition">

                <!-- Email -->
                <input type="email" name="email" placeholder="Email" required
                       class="w-full h-14 px-5 rounded-2xl
                              border border-gray-300
                              text-gray-700 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition">

                <!-- Password -->
                <div class="relative">
                    <input id="password" type="password" name="password" placeholder="Password" required
                           class="w-full h-14 px-5 pr-12 rounded-2xl
                                  border border-gray-300
                                  text-gray-700 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition">

                    <button type="button" onclick="togglePassword('password')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        👁
                    </button>
                </div>

                <!-- Konfirmasi Password -->
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           placeholder="Konfirmasi Password" required
                           class="w-full h-14 px-5 pr-12 rounded-2xl
                                  border border-gray-300
                                  text-gray-700 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition">

                    <button type="button" onclick="togglePassword('password_confirmation')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        👁
                    </button>
                </div>

                <!-- Button -->
                <button type="submit"
                        class="w-full h-14 bg-blue-600 hover:bg-blue-700
                               text-white font-semibold rounded-full transition">
                    Daftar
                </button>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-1 h-px bg-gray-300"></div>
                    <span class="px-4 text-sm text-gray-500">Atau Daftar Dengan</span>
                    <div class="flex-1 h-px bg-gray-300"></div>
                </div>

                <!-- Google -->
                <button type="button"
                        class="w-full h-14 rounded-full border border-gray-300
                               flex items-center justify-center gap-3
                               hover:bg-gray-50 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5">
                    <span class="font-medium text-gray-700">Google</span>
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-8">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>