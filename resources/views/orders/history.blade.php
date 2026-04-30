@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pesanan</h1>
    
    @forelse($orders as $order)
    <div class="bg-white rounded-lg shadow-md mb-4 p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-gray-600"><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
                <p class="text-gray-600"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="text-gray-600"><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 text-sm rounded-full 
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'processed') bg-blue-100 text-blue-800
                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        
        <div class="border-t pt-4">
            <a href="{{ route('orders.detail', $order) }}" class="text-green-600 hover:text-green-900">
                Lihat Detail →
            </a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-shopping-bag text-6xl text-gray-400 mb-4"></i>
        <p class="text-gray-500 text-lg">Belum ada pesanan</p>
        <a href="{{ route('home') }}" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Mulai Belanja
        </a>
    </div>
    @endforelse
    
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection