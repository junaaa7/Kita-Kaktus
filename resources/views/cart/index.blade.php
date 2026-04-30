@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>
    
    @if(count($cart) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cart as $id => $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded mr-3">
                                @endif
                                <span>{{ $item['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-20 px-2 py-1 border border-gray-300 rounded text-center">
                                <button type="submit" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-bold text-lg">Total:</td>
                        <td class="px-6 py-4 font-bold text-lg">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <tr>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('home') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                Lanjut Belanja
            </a>
            <a href="{{ route('checkout.index') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Checkout
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-shopping-cart text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg">Keranjang belanja kosong</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection