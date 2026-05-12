@extends('layouts.app')

@section('title', 'Home - Kita Kaktus')

@section('content')
<!-- Hero Section - Promosi -->
<div class="bg-gradient-to-r from-green-500 to-green-700 rounded-xl text-white p-12 mb-12 text-center">
    <h1 class="text-5xl font-bold mb-4">🌵 Kita Kaktus</h1>
    <p class="text-xl mb-6">Toko Kaktus Online Terpercaya | Kaktus Berkualitas Harga Terjangkau</p>
    <div class="flex justify-center space-x-4 flex-wrap gap-4">
        <a href="{{ route('collection.index') }}" class="inline-block bg-white text-green-600 px-6 py-3 rounded-lg hover:bg-gray-100 transition font-semibold">
            <i class="fas fa-store mr-2"></i> Lihat Koleksi
        </a>
        <a href="https://wa.me/6281234567890?text=Halo%20Kita%20Kaktus%2C%20saya%20ingin%20bertanya%20tentang%20produk%20kaktus" 
           target="_blank" 
           class="inline-block bg-green-800 text-white px-6 py-3 rounded-lg hover:bg-green-900 transition font-semibold">
            <i class="fab fa-whatsapp mr-2"></i> Hubungi Kami
        </a>
    </div>
</div>

<!-- Promosi Section - Keunggulan Toko -->
<div class="mb-12">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-8">Kenapa Harus Kita Kaktus?</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-truck text-2xl text-green-600"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-2">Gratis Ongkir</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Minimal belanja Rp 500.000</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-seedling text-2xl text-green-600"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-2">Kaktus Sehat</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Tanaman berkualitas terbaik</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-credit-card text-2xl text-green-600"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-2">Pembayaran Mudah</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Transfer Bank, QRIS, COD</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-headset text-2xl text-green-600"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-2">Layanan 24/7</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Konsultasi via WhatsApp</p>
        </div>
    </div>
</div>

<!-- About Section - Promosi -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mb-12">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Tentang Kita Kaktus</h2>
        <i class="fas fa-cactus text-7xl text-green-500 mb-6"></i>
        <p class="text-gray-600 dark:text-gray-400 mb-4 max-w-3xl mx-auto">
            Kaktus adalah salah satu anggota famili Cactaceae yang sangat khas karena
            dapat hidup lama tanpa air. Habitat Kaktus ada di daerah gurun, padang rumput 
            kering atau wilayah yang panas. Kita Kaktus adalah brand tanaman hias yang 
            berdiri sejak tahun 2024. Fokus pada pengembangan dan penjualan berbagai 
            jenis Kaktus dan Sekulen yang berkualitas. Kami berkomitmen menghadirkan 
            Koleksi Kaktus terbaik untuk pecinta tanaman di Indonesia. Kami menyediakan 
            puluhan jenis kaktus mulai dari bibit, media tanam, pot, topping tanaman, … 
            seluruh tanaman kami di rawat secara profesional … ditanam di media yang sehat 
            dan dipilih dengan teliti sebelum dikirim ke customer. Untuk pengiriman bisa 
            untuk keseluruhan Indonesia.
        </p>
        <p class="text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
            Setiap kaktus yang kami jual sudah melalui proses seleksi ketat untuk memastikan 
            tanaman dalam kondisi sehat dan siap tumbuh di rumah Anda.
        </p>
    </div>
</div>

<!-- Call to Action - Promosi -->
<div class="mt-12 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-lg p-8 text-center">
    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">Ada yang ingin ditanyakan?</h3>
    <p class="text-gray-600 dark:text-gray-400 mb-4">Hubungi kami melalui WhatsApp untuk konsultasi atau pemesanan khusus</p>
    <div class="flex justify-center space-x-4 flex-wrap gap-4">
        <a href="https://wa.me/6281234567890?text=Halo%20Kita%20Kaktus%2C%20saya%20tertarik%20dengan%20produk%20kaktus%20Anda" 
           target="_blank" 
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg transition font-semibold text-lg">
            <i class="fab fa-whatsapp mr-2 text-xl"></i> Chat WhatsApp
        </a>
        <a href="{{ route('collection.index') }}" class="inline-block bg-green-700 hover:bg-green-800 text-white px-8 py-3 rounded-lg transition font-semibold text-lg">
            <i class="fas fa-store mr-2"></i> Lihat Koleksi
        </a>
    </div>
</div>

<!-- Info Section untuk Guest -->
@guest
<div class="mt-8 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-6 rounded-lg">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-2xl text-blue-500"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Ingin berbelanja?</h3>
            <p class="text-blue-700 dark:text-blue-300 mt-1">
                Silahkan <a href="{{ route('login') }}" class="font-bold underline">Login</a> jika sudah punya akun, 
                atau <a href="{{ route('register') }}" class="font-bold underline">Register</a> untuk membuat akun baru.
            </p>
        </div>
    </div>
</div>
@endguest
@endsection