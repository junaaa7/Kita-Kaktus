<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kita Kaktus')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-green-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-white text-2xl font-bold">
                        🌵 Kita Kaktus
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <!-- Menu Admin -->
                            <div class="relative">
                                <button id="adminMenuBtn" class="text-white hover:text-green-200 px-4 py-2 rounded-lg bg-green-700">
                                    <i class="fas fa-cog"></i> Menu Admin
                                </button>
                                <div id="adminMenu" class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl hidden z-50">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 border-b">
                                        <i class="fas fa-chart-line w-5"></i> Dashboard
                                    </a>
                                    <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 border-b">
                                        <i class="fas fa-box w-5"></i> Kelola Produk
                                    </a>
                                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 border-b">
                                        <i class="fas fa-tags w-5"></i> Kelola Kategori
                                    </a>
                                    <a href="{{ route('admin.orders.index') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-shopping-cart w-5"></i> Kelola Pesanan
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Menu User yang sudah login -->
                            <a href="{{ route('home') }}" class="text-white hover:text-green-200">Home</a>
                            <a href="{{ route('cart.index') }}" class="text-white hover:text-green-200 relative">
                                <i class="fas fa-shopping-cart text-xl"></i>
                                @php
                                    $cartCount = count(session()->get('cart', []));
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('orders.history') }}" class="text-white hover:text-green-200">
                                <i class="fas fa-history"></i> Pesanan
                            </a>
                        @endif
                        
                        <!-- Profile & Logout -->
                        <div class="relative">
                            <button id="profileBtn" class="text-white hover:text-green-200 flex items-center space-x-2">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span>{{ auth()->user()->name }}</span>
                                @if(auth()->user()->isAdmin())
                                    <span class="text-xs bg-yellow-500 px-2 py-0.5 rounded-full">Admin</span>
                                @endif
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-50">
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-3 text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt w-5"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Menu untuk user yang belum login - TAMPILKAN TOMBOL LOGIN & REGISTER -->
                        <a href="{{ route('home') }}" class="text-white hover:text-green-200">Home</a>
                        <a href="{{ route('login') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 max-w-7xl mx-auto mt-4">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 max-w-7xl mx-auto mt-4">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 max-w-7xl mx-auto mt-4">
            @foreach($errors->all() as $error)
                <p><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <script>
        // Admin menu toggle
        const adminMenuBtn = document.getElementById('adminMenuBtn');
        const adminMenu = document.getElementById('adminMenu');
        if (adminMenuBtn) {
            adminMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                adminMenu.classList.toggle('hidden');
            });
        }
        
        // Profile menu toggle
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');
        if (profileBtn) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });
        }
        
        // Close menus when clicking outside
        document.addEventListener('click', (e) => {
            if (adminMenuBtn && !adminMenuBtn.contains(e.target) && !adminMenu?.contains(e.target)) {
                adminMenu?.classList.add('hidden');
            }
            if (profileBtn && !profileBtn.contains(e.target) && !profileMenu?.contains(e.target)) {
                profileMenu?.classList.add('hidden');
            }
        });
        
        // Confirm logout
        const logoutForm = document.getElementById('logoutForm');
        if (logoutForm) {
            logoutForm.addEventListener('submit', (e) => {
                if (!confirm('Yakin ingin logout?')) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>
</html>