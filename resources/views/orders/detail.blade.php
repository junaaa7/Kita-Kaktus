@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Detail Pesanan</h1>
        <a href="{{ route('orders.history') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition text-sm sm:text-base inline-flex items-center">
            <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base"><strong class="text-gray-700 dark:text-gray-300">No. Pesanan:</strong> <span class="text-gray-800 dark:text-gray-200 font-mono text-xs sm:text-sm">{{ $order->order_number }}</span></p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong class="text-gray-700 dark:text-gray-300">Tanggal:</strong> <span class="text-gray-800 dark:text-gray-200">{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong class="text-gray-700 dark:text-gray-300">Metode Pembayaran:</strong> 
                    <span class="text-gray-800 dark:text-gray-200">
                    @if($order->payment_method == 'bank_transfer') Transfer Bank
                    @elseif($order->payment_method == 'qris') QRIS
                    @else Bayar di Tempat
                    @endif
                    </span>
                </p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong class="text-gray-700 dark:text-gray-300">Status Pembayaran:</strong>
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
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base"><strong class="text-gray-700 dark:text-gray-300">Telepon:</strong> <span class="text-gray-800 dark:text-gray-200">{{ $order->phone }}</span></p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong class="text-gray-700 dark:text-gray-300">Alamat:</strong> <span class="text-gray-800 dark:text-gray-200">{{ $order->shipping_address }}</span></p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong class="text-gray-700 dark:text-gray-300">Total:</strong> <span class="text-green-600 dark:text-green-400 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base mt-1"><strong class="text-gray-700 dark:text-gray-300">Status Pesanan:</strong>
                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @elseif($order->status == 'processed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                        @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
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
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
            <h3 class="font-bold text-gray-800 dark:text-white mb-3 text-base sm:text-lg">Informasi Pembayaran</h3>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-3 sm:p-4 shadow-sm">
                @if($order->payment_method == 'bank_transfer')
                    <div class="space-y-2">
                        <p class="text-sm text-gray-700 dark:text-gray-300 font-semibold mb-2">Transfer ke rekening:</p>
                        <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Bank BCA: <span class="font-mono font-semibold text-gray-800 dark:text-gray-200"> 6035057815</span></p>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">a.n <span class="font-semibold text-gray-800 dark:text-gray-200">EVI LUTFIANI DEWI</span></p>
                        </div>
                        <div class="mt-3 p-2 sm:p-3 bg-red-50 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-800">
                            <p class="text-xs sm:text-sm text-red-600 dark:text-red-400 font-semibold">
                                <i class="fas fa-info-circle mr-1"></i> 
                                Total yang harus ditransfer: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @elseif($order->payment_method == 'qris')
                    <div class="text-center">
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                            Scan QRIS / Screenshot berikut untuk melakukan pembayaran:
                        </p>

                        <div class="bg-white dark:bg-gray-800 p-4 inline-block rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                            <img 
                                src="{{ asset('images/payment/qris kaktus.webp') }}" 
                                alt="QRIS Kita Kaktus" 
                                class="w-40 sm:w-56 h-40 sm:h-56 object-contain mx-auto rounded-lg"
                            >
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                QRIS Kita Kaktus
                            </p>
                        </div>

                        <p class="text-sm mt-2 text-red-600 dark:text-red-400">
                            <strong>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                        </p>
                    </div>
                @endif
                
                <form action="{{ secure_url('/upload-payment/' . $order->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Upload Bukti Pembayaran</label>
                        <input type="file" name="payment_proof" accept="image/jpeg,image/png,image/jpg,image/webp" required class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Format: JPG, PNG. Max: 2MB</p>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-2 rounded-lg transition duration-200 shadow-sm text-sm sm:text-base">
                        <i class="fas fa-upload mr-2"></i> Upload Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($order->payment_proof)
            <div class="mt-3">
                <img src="{{ asset($order->payment_proof) }}" 
                alt="Bukti Pembayaran" 
                class="max-w-full sm:max-w-xs rounded-lg shadow-sm">
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada bukti pembayaran.</p>
        @endif
    </div>
    
    <!-- TABEL PRODUK - DIPERBAIKI RESPONSIVE -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <!-- Tampilan Desktop (Table) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 md:px-6 py-3 md:py-4 text-gray-800 dark:text-gray-200 text-sm">{{ $item->product->name }}</td>
                        <td class="px-4 md:px-6 py-3 md:py-4 text-gray-600 dark:text-gray-300 text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 md:px-6 py-3 md:py-4 text-gray-600 dark:text-gray-300 text-sm">{{ $item->quantity }}</td>
                        <td class="px-4 md:px-6 py-3 md:py-4 text-gray-800 dark:text-gray-200 text-sm">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700">
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td colspan="3" class="px-4 md:px-6 py-3 md:py-4 text-right font-bold text-gray-700 dark:text-gray-300 text-sm">Total:</td>
                        <td class="px-4 md:px-6 py-3 md:py-4 font-bold text-green-600 dark:text-green-400 text-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Tampilan Mobile (Card) -->
        <div class="block sm:hidden divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($order->items as $item)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-semibold text-gray-800 dark:text-white text-base">{{ $item->product->name }}</h4>
                    <span class="text-green-600 dark:text-green-400 font-bold text-sm">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Harga Satuan:</span>
                        <p class="text-gray-800 dark:text-gray-200">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Jumlah:</span>
                        <p class="text-gray-800 dark:text-gray-200">{{ $item->quantity }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="p-4 bg-gray-50 dark:bg-gray-700">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Total:</span>
                    <span class="font-bold text-green-600 dark:text-green-400 text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Rating untuk produk yang sudah selesai -->
    @if($order->status == 'delivered')
    <div class="mt-8">
        <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-white mb-4">⭐ Berikan Rating & Review</h3>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4">
            Terima kasih telah berbelanja! Berikan penilaian Anda untuk produk yang telah dibeli.
        </p>
        
        <div class="space-y-6">
            @foreach($order->items as $item)
                @php
                    $hasRated = \App\Models\Rating::where('user_id', auth()->id())
                                    ->where('product_id', $item->product_id)
                                    ->where('order_id', $order->id)
                                    ->exists();
                @endphp
                
                @if(!$hasRated)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    
                    <div class="w-full max-w-2xl mx-auto">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                            @if($item->product->image)
                                <img 
                                    src="{{ asset($item->product->image) }}" 
                                    alt="{{ $item->product->name }}" 
                                    class="w-full h-auto object-cover"
                                >
                            @else
                                <div class="w-full h-48 sm:h-64 flex items-center justify-center">
                                    <i class="fas fa-cactus text-6xl text-gray-400"></i>
                                </div>
                            @endif

                            <div class="p-4">
                                <h4 class="font-bold text-base sm:text-lg text-gray-800 dark:text-white">
                                    {{ $item->product->name }}
                                </h4>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('orders.rating', $order) }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        Rating:
                                    </span>

                                    <div class="rating-stars flex space-x-1 sm:space-x-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button 
                                                type="button" 
                                                class="star-rating text-2xl sm:text-3xl text-gray-300 dark:text-gray-400 hover:text-yellow-400 transition"
                                                data-value="{{ $i }}"
                                            >
                                                <i class="fas fa-star"></i>
                                            </button>
                                        @endfor
                                    </div>

                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Klik bintang untuk memberikan rating
                                    </p>

                                    <input type="hidden" name="rating" class="rating-value" required>
                                </div>

                                <div>
                                    <textarea 
                                        name="review" 
                                        rows="3" 
                                        class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-green-500 focus:border-green-500" 
                                        placeholder="Tulis review Anda (opsional)"
                                    ></textarea>
                                </div>

                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition text-sm">
                                    <i class="fas fa-paper-plane mr-2"></i> Kirim Rating
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                @else
                <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4 border border-green-200 dark:border-green-800">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        <div>
                            <p class="text-green-700 dark:text-green-300 font-semibold text-sm sm:text-base">
                                Terima kasih sudah memberikan rating!
                            </p>
                            <p class="text-xs sm:text-sm text-green-600 dark:text-green-400">
                                Anda telah memberikan penilaian untuk produk {{ $item->product->name }}.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <style>
        .rating-stars .star-rating {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .rating-stars .star-rating:hover {
            transform: scale(1.1);
        }

        .rating-stars .star-rating.active {
            color: #facc15 !important;
        }
    </style>

    <script>
        document.querySelectorAll('.rating-stars').forEach(container => {
            const stars = container.querySelectorAll('.star-rating');
            const ratingInput = container.closest('form').querySelector('.rating-value');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = value;

                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.add('active');
                            s.classList.remove('text-gray-300', 'dark:text-gray-400');
                            s.classList.add('text-yellow-400');
                        } else {
                            s.classList.remove('active', 'text-yellow-400');
                            s.classList.add('text-gray-300', 'dark:text-gray-400');
                        }
                    });
                });
            });
        });
    </script>
    @endif
    
    @if($order->status == 'delivered')
    <div class="mt-4 p-3 sm:p-4 bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-200 rounded-lg text-sm sm:text-base">
        <i class="fas fa-check-circle"></i> Pesanan telah selesai. Terima kasih telah berbelanja di Kita Kaktus!
    </div>
    @endif
</div>
@endsection