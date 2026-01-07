<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Surat Keluar') - Aplikasi Surat Keluar</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex h-screen bg-gray-100">
            <!-- Sidebar -->
            <aside id="sidebar" class="fixed left-0 top-0 w-64 h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white shadow-lg transform transition-transform duration-300 ease-in-out z-40 md:relative md:translate-x-0 -translate-x-full">
                <!-- Logo/Brand -->
                <div class="flex items-center justify-between h-16 px-6 bg-blue-950">
                    <div class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h6a1 1 0 011 1v12a1 1 0 11-2 0V4H3a1 1 0 01-1-1zm8-1a1 1 0 011 1v12a1 1 0 11-2 0V3a1 1 0 011-1zm5-1a1 1 0 011 1v12a1 1 0 11-2 0V2a1 1 0 011-1z"/>
                        </svg>
                        <span class="text-xl font-bold">SuratApp</span>
                    </div>
                    <button id="sidebar-close" class="md:hidden text-white hover:text-yellow-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Surat Keluar -->
                    <a href="{{ route('surat-keluars.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors {{ request()->routeIs('surat-keluars.*') ? 'bg-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z"/>
                        </svg>
                        <span>Surat Keluar</span>
                    </a>

                    <!-- User Management (Admin Only) -->
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors {{ request()->routeIs('users.*') ? 'bg-blue-700' : '' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M6.5 6.5a2 2 0 110-4 2 2 0 010 4zM1.5 16.5s0-4 4.5-4 4.5 4 4.5 4M13 1.5v6m3-3h-6"/>
                                </svg>
                                <span>Manajemen User</span>
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- User Profile Section -->
                <div class="border-t border-blue-700 p-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-blue-900 font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-blue-200 uppercase">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </aside>

            <!-- Mobile Sidebar Toggle & Main Content -->
            <div class="flex-1 flex flex-col w-full md:w-auto">
                <!-- Top Navigation Bar -->
                <header class="bg-white shadow-sm h-16 flex items-center px-6 sticky top-0 z-30">
                    <button id="sidebar-toggle" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="flex-1">
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Aplikasi Surat Keluar')</h1>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-auto">
                    <div class="p-3 sm:p-6">
                        <!-- Flash Messages -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <h3 class="text-sm font-semibold text-red-800 mb-2">Terjadi Kesalahan:</h3>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm text-red-700">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center space-x-3">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm text-green-800">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center space-x-3">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm text-red-800">{{ session('error') }}</p>
                            </div>
                        @endif

                        <!-- Page Content -->
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <!-- Sidebar Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 md:hidden"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebarClose = document.getElementById('sidebar-close');
                const sidebarOverlay = document.getElementById('sidebar-overlay');

                const toggleSidebar = () => {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('hidden');
                };

                sidebarToggle?.addEventListener('click', toggleSidebar);
                sidebarClose?.addEventListener('click', toggleSidebar);
                sidebarOverlay?.addEventListener('click', toggleSidebar);
            });
        </script>
    </body>
</html>
