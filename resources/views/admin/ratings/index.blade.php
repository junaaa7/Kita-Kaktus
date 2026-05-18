@extends('layouts.app')

@section('title', 'Manajemen Rating')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Rating & Review</h1>
    <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola rating dan review dari customer</p>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Review</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($ratings as $rating)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $rating->user->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $rating->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">{{ $rating->product->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $rating->rating)
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @else
                                    <i class="fas fa-star text-gray-300 dark:text-gray-600 text-sm"></i>
                                @endif
                            @endfor
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $rating->rating }})</span>
                        </div>
                     </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300 max-w-md">{{ $rating->review ?? '-' }}</p>
                     </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">{{ $rating->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $rating->created_at->format('H:i') }}</div>
                     </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.orders.show', $rating->order) }}" class="text-green-600 hover:text-green-900 text-sm">
                            {{ $rating->order->order_number }}
                        </a>
                     </td>
                 </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <i class="fas fa-star text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">Belum ada rating dari customer</p>
                     </td>
                 </tr>
                @endforelse
            </tbody>
         </table>
    </div>
</div>

<div class="mt-4">
    {{ $ratings->links() }}
</div>
@endsection