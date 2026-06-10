@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Button Back Khusus Mobile -->
    <div class="md:hidden mb-4">
        <a 
            href="{{ url()->previous() }}" 
            class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
        >
            <i class="fas fa-arrow-left"></i>
            <span class="font-medium">Kembali</span>
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            
            <!-- Gambar Produk -->
            <div class="p-6">
                @if($product->image)
                    <img 
                        src="{{ asset($product->image) }}"
                        alt="{{ $product->name }}" 
                        class="w-full rounded-lg"
                    >
                @else
                    <div class="w-full h-96 bg-gray-300 dark:bg-gray-600 flex items-center justify-center rounded-lg">
                        <i class="fas fa-cactus text-6xl text-gray-500 dark:text-gray-400"></i>
                    </div>
                @endif
            </div>
            
            <!-- Detail Produk -->
            <div class="p-6">
                
                <div class="mb-2">
                    <span class="text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-2 py-1 rounded-full">
                        Ready Stock
                    </span>
                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
                    {{ $product->name }}
                </h1>

                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Kategori: {{ $product->category->name }}
                </p>

                <div class="text-3xl text-green-600 dark:text-green-400 font-bold mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="mb-4">
                    <span class="text-gray-600 dark:text-gray-400">
                        Stok tersisa:
                    </span>

                    @if($product->stock > 0)
                        <span class="text-green-600 dark:text-green-400 font-semibold">
                            {{ $product->stock }} unit
                        </span>
                    @else
                        <span class="text-red-600 dark:text-red-400 font-semibold">
                            Stok Habis
                        </span>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-2">
                        Deskripsi Produk:
                    </h3>

                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $product->description }}
                    </p>
                </div>
                
                <!-- TOMBOL CHECKOUT -->
                @auth
                    @if($product->stock > 0)

                        <div class="space-y-3">
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                                @csrf

                                <button 
                                    type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg transition font-semibold text-lg"
                                >
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Beli Sekarang (Checkout)
                                </button>
                            </form>

                            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-lock mr-1"></i>
                                Pembayaran aman dan terpercaya
                            </div>
                        </div>

                    @else

                        <button 
                            disabled 
                            class="w-full bg-gray-400 dark:bg-gray-600 text-white py-3 rounded-lg cursor-not-allowed"
                        >
                            Stok Habis
                        </button>

                    @endif

                @else

                    <div class="space-y-3">
                        <a 
                            href="{{ route('login') }}" 
                            class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg transition font-semibold text-lg"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login untuk Membeli
                        </a>
                    </div>

                @endauth
            </div>
        </div>
    </div>
    
    <!-- Promosi WhatsApp di Detail Produk -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
        <p class="text-gray-600 dark:text-gray-400">
            Butuh bantuan? 
            <a 
                href="https://wa.me/6287871797367" 
                target="_blank" 
                class="text-green-600 font-semibold"
            >
                Chat via WhatsApp
            </a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollKey = 'product_detail_scroll_position';
        const scrollPosition = sessionStorage.getItem(scrollKey);

        if (scrollPosition !== null) {
            window.scrollTo(0, parseInt(scrollPosition));
            sessionStorage.removeItem(scrollKey);
        }

        const addToCartForms = document.querySelectorAll('.add-to-cart-form');

        addToCartForms.forEach(function (form) {
            form.addEventListener('submit', function () {
                sessionStorage.setItem(scrollKey, window.scrollY);
            });
        });
    });
</script>
@endpush