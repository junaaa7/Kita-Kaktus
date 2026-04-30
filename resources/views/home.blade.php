@extends('layouts.app')

@section('title', 'Home - Kita Kaktus')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-500 to-green-700 rounded-xl text-white p-12 mb-12 text-center">
    <h1 class="text-4xl font-bold mb-4">🌵 Selamat Datang di Kita Kaktus</h1>
    <p class="text-xl mb-6">Temukan berbagai koleksi kaktus terbaik untuk menghiasi rumah Anda</p>
    @guest
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="inline-block bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition">
                <i class="fas fa-sign-in-alt"></i> Login untuk Belanja
            </a>
            <a href="{{ route('register') }}" class="inline-block bg-white text-green-600 px-6 py-3 rounded-lg hover:bg-gray-100 transition">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        </div>
    @else
        <p class="text-lg">Selamat berbelanja, {{ auth()->user()->name }}! 🎉</p>
    @endguest
</div>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">🌵 Koleksi Kaktus Kami</h2>
    <p class="text-gray-600">Pilih kaktus favorit Anda dan tambahkan ke keranjang!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($products as $product)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
        <div class="h-48 overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-image text-4xl text-gray-500"></i>
                </div>
            @endif
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 100) }}</p>
            <div class="flex justify-between items-center mb-3">
                <span class="text-green-600 font-bold text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500">Stok: {{ $product->stock }}</span>
            </div>
            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <button disabled class="w-full bg-gray-400 text-white py-2 rounded-lg cursor-not-allowed">
                        Stok Habis
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-sign-in-alt"></i> Login untuk Beli
                </a>
            @endauth
            <a href="{{ route('product.detail', $product) }}" class="block text-center mt-2 text-green-600 hover:text-green-700 text-sm">
                Lihat Detail →
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <p class="text-gray-500">Belum ada produk tersedia</p>
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $products->links() }}
</div>

<!-- Info Section untuk Guest -->
@guest
<div class="mt-12 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-2xl text-blue-500"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-lg font-semibold text-blue-800">Ingin berbelanja?</h3>
            <p class="text-blue-700 mt-1">
                Silahkan <a href="{{ route('login') }}" class="font-bold underline">Login</a> jika sudah punya akun, 
                atau <a href="{{ route('register') }}" class="font-bold underline">Register</a> untuk membuat akun baru.
            </p>
        </div>
    </div>
</div>
@endguest
@endsection