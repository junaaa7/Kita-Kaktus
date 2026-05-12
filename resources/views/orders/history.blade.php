@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-4xl mx-auto" style="margin-bottom: 100px;">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Riwayat Pesanan</h1>
    
    @forelse($orders as $order)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-4 p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400"><strong class="text-gray-700 dark:text-gray-300">No. Pesanan:</strong> {{ $order->order_number }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong class="text-gray-700 dark:text-gray-300">Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong class="text-gray-700 dark:text-gray-300">Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 text-sm rounded-full 
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($order->status == 'processed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                    @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @endif">
                    @if($order->status == 'pending') Menunggu Pembayaran
                    @elseif($order->status == 'processed') Diproses
                    @elseif($order->status == 'shipped') Dikirim
                    @elseif($order->status == 'delivered') Selesai
                    @else Dibatalkan
                    @endif
                </span>
            </div>
        </div>
        
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <a href="{{ route('orders.detail', $order) }}" class="text-green-600 dark:text-green-400 hover:text-green-700">
                Lihat Detail →
            </a>
        </div>
    </div>
    @empty
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-shopping-bag text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
        <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada pesanan</p>
        <a href="{{ route('home') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
            Mulai Belanja
        </a>
    </div>
    @endforelse
    
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection