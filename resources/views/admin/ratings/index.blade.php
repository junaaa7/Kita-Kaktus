@extends('layouts.app')

@section('title', 'Manajemen Rating')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Manajemen Rating & Review</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">Kelola rating dan review dari customer</p>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <!-- Tampilan Desktop (Table) -->
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Customer</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Rating</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Review</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($ratings as $rating)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $rating->user->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $rating->user->email }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">{{ $rating->product->name }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $rating->rating)
                                    <i class="fas fa-star text-yellow-400 text-xs sm:text-sm"></i>
                                @else
                                    <i class="fas fa-star text-gray-300 dark:text-gray-600 text-xs sm:text-sm"></i>
                                @endif
                            @endfor
                            <span class="ml-1 sm:ml-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">({{ $rating->rating }})</span>
                        </div>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4">
                        <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 max-w-md line-clamp-2">{{ $rating->review ?? '-' }}</p>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <div class="text-xs sm:text-sm text-gray-900 dark:text-white">{{ $rating->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $rating->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                        <a href="{{ route('admin.orders.show', $rating->order) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 text-xs sm:text-sm">
                            {{ $rating->order->order_number }}
                        </a>
                    </td>
                 </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 md:px-6 py-12 text-center">
                        <i class="fas fa-star text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400">Belum ada rating dari customer</p>
                    </td>
                 </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Tampilan Mobile (Card) -->
    <div class="block sm:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($ratings as $rating)
        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $rating->user->name }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $rating->user->email }}</p>
                </div>
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $rating->rating)
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                        @else
                            <i class="fas fa-star text-gray-300 dark:text-gray-600 text-xs"></i>
                        @endif
                    @endfor
                    <span class="ml-1 text-xs text-gray-600 dark:text-gray-400">({{ $rating->rating }})</span>
                </div>
            </div>
            <div class="mb-2">
                <p class="text-xs text-gray-600 dark:text-gray-400"><strong>Produk:</strong> {{ $rating->product->name }}</p>
            </div>
            @if($rating->review)
            <div class="mb-2">
                <p class="text-xs text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-2 rounded-lg italic">
                    "{{ $rating->review }}"
                </p>
            </div>
            @endif
            <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $rating->created_at->format('d/m/Y H:i') }}</span>
                <a href="{{ route('admin.orders.show', $rating->order) }}" class="text-green-600 dark:text-green-400 text-xs">
                    Lihat Order →
                </a>
            </div>
        </div>
        @empty
        <div class="p-8 text-center">
            <i class="fas fa-star text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada rating dari customer</p>
        </div>
        @endforelse
    </div>
</div>

<div class="mt-4">
    {{ $ratings->links() }}
</div>
@endsection