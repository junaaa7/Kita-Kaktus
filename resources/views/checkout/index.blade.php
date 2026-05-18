@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Checkout</h1>
    
    @if($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 mb-4 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Informasi Pengiriman</h2>
                
                <form action="{{ isset($isSelectedCheckout) && $isSelectedCheckout ? route('checkout.selected.process') : route('checkout.process') }}" method="POST" id="checkoutForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat Lengkap</label>
                        <textarea name="shipping_address" id="shipping_address" required 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('shipping_address') border-red-500 @enderror" 
                               rows="3">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('phone') border-red-500 @enderror"
                               placeholder="Contoh: 081234567890"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">* Hanya boleh diisi dengan angka (10-15 digit)</p>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Metode Pembayaran</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method', 'bank_transfer') == 'bank_transfer' ? 'checked' : '' }} class="mr-3">
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-white">Transfer Bank</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">BCA, Mandiri, BNI, BRI</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="radio" name="payment_method" value="qris" {{ old('payment_method') == 'qris' ? 'checked' : '' }} class="mr-3">
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-white">QRIS</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Scan QR Code via GoPay, OVO, DANA, dll</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="radio" name="payment_method" value="cash" {{ old('payment_method') == 'cash' ? 'checked' : '' }} class="mr-3">
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-white">Bayar di Tempat</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Cash on Delivery</div>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg transition font-semibold">
                        Konfirmasi Pesanan
                    </button>
                </form>
            </div>
        </div>
        
        <div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Ringkasan Pesanan</h2>
                
                <div class="space-y-3 mb-4">
                    @foreach($cart as $item)
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                        <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span class="text-gray-800 dark:text-white">Total</span>
                        <span class="text-green-600 dark:text-green-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-4 rounded-lg">
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <i class="fas fa-info-circle"></i> 
                    <span id="paymentInfo">
                        @if(old('payment_method', 'bank_transfer') == 'bank_transfer')
                            Silahkan transfer ke rekening BCA 1234567890 a.n Kita Kaktus
                        @elseif(old('payment_method') == 'qris')
                            Scan QR Code yang akan ditampilkan setelah checkout
                        @else
                            Bayar langsung saat barang diterima
                        @endif
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Update payment info when payment method changes
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paymentInfo = document.getElementById('paymentInfo');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'bank_transfer') {
                paymentInfo.textContent = 'Silahkan transfer ke rekening BCA 1234567890 a.n Kita Kaktus';
            } else if (this.value === 'qris') {
                paymentInfo.textContent = 'Scan QR Code yang akan ditampilkan setelah checkout';
            } else {
                paymentInfo.textContent = 'Bayar langsung saat barang diterima';
            }
        });
    });
    
    // Phone number validation
    const phoneInput = document.getElementById('phone');
    const form = document.getElementById('checkoutForm');
    
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    form.addEventListener('submit', function(e) {
        const phone = phoneInput.value;
        if (phone.length > 0 && (phone.length < 10 || phone.length > 15)) {
            e.preventDefault();
            alert('Nomor telepon harus terdiri dari 10-15 digit angka!');
        }
    });
</script>
@endsection