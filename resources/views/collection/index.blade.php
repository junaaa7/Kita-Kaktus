@extends('layouts.app')

@section('title', 'Koleksi Kaktus - Kita Kaktus')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <!-- Header Section - Responsive -->
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-1 md:mb-2">Koleksi Kaktus</h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Temukan berbagai koleksi kaktus terbaik dari Kita Kaktus</p>
    </div>

    <!-- Filter & Sort Section - Responsive -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('collection.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4">
            <!-- Filter Kategori -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                <select name="category" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Harga Min -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Min (Rp)</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" 
                       class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <!-- Filter Harga Max -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Max (Rp)</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="0" 
                       class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <!-- Sort -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Urutkan</label>
                <select name="sort" class="w-full px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                </select>
            </div>
            
            <!-- Button -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white px-3 sm:px-4 py-2 rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('collection.index') }}" class="flex-1 sm:flex-none bg-gray-500 hover:bg-gray-600 text-white px-3 sm:px-4 py-2 rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Result Info - Responsive -->
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-2">
        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</p>
    </div>

    <!-- Products Grid - Responsive -->
    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        @forelse($products as $product)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
            <div class="h-48 sm:h-56 overflow-hidden">
                @if($product->image)
                    <img src="{{ asset($product->image) }}"
                        alt="{{ $product->name }}"
                        loading="lazy"
                        decoding="async"
                        fetchpriority="low"
                        class="w-full h-full object-cover hover:scale-110 transition duration-300">
                @else
                    <div class="w-full h-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="fas fa-cactus text-5xl sm:text-6xl text-gray-500 dark:text-gray-400"></i>
                    </div>
                @endif
            </div>
            <div class="p-3 sm:p-4">
                <div class="mb-2">
                    <span class="text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-2 py-1 rounded-full">{{ $product->category->name }}</span>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white mb-1 sm:mb-2 line-clamp-1">{{ $product->name }}</h3>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-green-600 dark:text-green-400 font-bold text-lg sm:text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-500">
                        <i class="fas fa-boxes"></i> {{ $product->stock }}
                    </span>
                </div>
                
                @auth
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 sm:py-2.5 rounded-lg transition font-semibold text-sm sm:text-base">
                                <i class="fas fa-shopping-cart mr-1 sm:mr-2"></i> Beli Sekarang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-400 dark:bg-gray-600 text-white py-2 sm:py-2.5 rounded-lg cursor-not-allowed text-sm sm:text-base">
                            Stok Habis
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 sm:py-2.5 rounded-lg transition font-semibold text-sm sm:text-base">
                        <i class="fas fa-sign-in-alt mr-1 sm:mr-2"></i> Login untuk Beli
                    </a>
                @endauth
                
                <a href="{{ route('product.detail', $product) }}" class="block text-center mt-2 text-green-600 dark:text-green-400 hover:text-green-700 text-xs sm:text-sm">
                    Lihat Detail →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <i class="fas fa-box-open text-5xl sm:text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-base sm:text-lg">Belum ada produk tersedia</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination - Responsive -->
    <div class="mt-6 md:mt-8">
        {{ $products->withQueryString()->links('pagination::tailwind') }}
    </div>
</div>
@endsection