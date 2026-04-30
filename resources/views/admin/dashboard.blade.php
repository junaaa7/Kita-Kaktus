@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.products.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition cursor-pointer block">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>
            <i class="fas fa-box text-3xl text-green-600"></i>
        </div>
        <div class="mt-4 text-green-600 text-sm">Kelola Produk →</div>
    </a>
    
    <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition cursor-pointer block">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
            <i class="fas fa-shopping-cart text-3xl text-blue-600"></i>
        </div>
        <div class="mt-4 text-blue-600 text-sm">Kelola Pesanan →</div>
    </a>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total User</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
            <i class="fas fa-users text-3xl text-purple-600"></i>
        </div>
    </div>
    
    <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition cursor-pointer block">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pesanan Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>
            <i class="fas fa-clock text-3xl text-yellow-600"></i>
        </div>
        <div class="mt-4 text-yellow-600 text-sm">Proses Sekarang →</div>
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Pesanan Terbaru</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                <tr>
                    <td class="px-6 py-4">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">{{ $order->user->name }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processed') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-green-600 hover:text-green-900">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada pesanan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection