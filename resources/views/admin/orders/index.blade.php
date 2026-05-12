@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Pesanan</h1>
    <p class="text-gray-600 mt-1">Kelola dan pantau status pesanan customer</p>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $orders->total() }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-shopping-cart text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-3">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Diproses & Dikirim</p>
                <p class="text-2xl font-bold text-purple-600">{{ $orders->whereIn('status', ['processed', 'shipped'])->count() }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-truck text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $orders->where('status', 'delivered')->count() }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-check-circle text-green-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Pesanan -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-mono text-gray-900">{{ $order->order_number }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ substr($order->user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processed') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @if($order->status == 'pending') 
                                <i class="fas fa-hourglass-half mr-1"></i> Menunggu
                            @elseif($order->status == 'processed') 
                                <i class="fas fa-spinner mr-1"></i> Diproses
                            @elseif($order->status == 'shipped') 
                                <i class="fas fa-truck mr-1"></i> Dikirim
                            @elseif($order->status == 'delivered') 
                                <i class="fas fa-check-circle mr-1"></i> Selesai
                            @else 
                                <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada pesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Footer Tabel dengan Info Pagination -->
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <i class="fas fa-chart-line text-green-600"></i>
                    <span>Total: <span class="font-semibold text-gray-900">{{ $orders->total() }}</span> pesanan</span>
                </div>
                <div class="h-4 w-px bg-gray-300 hidden sm:block"></div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <i class="fas fa-hourglass-half text-yellow-600"></i>
                    <span>Pending: <span class="font-semibold text-yellow-600">{{ $orders->where('status', 'pending')->count() }}</span></span>
                </div>
                <div class="h-4 w-px bg-gray-300 hidden sm:block"></div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span>Selesai: <span class="font-semibold text-green-600">{{ $orders->where('status', 'delivered')->count() }}</span></span>
                </div>
            </div>
            
            <div class="text-sm text-gray-500">
                Menampilkan {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection