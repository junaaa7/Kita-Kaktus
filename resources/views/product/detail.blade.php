@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-300 flex items-center justify-center rounded-lg">
                        <i class="fas fa-image text-6xl text-gray-500"></i>
                    </div>
                @endif
            </div>
            
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">Kategori: {{ $product->category->name }}</p>
                <div class="text-3xl text-green-600 font-bold mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="mb-4">
                    <span class="text-gray-600">Stok: </span>
                    @if($product->stock > 0)
                        <span class="text-green-600 font-semibold">{{ $product->stock }} tersedia</span>
                    @else
                        <span class="text-red-600 font-semibold">Stok Habis</span>
                    @endif
                </div>
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 mb-2">Deskripsi:</h3>
                    <p class="text-gray-600">{{ $product->description }}</p>
                </div>
                
                @auth
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block w-full bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 transition">
                        Login untuk Membeli
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection