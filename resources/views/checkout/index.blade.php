@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-6">
        Checkout
    </h1>

    @if($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-3 sm:p-4 mb-4 rounded-lg">
            <ul class="list-disc list-inside text-sm sm:text-base">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Mobile: Ringkasan di atas, Form di bawah -->
    <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 gap-6">
        
        <!-- FORM CHECKOUT (DITARUH BAWAH DI MOBILE) -->
        <div class="lg:order-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6">

                <h2 class="text-base sm:text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-truck text-green-500 mr-2 text-sm"></i>
                    Informasi Pengiriman
                </h2>

                <form 
                    action="{{ isset($isSelectedCheckout) && $isSelectedCheckout ? route('checkout.selected.process') : route('checkout.process') }}"
                    method="POST"
                    id="checkoutForm"
                >
                    @csrf

                    <input type="hidden" name="customer_timezone" id="customer_timezone" value="{{ old('customer_timezone', 'Asia/Jakarta') }}">

                    <!-- ========== PILIH ALAMAT TERSIMPAN ========== -->
                    @if(isset($addresses) && $addresses->count() > 0)
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-bold mb-1">
                            Pilih Alamat Tersimpan
                        </label>
                        <select id="selectAddress" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">-- Pilih Alamat --</option>
                            @foreach($addresses as $addr)
                                <option value="{{ $addr->id }}" 
                                        data-name="{{ $addr->recipient_name }}"
                                        data-phone="{{ $addr->phone }}"
                                        data-address="{{ $addr->address }}"
                                        {{ $addr->is_default ? 'selected' : '' }}>
                                    {{ $addr->label }} - {{ $addr->recipient_name }}
                                    @if($addr->is_default) [Utama] @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <i class="fas fa-info-circle mr-1"></i> Pilih alamat yang sudah tersimpan
                        </p>
                    </div>
                    @endif

                    <!-- ========== NAMA PENERIMA ========== -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-bold mb-1">
                            Nama Penerima
                        </label>
                        <input type="text" name="recipient_name" id="recipient_name" 
                               value="{{ old('recipient_name', isset($defaultAddress) ? $defaultAddress->recipient_name : '') }}"
                               placeholder="Masukkan nama lengkap penerima"
                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            * Nama lengkap penerima paket
                        </p>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-bold mb-1">
                            Alamat Lengkap
                        </label>

                        <textarea
                            name="shipping_address"
                            id="shipping_address"
                            required
                            rows="3"
                            placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('shipping_address') border-red-500 @enderror"
                        >{{ old('shipping_address', isset($defaultAddress) ? $defaultAddress->address : '') }}</textarea>

                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-bold mb-1">
                            Nomor Telepon
                        </label>

                        <input
                            type="tel"
                            name="phone"
                            id="phone"
                            value="{{ old('phone', isset($defaultAddress) ? $defaultAddress->phone : '') }}"
                            required
                            placeholder="Contoh: 081234567890"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('phone') border-red-500 @enderror"
                        >

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            * 10-15 digit angka
                        </p>

                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Metode Pembayaran - GRID 2 KOLOM UNTUK MOBILE -->
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-bold mb-2">
                            Metode Pembayaran
                        </label>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Transfer Bank -->
                            <label class="flex flex-col items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition text-center">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="bank_transfer"
                                    {{ old('payment_method', 'bank_transfer') == 'bank_transfer' ? 'checked' : '' }}
                                    class="mb-2"
                                >
                                <i class="fas fa-university text-xl text-green-500 mb-1"></i>
                                <div class="font-semibold text-gray-800 dark:text-white text-xs sm:text-sm">
                                    Transfer Bank
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    BCA
                                </div>
                            </label>
                            
                            <!-- QRIS -->
                            <label class="flex flex-col items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition text-center">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="qris"
                                    {{ old('payment_method') == 'qris' ? 'checked' : '' }}
                                    class="mb-2"
                                >
                                <i class="fas fa-qrcode text-xl text-green-500 mb-1"></i>
                                <div class="font-semibold text-gray-800 dark:text-white text-xs sm:text-sm">
                                    QRIS
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Scan QRIS
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button -->
                    <button
                        type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg transition font-semibold text-sm flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-check-circle"></i>
                        Konfirmasi Pesanan
                    </button>

                </form>
            </div>
        </div>

        <!-- RINGKASAN (DITARUH ATAS DI MOBILE) -->
        <div class="lg:order-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 sticky lg:top-20">

                <h2 class="text-base sm:text-lg font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                    <i class="fas fa-shopping-bag text-green-500 mr-2 text-sm"></i>
                    Ringkasan Pesanan
                </h2>

                <div class="space-y-2 mb-3 max-h-60 overflow-y-auto">
                    @foreach($cart as $item)
                        <div class="flex justify-between text-gray-600 dark:text-gray-400 text-xs sm:text-sm py-1">
                            <span class="flex-1 pr-2">
                                {{ Str::limit($item['name'], 30) }} x {{ $item['quantity'] }}
                            </span>
                            <span class="font-semibold whitespace-nowrap">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-1">
                    <div class="flex justify-between font-bold text-sm sm:text-base">
                        <span class="text-gray-800 dark:text-white">Total</span>
                        <span class="text-green-600 dark:text-green-400 text-base sm:text-lg">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- INFO PEMBAYARAN -->
            <div class="mt-4 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-3 rounded-lg">

                <p class="text-xs text-blue-700 dark:text-blue-300">

                    <i class="fas fa-info-circle mr-1"></i>

                    <span id="paymentInfo">

                        @if(old('payment_method', 'bank_transfer') == 'bank_transfer')

                            Transfer ke Rekening BCA 6035057815 a.n EVI LUTFIANI DEWI

                        @else

                            Scan QRIS pada halaman detail pesanan setelah checkout

                        @endif

                    </span>

                </p>

            </div>

        </div>

    </div>

</div>

<script>
    // ========== AUTO DETECT ZONA WAKTU CUSTOMER ==========
    const timezoneInput = document.getElementById('customer_timezone');

    if (timezoneInput) {
        timezoneInput.value = Intl.DateTimeFormat().resolvedOptions().timeZone || 'Asia/Jakarta';
    }

    // ========== AUTO FILL DARI ALAMAT TERSIMPAN ==========
    const addressSelect = document.getElementById('selectAddress');
    const recipientNameInput = document.getElementById('recipient_name');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('shipping_address');

    if (addressSelect) {
        addressSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                recipientNameInput.value = selectedOption.dataset.name || '';
                phoneInput.value = selectedOption.dataset.phone || '';
                addressInput.value = selectedOption.dataset.address || '';
            }
        });
    }

    // PAYMENT INFO - TANPA COD
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paymentInfo = document.getElementById('paymentInfo');

    paymentMethods.forEach(method => {

        method.addEventListener('change', function() {

            if (this.value === 'bank_transfer') {

                paymentInfo.innerHTML = 'Transfer ke Rekening BCA 6035057815 a.n EVI LUTFIANI DEWI';

            } else if (this.value === 'qris') {

                paymentInfo.innerHTML = 'Scan QRIS pada halaman detail pesanan setelah checkout';
            }

        });

    });

    // VALIDASI NOMOR TELEPON
    const phoneInputField = document.getElementById('phone');
    const form = document.getElementById('checkoutForm');

    if (phoneInputField) {
        phoneInputField.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            const phone = phoneInputField ? phoneInputField.value : '';
            if (phone.length > 0 && (phone.length < 10 || phone.length > 15)) {
                e.preventDefault();
                alert('Nomor telepon harus terdiri dari 10-15 digit angka!');
            }

            if (timezoneInput) {
                timezoneInput.value = Intl.DateTimeFormat().resolvedOptions().timeZone || 'Asia/Jakarta';
            }
        });
    }

</script>
@endsection