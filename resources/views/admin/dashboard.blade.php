@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">Dashboard Admin</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 sm:mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
</div>

<!-- Statistik Cards - Responsive Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <a href="{{ route('admin.products.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 hover:shadow-xl transition cursor-pointer block">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Total Produk</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">{{ $totalProducts }}</p>
            </div>
            <i class="fas fa-box text-2xl sm:text-3xl text-green-600"></i>
        </div>
        <div class="mt-3 sm:mt-4 text-green-600 text-xs sm:text-sm">Kelola Produk →</div>
    </a>
    
    <a href="{{ route('admin.orders.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 hover:shadow-xl transition cursor-pointer block">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Total Pesanan</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">{{ $totalOrders }}</p>
            </div>
            <i class="fas fa-shopping-cart text-2xl sm:text-3xl text-blue-600"></i>
        </div>
        <div class="mt-3 sm:mt-4 text-blue-600 text-xs sm:text-sm">Kelola Pesanan →</div>
    </a>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Total User</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">{{ $totalUsers }}</p>
            </div>
            <i class="fas fa-users text-2xl sm:text-3xl text-purple-600"></i>
        </div>
    </div>
    
    <a href="{{ route('admin.orders.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 hover:shadow-xl transition cursor-pointer block">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Pesanan Pending</p>
                <p class="text-xl sm:text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>
            <i class="fas fa-clock text-2xl sm:text-3xl text-yellow-600"></i>
        </div>
        <div class="mt-3 sm:mt-4 text-yellow-600 text-xs sm:text-sm">Proses Sekarang →</div>
    </a>
</div>

<!-- Tabel Pesanan Terbaru - Responsive -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6">
    <h2 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-white mb-3 sm:mb-4">Pesanan Terbaru</h2>
    
    <!-- Tampilan Desktop (Table) -->
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">No. Pesanan</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Customer</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-4 md:px-6 py-3 md:py-4 text-sm text-gray-900 dark:text-white">{{ $order->order_number }}</td>
                    <td class="px-4 md:px-6 py-3 md:py-4 text-sm text-gray-600 dark:text-gray-300">{{ $order->user->name }}</td>
                    <td class="px-4 md:px-6 py-3 md:py-4 text-sm text-gray-600 dark:text-gray-300">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-4 md:px-6 py-3 md:py-4">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300
                            @elseif($order->status == 'processed') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300
                            @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300
                            @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 text-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 md:px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada pesanan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Tampilan Mobile (Card) -->
    <div class="block sm:hidden space-y-3">
        @forelse($recentOrders as $order)
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
            <div class="flex justify-between items-start mb-2">
                <span class="font-mono text-xs text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                <span class="px-2 py-0.5 text-xs rounded-full 
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300
                    @elseif($order->status == 'processed') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300
                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300
                    @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300
                    @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                <strong>Customer:</strong> {{ $order->user->name }}
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                <strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </div>
            <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('admin.orders.show', $order) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 text-sm inline-flex items-center">
                    Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
            Belum ada pesanan
        </div>
        @endforelse
    </div>
</div>
@endsection