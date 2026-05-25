<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kita Kaktus')</title>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- AOS CSS for scroll animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Vite CSS & JS -->
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
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-4">
            <div class="flex justify-between items-center py-3 md:py-4">
                <div class="flex items-center">
                    <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">
                        Kita Kaktus
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuButton" class="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-4 lg:space-x-6">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <!-- Admin Dropdown -->
                            <div class="relative">
                                <button id="adminMenuBtn" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-sm">
                                    <i class="fas fa-cog"></i> Menu Admin
                                </button>
                                <div id="adminMenu" class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-xl hidden z-50 border border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-chart-line mr-2"></i> Dashboard</a>
                                    <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-box mr-2"></i> Kelola Produk</a>
                                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-tags mr-2"></i> Kelola Kategori</a>
                                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-users mr-2"></i> Kelola User</a>
                                    <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-shopping-cart mr-2"></i> Kelola Pesanan</a>
                                    <a href="{{ route('admin.ratings.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-star mr-2"></i> Kelola Rating</a>
                                </div>
                            </div>
                        @else
                            <!-- Menu User -->
                            <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">Home</a>
                            <a href="{{ route('collection.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">
                                <i class="fas fa-store"></i> Koleksi
                            </a>
                            <a href="{{ route('cart.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 relative">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                @php
                                    $cartCount = 0;
                                    if(auth()->check()) {
                                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                                    }
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('orders.history') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">
                                <i class="fas fa-history"></i> Pesanan
                            </a>
                        @endif
                        
                        <!-- Dark Mode Toggle Button -->
                        <button id="theme-toggle" class="theme-toggle p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i id="theme-toggle-icon" class="fas fa-moon"></i>
                        </button>
                        
                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <button id="profileBtn" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 flex items-center space-x-2 text-sm">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->isAdmin())
                                    <span class="text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full">Admin</span>
                                @endif
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl hidden z-50 border border-gray-200 dark:border-gray-700">
                                <form method="POST" action="{{ secure_url('/logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                                         <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Menu untuk Guest -->
                        <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">Home</a>
                        <a href="{{ route('collection.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 text-sm">
                            <i class="fas fa-store"></i> Koleksi
                        </a>
                        
                        <!-- Dark Mode Toggle Button for Guest -->
                        <button id="theme-toggle-guest" class="theme-toggle p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i id="theme-toggle-icon-guest" class="fas fa-moon"></i>
                        </button>
                        
                        <a href="{{ route('login') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 text-sm">Login</a>
                        <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">Register</a>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile Menu (Hidden by default) - DENGAN TEKS DARK MODE -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-gray-200 dark:border-gray-700">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Produk</a>
                        <a href="{{ route('admin.categories.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Kategori</a>
                        <a href="{{ route('admin.users.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola User</a>
                        <a href="{{ route('admin.orders.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Pesanan</a>
                        <a href="{{ route('admin.ratings.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Kelola Rating</a>
                        
                        <!-- Dark Mode Toggle di Mobile Menu dengan Teks -->
                        <button id="theme-toggle-mobile" class="w-full mt-2 py-3 px-2 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg flex items-center gap-2">
                            <i id="theme-toggle-icon-mobile" class="fas fa-moon"></i>
                            <span id="theme-toggle-text-mobile">Dark Mode</span>
                        </button>
                    @else
                        <a href="{{ route('home') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Home</a>
                        <a href="{{ route('collection.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Koleksi</a>
                        <a href="{{ route('cart.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base relative">
                            Keranjang
                            @if($cartCount > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('orders.history') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Pesanan</a>
                        
                        <!-- Dark Mode Toggle di Mobile Menu dengan Teks -->
                        <button id="theme-toggle-mobile" class="w-full mt-2 py-3 px-2 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg flex items-center gap-2">
                            <i id="theme-toggle-icon-mobile" class="fas fa-moon"></i>
                            <span id="theme-toggle-text-mobile">Dark Mode</span>
                        </button>
                    @endif
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                    
                    <div class="flex items-center justify-between py-3 px-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ secure_url('/logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 text-sm">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('home') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Home</a>
                    <a href="{{ route('collection.index') }}" class="block py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-base">Koleksi</a>
                    
                    <!-- Dark Mode Toggle di Mobile Menu untuk Guest dengan Teks -->
                    <button id="theme-toggle-mobile-guest" class="w-full mt-2 py-3 px-2 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg flex items-center gap-2">
                        <i id="theme-toggle-icon-mobile-guest" class="fas fa-moon"></i>
                        <span id="theme-toggle-text-mobile-guest">Dark Mode</span>
                    </button>
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                    <a href="{{ route('login') }}" class="block py-3 px-2 text-center bg-yellow-500 text-white rounded-lg mb-2">Login</a>
                    <a href="{{ route('register') }}" class="block py-3 px-2 text-center bg-green-600 text-white rounded-lg">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages dengan Auto-Hide -->
    @if(session('success'))
        <div id="flash-success" class="fixed top-20 right-4 left-4 md:left-auto z-50 flex items-center w-full md:max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.closest('#flash-success').remove()">
                <span class="sr-only">Close</span>
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" class="fixed top-20 right-4 left-4 md:left-auto z-50 flex items-center w-full md:max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('error') }}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.closest('#flash-error').remove()">
                <span class="sr-only">Close</span>
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 py-4 md:py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 mt-12 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 py-6 md:py-8">
            <div class="text-center text-sm">
                <p>&copy; 2026 Kita Kaktus.</p>
                <p class="text-xs mt-1">Toko Kaktus Online Terpercaya</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS for scroll animation
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
        
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
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
        
        // ========== DARK MODE MANAGEMENT - DENGAN TEKS ==========
        const darkModeManager = {
            init() {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    this.enableDarkMode();
                } else {
                    this.disableDarkMode();
                }
                this.updateAllIconsAndText();
            },
            
            enableDarkMode() {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                this.updateAllIconsAndText();
            },
            
            disableDarkMode() {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                this.updateAllIconsAndText();
            },
            
            toggle() {
                if (document.documentElement.classList.contains('dark')) {
                    this.disableDarkMode();
                } else {
                    this.enableDarkMode();
                }
            },
            
            updateAllIconsAndText() {
                const isDark = document.documentElement.classList.contains('dark');
                
                // Update icons
                const iconIds = ['theme-toggle-icon', 'theme-toggle-icon-guest', 'theme-toggle-icon-mobile', 'theme-toggle-icon-mobile-guest'];
                iconIds.forEach(id => {
                    const icon = document.getElementById(id);
                    if (icon) {
                        if (isDark) {
                            icon.classList.remove('fa-moon');
                            icon.classList.add('fa-sun');
                        } else {
                            icon.classList.remove('fa-sun');
                            icon.classList.add('fa-moon');
                        }
                    }
                });
                
                // Update text for mobile buttons
                const mobileTextId = isDark ? 'Light Mode' : 'Dark Mode';
                const mobileTextSpans = ['theme-toggle-text-mobile', 'theme-toggle-text-mobile-guest'];
                mobileTextSpans.forEach(id => {
                    const textSpan = document.getElementById(id);
                    if (textSpan) {
                        textSpan.textContent = mobileTextId;
                    }
                });
            },
            
            fixButtons() {
                // Desktop buttons
                const desktopBtns = ['theme-toggle', 'theme-toggle-guest'];
                desktopBtns.forEach(btnId => {
                    const btn = document.getElementById(btnId);
                    if (btn) {
                        const newBtn = btn.cloneNode(true);
                        btn.parentNode.replaceChild(newBtn, btn);
                        newBtn.onclick = (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.toggle();
                            return false;
                        };
                    }
                });
                
                // Mobile buttons
                const mobileBtns = ['theme-toggle-mobile', 'theme-toggle-mobile-guest'];
                mobileBtns.forEach(btnId => {
                    const btn = document.getElementById(btnId);
                    if (btn) {
                        const newBtn = btn.cloneNode(true);
                        btn.parentNode.replaceChild(newBtn, btn);
                        newBtn.onclick = (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.toggle();
                            return false;
                        };
                    }
                });
            }
        };
        
        // Initialize dark mode
        darkModeManager.init();
        darkModeManager.fixButtons();
        
        // Re-fix buttons periodically to ensure they work after navigation
        setInterval(() => {
            darkModeManager.fixButtons();
        }, 500);
    </script>
    
    @stack('scripts')
</body>
</html>