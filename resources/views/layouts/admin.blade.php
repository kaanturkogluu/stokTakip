<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Macrotech')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out fixed lg:static z-30">
            <div class="p-4">
                <!-- Logo -->
                <div class="flex items-center mb-8">
                    <img src="/images/logo.svg" alt="Macrotech Logo" class="h-8 w-auto mr-3">
                    <span class="text-xl font-bold">Admin Panel</span>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.phones.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition duration-200 {{ request()->routeIs('admin.phones.index') ? 'bg-gray-700 text-white' : '' }}">
                        <i class="fas fa-list mr-3"></i>
                        Telefonlar
                    </a>
                    <a href="{{ route('admin.phones.create') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition duration-200 {{ request()->routeIs('admin.phones.create') ? 'bg-gray-700 text-white' : '' }}">
                        <i class="fas fa-plus mr-3"></i>
                        Telefon Ekle
                    </a>
                    
                    <a href="{{ route('admin.data.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition duration-200 {{ request()->routeIs('admin.data.*') ? 'bg-gray-700 text-white' : '' }}">
                        <i class="fas fa-database mr-3"></i>
                        Veri Yönetimi
                    </a>
                    
                    <div class="pt-2">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Diğer</p>
                    </div>
                    
                    <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition duration-200 {{ request()->routeIs('admin.reports') ? 'bg-gray-700 text-white' : '' }}">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Raporlar
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition duration-200 {{ request()->routeIs('admin.settings') ? 'bg-gray-700 text-white' : '' }}">
                        <i class="fas fa-cog mr-3"></i>
                        Ayarlar
                    </a>
                </nav>
            </div>

            <!-- Logout Button -->
            <div class="absolute bottom-4 left-4 right-4">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition duration-200">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Çıkış Yap
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 py-3">
                    <!-- Mobile Menu Button -->
                    <button id="sidebar-toggle" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Page Title -->
                    <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>

                    <!-- User Info -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Admin</span>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>

    @stack('scripts')
    
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
