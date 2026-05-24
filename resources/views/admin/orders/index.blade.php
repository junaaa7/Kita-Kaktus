@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Manajemen Pesanan</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">Kelola dan pantau status pesanan customer</p>
</div>

<!-- Statistik Cards - Responsive -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 sm:p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Total Pesanan</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">{{ $orders->total() }}</p>
            </div>
            <div class="bg-blue-100 dark:bg-blue-900/50 rounded-full p-2 sm:p-3">
                <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-sm sm:text-base"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 sm:p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Pending</p>
                <p class="text-xl sm:text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-yellow-100 dark:bg-yellow-900/50 rounded-full p-2 sm:p-3">
                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-sm sm:text-base"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 sm:p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Diproses & Dikirim</p>
                <p class="text-xl sm:text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $orders->whereIn('status', ['processed', 'shipped'])->count() }}</p>
            </div>
            <div class="bg-purple-100 dark:bg-purple-900/50 rounded-full p-2 sm:p-3">
                <i class="fas fa-truck text-purple-600 dark:text-purple-400 text-sm sm:text-base"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-3 sm:p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm">Selesai</p>
                <p class="text-xl sm:text-2xl font-bold text-green-600 dark:text-green-400">{{ $orders->where('status', 'delivered')->count() }}</p>
            </div>
            <div class="bg-green-100 dark:bg-green-900/50 rounded-full p-2 sm:p-3">
                <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-sm sm:text-base"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Pesanan -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <!-- Tampilan Desktop (Table) -->
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Pesanan</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <span class="text-xs sm:text-sm font-mono text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-7 w-7 sm:h-8 sm:w-8 bg-gradient-to-r from-green-400 to-green-600 dark:from-green-600 dark:to-green-800 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm">
                                {{ substr($order->user->name, 0, 1) }}
                            </div>
                            <div class="ml-2 sm:ml-3">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $order->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <span class="text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </td>
                    
                    <!-- STATUS -->
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        @if($order->status == 'pending')
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 dark:text-amber-400">
                                <i class="fas fa-clock text-[10px] sm:text-[11px]"></i>
                                Pending
                            </span>
                        @elseif($order->status == 'processed')
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-blue-700 dark:text-blue-400">
                                <i class="fas fa-spinner text-[10px] sm:text-[11px]"></i>
                                Diproses
                            </span>
                        @elseif($order->status == 'shipped')
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-purple-700 dark:text-purple-400">
                                <i class="fas fa-truck text-[10px] sm:text-[11px]"></i>
                                Dikirim
                            </span>
                        @elseif($order->status == 'delivered')
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 dark:text-green-400">
                                <i class="fas fa-check-circle text-[10px] sm:text-[11px]"></i>
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-red-700 dark:text-red-400">
                                <i class="fas fa-times-circle text-[10px] sm:text-[11px]"></i>
                                Dibatalkan
                            </span>
                        @endif
                    </td>
                    
                    <!-- AKSI -->
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400 transition text-xs sm:text-sm">
                            <i class="fas fa-eye mr-1"></i> 
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 md:px-6 py-8 text-center">
                        <i class="fas fa-inbox text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400">Belum ada pesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Tampilan Mobile (Card) -->
    <div class="block sm:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($orders as $order)
        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <div class="flex justify-between items-start mb-2">
                <span class="font-mono text-xs text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                @if($order->status == 'pending')
                    <span class="text-amber-600 dark:text-amber-400 text-xs">Pending</span>
                @elseif($order->status == 'processed')
                    <span class="text-blue-600 dark:text-blue-400 text-xs">Diproses</span>
                @elseif($order->status == 'shipped')
                    <span class="text-purple-600 dark:text-purple-400 text-xs">Dikirim</span>
                @elseif($order->status == 'delivered')
                    <span class="text-green-600 dark:text-green-400 text-xs">Selesai</span>
                @else
                    <span class="text-red-600 dark:text-red-400 text-xs">Dibatalkan</span>
                @endif
            </div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                <strong>Customer:</strong> {{ $order->user->name }}
            </div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                <strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </div>
            <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                <a href="{{ route('admin.orders.show', $order) }}" class="text-green-600 dark:text-green-400 text-xs">Detail →</a>
            </div>
        </div>
        @empty
        <div class="p-8 text-center">
            <i class="fas fa-inbox text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pesanan</p>
        </div>
        @endforelse
    </div>
    
    <!-- Footer Tabel dengan Info Pagination -->
    <div class="bg-gray-50 dark:bg-gray-700/50 px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 sm:gap-4">
                <div class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-chart-line text-green-600 dark:text-green-400"></i>
                    <span>Total: <span class="font-semibold text-gray-900 dark:text-white">{{ $orders->total() }}</span> pesanan</span>
                </div>
                <div class="h-3 w-px bg-gray-300 dark:bg-gray-600 hidden sm:block"></div>
                <div class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-hourglass-half text-yellow-600 dark:text-yellow-400"></i>
                    <span>Pending: <span class="font-semibold text-yellow-600 dark:text-yellow-400">{{ $orders->where('status', 'pending')->count() }}</span></span>
                </div>
                <div class="h-3 w-px bg-gray-300 dark:bg-gray-600 hidden sm:block"></div>
                <div class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                    <span>Selesai: <span class="font-semibold text-green-600 dark:text-green-400">{{ $orders->where('status', 'delivered')->count() }}</span></span>
                </div>
            </div>
            
            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                Menampilkan {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $orders->links('pagination::tailwind') }}
</div>
@endsection