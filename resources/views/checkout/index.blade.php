@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Informasi Pengiriman</h2>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap</label>
                        <textarea name="shipping_address" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" rows="3">{{ old('shipping_address') }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Metode Pembayaran</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="bank_transfer" checked class="mr-3">
                                <div>
                                    <div class="font-semibold">Transfer Bank</div>
                                    <div class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="qris" class="mr-3">
                                <div>
                                    <div class="font-semibold">QRIS</div>
                                    <div class="text-sm text-gray-500">Scan QR Code via GoPay, OVO, DANA, dll</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cash" class="mr-3">
                                <div>
                                    <div class="font-semibold">Bayar di Tempat</div>
                                    <div class="text-sm text-gray-500">Cash on Delivery</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                        Konfirmasi Pesanan
                    </button>
                </form>
            </div>
        </div>
        
        <div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>
                
                <div class="space-y-3 mb-4">
                    @foreach($cart as $item)
                    <div class="flex justify-between text-gray-600">
                        <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                        <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-info-circle"></i> 
                    @if(old('payment_method', 'bank_transfer') == 'bank_transfer')
                        Silahkan transfer ke rekening BCA 1234567890 a.n Kita Kaktus
                    @elseif(old('payment_method') == 'qris')
                        Scan QR Code yang akan ditampilkan setelah checkout
                    @else
                        Bayar langsung saat barang diterima
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection