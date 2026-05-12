@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-4xl mx-auto" style="margin-bottom: 100px;">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Keranjang Belanja</h1>
    
    @if(count($cart) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cart as $id => $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if(isset($item['image']) && $item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded mr-3">
                                    @endif
                                    <span class="text-gray-800 dark:text-white">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <button type="submit" class="text-blue-600 dark:text-blue-400 hover:text-blue-900">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-lg text-gray-700 dark:text-gray-300">Total:</td>
                            <td class="px-6 py-4 font-bold text-lg text-green-600 dark:text-green-400">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            <tr>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3" style="margin-bottom: 50px;">
            <a href="{{ route('home') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                Lanjut Belanja
            </a>
            <a href="{{ route('checkout.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                Checkout
            </a>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center" style="margin-bottom: 100px;">
            <i class="fas fa-shopping-cart text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-lg">Keranjang belanja kosong</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection