@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-0">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Detail Pesanan</h1>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 text-sm sm:text-base inline-flex items-center">
            <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base"><strong>No. Pesanan:</strong> <span class="font-mono text-xs sm:text-sm">{{ $order->order_number }}</span></p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1">
                    <strong>Tanggal:</strong> {{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
                </p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong>Customer:</strong> {{ $order->user->name }}</p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong>Metode Pembayaran:</strong> 
                    @if($order->payment_method == 'bank_transfer') Transfer Bank
                    @elseif($order->payment_method == 'qris') QRIS
                    @endif
                </p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong>Status Pembayaran:</strong>
                    @if($order->payment_status == 'pending')
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Menunggu Pembayaran</span>
                    @elseif($order->payment_status == 'paid')
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Sudah Dibayar</span>
                    @else
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Pembayaran Gagal</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base"><strong>Telepon:</strong> {{ $order->phone }}</p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong>Total:</strong> <span class="text-green-600 dark:text-green-400 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
            </div>
        </div>

        <!-- Bukti Pembayaran -->
        @if($order->payment_proof)
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
            <h3 class="font-bold text-gray-800 dark:text-white mb-3 text-base sm:text-lg">Bukti Pembayaran</h3>
            <div class="bg-gray-50 dark:bg-gray-700 p-3 sm:p-4 rounded-lg">
                <img src="{{ asset($order->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-full sm:max-w-xs rounded-lg">
                
                @if($order->payment_status == 'pending')
                <div class="mt-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full sm:w-auto text-sm">
                            <i class="fas fa-check"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.reject-payment', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 w-full sm:w-auto text-sm">
                            <i class="fas fa-times"></i> Tolak Pembayaran
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endif
        
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Update Status Pesanan</label>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                @csrf
                @method('PUT')
                <select name="status" class="px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg flex-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm sm:text-base">Update</button>
            </form>
        </div>
    </div>
    
    <!-- TABEL PRODUK - DIPERBAIKI agar rapi -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3 text-gray-800 dark:text-white text-sm">
                            {{ $item->product->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-4 py-3 text-green-600 dark:text-green-400 font-semibold text-sm whitespace-nowrap">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700">
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-700 dark:text-gray-300 text-sm">
                            Total:
                        </td>
                        <td class="px-4 py-3 font-bold text-green-600 dark:text-green-400 text-sm whitespace-nowrap">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection