<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="d_hYjvoz1418rL43JJhJhrkybLY1O9DQBNhgOFyB720" />
    <meta name="description" content="Kita Kaktus - Toko Kaktus Online dengan berbagai koleksi kaktus mini, sukulen, dan tanaman hias berkualitas.">
    <meta name="keywords" content="kaktus, kaktus mini, sukulen, tanaman hias, toko kaktus, kita kaktus">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kita Kaktus')</title>
    
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Mobile First - Touch Friendly */
        @media (max-width: 768px) {
            button, .btn, a.btn, [type="submit"], [type="button"] {
                min-height: 44px;
                min-width: 44px;
            }
            input, select, textarea {
                font-size: 16px !important;
            }
        }
    </style>
</head>

@php
    $isAdmin = auth()->check() && auth()->user()->isAdmin();
    $isCustomer = auth()->check() && !auth()->user()->isAdmin();
    $isGuestOrCustomer = !auth()->check() || $isCustomer;

    $cartCount = 0;
    if ($isCustomer) {
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
    }
@endphp

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <nav class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-4">
            <div class="flex justify-between items-center py-3 md:py-4">
                <div class="flex items-center">
                    <a href="{{ $isAdmin ? route('admin.dashboard') : route('home') }}" class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">
                        Kita Kaktus
                    </a>
                </div>

                @if($isGuestOrCustomer)
                    <div class="md:hidden flex items-center gap-2">
                        <button type="button" aria-label="Ganti dark mode" class="theme-toggle w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 flex items-center justify-center">
                            <i aria-hidden="true" data-theme-icon class="fas fa-moon text-lg"></i>
                        </button>

                        <div class="relative">
                            <button id="mobileAccountBtn" type="button" aria-label="Buka pengaturan akun" aria-expanded="false" aria-controls="mobileAccountMenu" class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 flex items-center justify-center overflow-hidden">
                                @auth
                                    @if(auth()->user()->avatar)
                                        @if(Str::startsWith(auth()->user()->avatar, ['http://', 'https://']))
                                            <img src="{{ auth()->user()->avatar }}" 
                                                alt="{{ auth()->user()->name }}" 
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                        @elseif(Str::startsWith(auth()->user()->avatar, 'uploads/'))
                                            <img src="{{ asset(auth()->user()->avatar) }}" 
                                                alt="{{ auth()->user()->name }}" 
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                        @else
                                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                                alt="{{ auth()->user()->name }}" 
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                        @endif
                                    @else
                                        <i aria-hidden="true" class="fas fa-user-cog text-lg"></i>
                                    @endif
                                @else
                                    <i aria-hidden="true" class="fas fa-user text-lg"></i>
                                @endauth
                            </button>

                            <div id="mobileAccountMenu" class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-800 rounded-xl shadow-xl hidden z-50 border border-gray-200 dark:border-gray-700 overflow-hidden">
                                @auth
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                    </div>

                                    <a href="{{ route('profile.index') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i aria-hidden="true" class="fas fa-user-cog mr-2"></i> Pengaturan Akun
                                    </a>

                                    <form method="POST" action="{{ secure_url('/logout') }}">
                                        @csrf
                                        <button type="submit" aria-label="Logout" class="block w-full text-left px-4 py-3 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                                            <i aria-hidden="true" class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i aria-hidden="true" class="fas fa-sign-in-alt mr-2"></i> Login
                                    </a>

                                    <a href="{{ route('register') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i aria-hidden="true" class="fas fa-user-plus mr-2"></i> Register
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endif

                @if($isAdmin)
                    <button id="mobileMenuButton" type="button" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobileMenu" class="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                        <i aria-hidden="true" class="fas fa-bars text-xl"></i>
                    </button>
                @endif
                
                <div class="hidden md:flex items-center space-x-4 lg:space-x-6">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="relative">
                                <button id="adminMenuBtn" type="button" aria-label="Buka menu admin" aria-expanded="false" aria-controls="adminMenu" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-sm">
                                    <i aria-hidden="true" class="fas fa-cog"></i> Menu Admin
                                </button>
                                <div id="adminMenu" class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-xl hidden z-50 border border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i aria-hidden="true" class="fas fa-chart-line mr-2"></i> Dashboard</a>
                                    <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i aria-hidden="true" class="fas fa-box mr-2"></i> Kelola Produk</a>
                                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i aria-hidden="true" class="fas fa-tags mr-2"></i> Kelola Kategori</a>
                                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i aria-hidden="true" class="fas fa-users mr-2"></i> Kelola User</a>
                                    <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i aria-hidden="true" class="fas fa-shopping-cart mr-2"></i> Kelola Pesanan</a>
                                    <a href="{{ route('admin.ratings.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i aria-hidden="true" class="fas fa-star mr-2"></i> Kelola Rating</a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">Home</a>
                            <a href="{{ route('collection.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">
                                <i aria-hidden="true" class="fas fa-store"></i> Koleksi
                            </a>
                            <a href="{{ route('cart.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 relative">
                                <i aria-hidden="true" class="fas fa-shopping-cart text-lg"></i>
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('orders.history') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">
                                <i aria-hidden="true" class="fas fa-history"></i> Pesanan
                            </a>
                        @endif
                        
                        <button type="button" aria-label="Ganti dark mode" class="theme-toggle p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i aria-hidden="true" data-theme-icon class="fas fa-moon"></i>
                        </button>
                        
                        <div class="relative">
                            <button id="profileBtn" type="button" aria-label="Buka menu profil" aria-expanded="false" aria-controls="profileMenu" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 flex items-center space-x-2 text-sm">
                                @if(auth()->user()->avatar)
                                    @if(Str::startsWith(auth()->user()->avatar, ['http://', 'https://']))
                                        <img src="{{ auth()->user()->avatar }}" 
                                            alt="{{ auth()->user()->name }}" 
                                            class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                    @elseif(Str::startsWith(auth()->user()->avatar, 'uploads/'))
                                        <img src="{{ asset(auth()->user()->avatar) }}" 
                                            alt="{{ auth()->user()->name }}" 
                                            class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                    @else
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                            alt="{{ auth()->user()->name }}" 
                                            class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                    @endif
                                @else
                                    <i aria-hidden="true" class="fas fa-user-circle text-xl"></i>
                                @endif

                                <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->isAdmin())
                                    <span class="text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full">Admin</span>
                                @endif
                                <i aria-hidden="true" class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl hidden z-50 border border-gray-200 dark:border-gray-700">
                                @if(!auth()->user()->isAdmin())
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i aria-hidden="true" class="fas fa-user-cog mr-2"></i> Pengaturan Akun
                                    </a>
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                @endif
                                <form method="POST" action="{{ secure_url('/logout') }}">
                                    @csrf
                                    <button type="submit" aria-label="Logout" class="block w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                                         <i aria-hidden="true" class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">Home</a>
                        <a href="{{ route('collection.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">
                            <i aria-hidden="true" class="fas fa-store"></i> Koleksi
                        </a>
                        
                        <button type="button" aria-label="Ganti dark mode" class="theme-toggle p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i aria-hidden="true" data-theme-icon class="fas fa-moon"></i>
                        </button>
                        
                        <a href="{{ route('login') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 text-sm">Login</a>
                        <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">Register</a>
                    @endauth
                </div>
            </div>
            
            @if($isAdmin)
                <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.dashboard') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Produk</a>
                    <a href="{{ route('admin.categories.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Kategori</a>
                    <a href="{{ route('admin.users.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola User</a>
                    <a href="{{ route('admin.orders.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Pesanan</a>
                    <a href="{{ route('admin.ratings.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Rating</a>
                    
                    <button type="button" aria-label="Ganti dark mode" class="theme-toggle w-full mt-2 py-3 px-2 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg flex items-center gap-2">
                        <i aria-hidden="true" data-theme-icon class="fas fa-moon"></i>
                        <span data-theme-text>Dark Mode</span>
                    </button>
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                    
                    <div class="flex items-center justify-between py-3 px-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ secure_url('/logout') }}">
                            @csrf
                            <button type="submit" aria-label="Logout" class="text-red-600 text-sm">Logout</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </nav>

    @if(session('success'))
        <div id="flash-success" class="fixed top-20 right-4 left-4 md:left-auto z-50 flex items-center w-full md:max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <i aria-hidden="true" class="fas fa-check-circle"></i>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
            <button type="button" aria-label="Tutup notifikasi" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.closest('#flash-success').remove()">
                <span class="sr-only">Close</span>
                <i aria-hidden="true" class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" class="fixed top-20 right-4 left-4 md:left-auto z-50 flex items-center w-full md:max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <i aria-hidden="true" class="fas fa-exclamation-circle"></i>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('error') }}</div>
            <button type="button" aria-label="Tutup notifikasi" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.closest('#flash-error').remove()">
                <span class="sr-only">Close</span>
                <i aria-hidden="true" class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 py-4 md:py-8 {{ $isGuestOrCustomer ? 'pb-28 md:pb-8' : '' }}">
        @yield('content')
    </main>

    @if (!request()->routeIs('login') && !request()->routeIs('register'))
        <footer class="bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 mt-12 border-t border-gray-200 dark:border-gray-700 {{ $isGuestOrCustomer ? 'mb-24 md:mb-0' : '' }}">
            <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                    
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Kita Kaktus</h3>
                        <p class="text-sm leading-relaxed mb-4">
                            Toko kaktus online terpercaya yang menyediakan berbagai koleksi kaktus mini, sukulen, dan tanaman hias premium untuk mempercantik rumah Anda.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Kunjungi Kebun Kami</h3>
                        <p class="text-sm leading-relaxed mb-3 flex items-start justify-center md:justify-start">
                            <i aria-hidden="true" class="fas fa-map-marker-alt text-green-500 mt-1 mr-3"></i>
                            <span class="text-left">
                                Jl. H. Sanip No.56, Grogol,<br>
                                Kec. Limo, Kota Depok, Jawa Barat 16514
                            </span>
                        </p>
                        <a href="https://maps.app.goo.gl/Nhj1AzWwKUe58w8e9" target="_blank" rel="noopener noreferrer" class="inline-block text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition duration-300">
                            Lihat di Google Maps →
                        </a>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Ikuti Kami</h3>
                        <div class="flex justify-center md:justify-start space-x-4">
                            <a href="https://www.instagram.com/kita_kaktus/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Kita Kaktus" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-pink-500 hover:to-purple-500 hover:text-white transition-all duration-300 shadow-sm">
                                <i aria-hidden="true" class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="https://www.tiktok.com/@kitakaktus" target="_blank" rel="noopener noreferrer" aria-label="TikTok Kita Kaktus" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-black hover:text-white transition-all duration-300 shadow-sm">
                                <i aria-hidden="true" class="fab fa-tiktok text-lg"></i>
                            </a>
                            <a href="https://shopee.co.id/kita_kaktus?entryPoint=ShopBySearch&searchKeyword=kita%20kaktus" target="_blank" rel="noopener noreferrer" aria-label="Shopee Kita Kaktus" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-orange-500 hover:text-white transition-all duration-300 shadow-sm">
                                <i aria-hidden="true" class="fas fa-shopping-bag text-lg"></i>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-6 text-center text-sm">
                    <p>© {{ date('Y') }} Kita Kaktus. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </footer>
    @endif

    @if($isGuestOrCustomer)
        <div class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-1.5rem)] max-w-md md:hidden">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-2xl px-2 py-2 grid grid-cols-4 gap-1">
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center rounded-xl py-2 {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'text-gray-600 dark:text-gray-300' }}">
                    <i aria-hidden="true" class="fas fa-home text-xl mb-1"></i>
                </a>

                <a href="{{ route('collection.index') }}" class="flex flex-col items-center justify-center rounded-xl py-2 {{ request()->routeIs('collection.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'text-gray-600 dark:text-gray-300' }}">
                    <i aria-hidden="true" class="fas fa-search text-xl mb-1"></i>
                </a>

                <a href="{{ $isCustomer ? route('cart.index') : route('login') }}" class="relative flex flex-col items-center justify-center rounded-xl py-2 {{ request()->routeIs('cart.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'text-gray-600 dark:text-gray-300' }}">
                    <i aria-hidden="true" class="fas fa-shopping-cart text-xl mb-1"></i>

                    @if($cartCount > 0)
                        <span class="absolute top-1 right-5 bg-red-500 text-white text-[10px] rounded-full min-w-[18px] h-[18px] px-1 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ $isCustomer ? route('orders.history') : route('login') }}" class="flex flex-col items-center justify-center rounded-xl py-2 {{ request()->routeIs('orders.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : 'text-gray-600 dark:text-gray-300' }}">
                    <i aria-hidden="true" class="fas fa-history text-xl mb-1"></i>
                </a>
            </div>
        </div>
    @endif

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS for scroll animation
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
        
        // Mobile menu toggle khusus admin
        const mobileMenuBtn = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', mobileMenu.classList.contains('hidden') ? 'false' : 'true');
            });
        }

        // Mobile account dropdown untuk guest & customer
        const mobileAccountBtn = document.getElementById('mobileAccountBtn');
        const mobileAccountMenu = document.getElementById('mobileAccountMenu');
        if (mobileAccountBtn && mobileAccountMenu) {
            mobileAccountBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                mobileAccountMenu.classList.toggle('hidden');
                mobileAccountBtn.setAttribute('aria-expanded', mobileAccountMenu.classList.contains('hidden') ? 'false' : 'true');
            });
        }
        
        // Auto-hide flash messages after 3 seconds
        setTimeout(function() {
            const successFlash = document.getElementById('flash-success');
            const errorFlash = document.getElementById('flash-error');
            
            if (successFlash) {
                successFlash.style.transition = 'opacity 0.5s';
                successFlash.style.opacity = '0';
                setTimeout(function() {
                    successFlash.remove();
                }, 500);
            }
            if (errorFlash) {
                errorFlash.style.transition = 'opacity 0.5s';
                errorFlash.style.opacity = '0';
                setTimeout(function() {
                    errorFlash.remove();
                }, 500);
            }
        }, 3000);
        
        // Admin menu toggle
        const adminMenuBtn = document.getElementById('adminMenuBtn');
        const adminMenu = document.getElementById('adminMenu');
        if (adminMenuBtn && adminMenu) {
            adminMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                adminMenu.classList.toggle('hidden');
                adminMenuBtn.setAttribute('aria-expanded', adminMenu.classList.contains('hidden') ? 'false' : 'true');
            });
        }
        
        // Profile menu toggle
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');
        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
                profileBtn.setAttribute('aria-expanded', profileMenu.classList.contains('hidden') ? 'false' : 'true');
            });
        }
        
        // Close menus when clicking outside
        document.addEventListener('click', (e) => {
            if (adminMenuBtn && adminMenu && !adminMenuBtn.contains(e.target) && !adminMenu.contains(e.target)) {
                adminMenu.classList.add('hidden');
                adminMenuBtn.setAttribute('aria-expanded', 'false');
            }

            if (profileBtn && profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.add('hidden');
                profileBtn.setAttribute('aria-expanded', 'false');
            }

            if (mobileAccountBtn && mobileAccountMenu && !mobileAccountBtn.contains(e.target) && !mobileAccountMenu.contains(e.target)) {
                mobileAccountMenu.classList.add('hidden');
                mobileAccountBtn.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Dark Mode Management
        const darkModeManager = {
            init() {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    this.enableDarkMode(false);
                } else {
                    this.disableDarkMode(false);
                }

                this.bindButtons();
                this.updateIconsAndText();
            },
            
            enableDarkMode(updateStorage = true) {
                document.documentElement.classList.add('dark');
                if (updateStorage) localStorage.setItem('theme', 'dark');
                this.updateIconsAndText();
            },
            
            disableDarkMode(updateStorage = true) {
                document.documentElement.classList.remove('dark');
                if (updateStorage) localStorage.setItem('theme', 'light');
                this.updateIconsAndText();
            },
            
            toggle() {
                if (document.documentElement.classList.contains('dark')) {
                    this.disableDarkMode();
                } else {
                    this.enableDarkMode();
                }
            },

            bindButtons() {
                document.querySelectorAll('.theme-toggle').forEach((button) => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.toggle();
                    });
                });
            },
            
            updateIconsAndText() {
                const isDark = document.documentElement.classList.contains('dark');
                
                document.querySelectorAll('[data-theme-icon]').forEach((icon) => {
                    if (isDark) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    } else {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                });

                document.querySelectorAll('[data-theme-text]').forEach((text) => {
                    text.textContent = isDark ? 'Light Mode' : 'Dark Mode';
                });
            }
        };
        
        darkModeManager.init();
    </script>
    
    @stack('scripts')
</body>
</html>