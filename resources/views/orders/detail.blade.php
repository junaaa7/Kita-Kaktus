@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan</h1>
        <a href="{{ route('orders.history') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            Kembali
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <p class="text-gray-600"><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
                <p class="text-gray-600"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="text-gray-600"><strong>Metode Pembayaran:</strong> 
                    @if($order->payment_method == 'bank_transfer') Transfer Bank
                    @elseif($order->payment_method == 'qris') QRIS
                    @else Bayar di Tempat
                    @endif
                </p>
                <p class="text-gray-600"><strong>Status Pembayaran:</strong>
                    @if($order->payment_status == 'pending')
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
                    @elseif($order->payment_status == 'paid')
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Sudah Dibayar</span>
                    @else
                        <span class="inline-block px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Pembayaran Gagal</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-600"><strong>Telepon:</strong> {{ $order->phone }}</p>
                <p class="text-gray-600"><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                <p class="text-gray-600"><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                <p class="text-gray-600"><strong>Status Pesanan:</strong>
                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'processed') bg-blue-100 text-blue-800
                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status == 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        @if($order->status == 'pending') Menunggu Konfirmasi
                        @elseif($order->status == 'processed') Diproses
                        @elseif($order->status == 'shipped') Dikirim
                        @elseif($order->status == 'delivered') Selesai
                        @else Dibatalkan
                        @endif
                    </span>
                </p>
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        @if($order->payment_status == 'pending' && $order->payment_method != 'cash')
        <div class="border-t pt-4 mb-4">
            <h3 class="font-bold text-gray-800 mb-3">Informasi Pembayaran</h3>
            <div class="bg-yellow-50 p-4 rounded-lg">
                @if($order->payment_method == 'bank_transfer')
                    <p class="text-sm mb-2"><strong>Transfer ke rekening:</strong></p>
                    <p class="text-sm">Bank BCA: 1234567890</p>
                    <p class="text-sm">Bank Mandiri: 9876543210</p>
                    <p class="text-sm">a.n Kita Kaktus</p>
                    <p class="text-sm mt-2 text-red-600"><strong>Total yang harus ditransfer: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                @elseif($order->payment_method == 'qris')
                    <div class="text-center">
                        <p class="text-sm mb-2">Scan QR Code berikut untuk melakukan pembayaran:</p>
                        <div class="bg-white p-4 inline-block rounded-lg">
                            <i class="fas fa-qrcode text-8xl text-gray-800"></i>
                            <p class="text-xs mt-2">QRIS Code</p>
                        </div>
                        <p class="text-sm mt-2 text-red-600"><strong>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                    </div>
                @endif
                
                <form action="{{ route('upload.payment', $order) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Upload Bukti Pembayaran</label>
                        <input type="file" name="payment_proof" accept="image/*" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($order->payment_proof)
        <div class="border-t pt-4 mb-4">
            <h3 class="font-bold text-gray-800 mb-3">Bukti Pembayaran</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-xs rounded-lg">
            </div>
        </div>
        @endif
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4">{{ $item->product->name }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                    <td class="px-6 py-4 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    @if($order->status == 'delivered')
    <div class="mt-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
        <i class="fas fa-check-circle"></i> Pesanan telah selesai. Terima kasih telah berbelanja di Kita Kaktus!
    </div>
    @endif
</div>
@endsection