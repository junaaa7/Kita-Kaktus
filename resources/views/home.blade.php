@extends('layouts.app')

@section('title', 'Home - Kita Kaktus')

@section('content')
<!-- Hero Section dengan Animasi -->
<div class="relative bg-gradient-to-r from-green-600 to-green-800 rounded-xl overflow-hidden mb-12" data-aos="fade-down">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>
    
    <div class="relative z-10 px-8 py-16 md:py-24 text-center text-white">
        <div class="animate-bounce inline-block mb-4">
            <i class="fas fa-cactus text-5xl md:text-6xl"></i>
        </div>
        <h1 class="text-4xl md:text-6xl font-bold mb-4">🌵 Kita Kaktus</h1>
        <p class="text-xl md:text-2xl mb-8">Toko Kaktus Online Terpercaya | Kaktus Berkualitas Harga Terjangkau</p>
        <div class="flex justify-center space-x-4 flex-wrap gap-4">
            <a href="{{ route('collection.index') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition transform hover:scale-105 duration-300 font-semibold shadow-lg">
                <i class="fas fa-store mr-2"></i> Lihat Koleksi
            </a>
            <a href="https://wa.me/6281234567890?text=Halo%20Kita%20Kaktus%2C%20saya%20ingin%20bertanya%20tentang%20produk%20kaktus" 
               target="_blank" 
               class="inline-block bg-green-700 text-white px-8 py-3 rounded-lg hover:bg-green-800 transition transform hover:scale-105 duration-300 font-semibold shadow-lg">
                <i class="fab fa-whatsapp mr-2"></i> Hubungi Kami
            </a>
        </div>
    </div>
</div>

<!-- Galeri Foto Tempat Kita Kaktus -->
<div class="mb-16" data-aos="fade-up">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-white text-center mb-4">Galeri Tempat Kita Kaktus</h2>
    <p class="text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">Lihat langsung suasana kebun dan toko kami yang asri dan nyaman</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="100">
            <img src="{{ asset('storage/promosi/dasboard (2).jpg') }}" alt="Kebun Kaktus" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                <p class="text-white font-semibold">Kebun Kaktus Indah</p>
            </div>
        </div>
        
        <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="200">
            <img src="{{ asset('storage/promosi/dasboard (2).jpg') }}" alt="Toko Kaktus" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                <p class="text-white font-semibold">Toko Kaktus Modern</p>
            </div>
        </div>
        
        <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="300">
            <img src="{{ asset('storage/promosi/dasboard (2).jpg') }}" alt="Koleksi Kaktus" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                <p class="text-white font-semibold">Koleksi Lengkap Kaktus</p>
            </div>
        </div>
    </div>
</div>

<!-- Promosi Section - Keunggulan Toko -->
<div class="mb-16" data-aos="fade-up">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-white text-center mb-4">Kenapa Harus Kita Kaktus?</h2>
    <p class="text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">Karena Kami menyediakan kaktus berkualitas dengan pelayanan terbaik</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('storage/promosi/pengiriman.png') }}" alt="Pengiriman" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white"><i class="fas fa-truck text-3xl"></i></div>
            </div>
            <div class="p-6 text-center">
                <h3 class="font-bold text-xl text-gray-800 dark:text-white mb-2">Gratis Ongkir</h3>
                <p class="text-gray-600 dark:text-gray-400">Minimal belanja Rp 500.000</p>
            </div>
        </div>
        
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
            <div class="relative h-48 overflow-hidden">
                <img src="{{asset('storage/promosi/kaktus.png') }}" alt="Kaktus Sehat" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white"><i class="fas fa-seedling text-3xl"></i></div>
            </div>
            <div class="p-6 text-center">
                <h3 class="font-bold text-xl text-gray-800 dark:text-white mb-2">Kaktus Sehat</h3>
                <p class="text-gray-600 dark:text-gray-400">Tanaman berkualitas terbaik</p>
            </div>
        </div>
        
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
            <div class="relative h-48 overflow-hidden">
                <img src="{{asset('storage/promosi/pembayaran.jpg') }}" alt="Pembayaran" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white"><i class="fas fa-credit-card text-3xl"></i></div>
            </div>
            <div class="p-6 text-center">
                <h3 class="font-bold text-xl text-gray-800 dark:text-white mb-2">Pembayaran Mudah</h3>
                <p class="text-gray-600 dark:text-gray-400">Transfer Bank, QRIS, COD</p>
            </div>
        </div>
        
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
            <div class="relative h-48 overflow-hidden">
                <img src="{{asset('storage/promosi/layanan.jpg') }}" alt="Layanan" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white"><i class="fas fa-headset text-3xl"></i></div>
            </div>
            <div class="p-6 text-center">
                <h3 class="font-bold text-xl text-gray-800 dark:text-white mb-2">Layanan 24/7</h3>
                <p class="text-gray-600 dark:text-gray-400">Konsultasi via WhatsApp</p>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-12" data-aos="fade-right">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Tentang Kita Kaktus</h2>
        <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
    </div>
    
    <div class="flex flex-col md:flex-row items-center gap-8">
        <div class="md:w-1/2" data-aos="zoom-in">
            <div class="relative rounded-xl overflow-hidden group">
                <img src="{{ asset('storage/promosi/logo.jpg') }}" alt="Kebun Kaktus" class="w-full h-80 object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition duration-300"></div>
            </div>
        </div>
        <div class="md:w-1/2">
            <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed" data-aos="fade-left" data-aos-delay="100">
                Kaktus adalah salah satu anggota famili Cactaceae yang sangat khas karena dapat hidup lama tanpa air. 
                Habitat Kaktus ada di daerah gurun, padang rumput kering atau wilayah yang panas. 
                Kita Kaktus adalah brand tanaman hias yang berdiri sejak tahun 2024.
            </p>
            <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed" data-aos="fade-left" data-aos-delay="200">
                Fokus pada pengembangan dan penjualan berbagai jenis Kaktus dan Sekulen yang berkualitas. 
                Kami berkomitmen menghadirkan Koleksi Kaktus terbaik untuk pecinta tanaman di Indonesia.
            </p>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed" data-aos="fade-left" data-aos-delay="300">
                Kami menyediakan puluhan jenis kaktus mulai dari bibit, media tanam, pot, topping tanaman. 
                Seluruh tanaman kami rawat secara profesional, ditanam di media yang sehat dan dipilih dengan teliti sebelum dikirim.
            </p>
            
        </div>
    </div>
</div>

<!-- Testimoni Section -->
<div class="mb-16" data-aos="fade-up">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-white text-center mb-4">Penilaian Produk</h2>
    <p class="text-gray-600 dark:text-gray-400 text-center mb-12">Terimakasih Sudah Memberikan Ulasan</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:shadow-2xl transition duration-300" data-aos="zoom-in" data-aos-delay="100">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user text-3xl text-green-600"></i>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-4">"Kaktusnya sehat dan bagus, pengiriman cepat. Recommended!"</p>
            <h4 class="font-semibold text-gray-800 dark:text-white">- Budi Santoso</h4>
            <div class="text-yellow-500 mt-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:shadow-2xl transition duration-300" data-aos="zoom-in" data-aos-delay="200">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user text-3xl text-green-600"></i>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-4">"Koleksi kaktusnya lengkap, harga terjangkau. Puas sekali!"</p>
            <h4 class="font-semibold text-gray-800 dark:text-white">- Siti Aminah</h4>
            <div class="text-yellow-500 mt-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:shadow-2xl transition duration-300" data-aos="zoom-in" data-aos-delay="300">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user text-3xl text-green-600"></i>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-4">"Pelayanan ramah, kaktus sampai dengan selamat. Top markotop!"</p>
            <h4 class="font-semibold text-gray-800 dark:text-white">- Andi Wijaya</h4>
            <div class="text-yellow-500 mt-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        </div>
    </div>
</div>

<!-- Call to Action WhatsApp -->
<div class="relative bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-10 mb-12 text-center overflow-hidden" data-aos="flip-up">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>
    <div class="relative z-10">
        <i class="fab fa-whatsapp text-5xl text-white mb-4 animate-bounce"></i>
        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Ada yang ingin ditanyakan?</h3>
        <p class="text-green-100 mb-6">Hubungi kami melalui WhatsApp untuk konsultasi atau pemesanan khusus</p>
        <div class="flex justify-center space-x-4 flex-wrap gap-4">
            <a href="https://wa.me/6281234567890?text=Halo%20Kita%20Kaktus%2C%20saya%20tertarik%20dengan%20produk%20kaktus%20Anda" 
               target="_blank" 
               class="inline-flex items-center space-x-2 bg-white text-green-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition transform hover:scale-105 duration-300 font-semibold shadow-lg">
                <i class="fab fa-whatsapp text-xl"></i> <span>Chat WhatsApp</span>
            </a>
            <a href="{{ route('collection.index') }}" class="inline-flex items-center space-x-2 bg-green-800 text-white px-8 py-3 rounded-lg hover:bg-green-900 transition transform hover:scale-105 duration-300 font-semibold shadow-lg">
                <i class="fas fa-store mr-2"></i> <span>Lihat Koleksi</span>
            </a>
        </div>
    </div>
</div>

<!-- Info Section untuk Guest -->
@guest
<div class="mt-8 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-6 rounded-lg" data-aos="fade-up">
    <div class="flex items-start">
        <div class="flex-shrink-0"><i class="fas fa-info-circle text-2xl text-blue-500"></i></div>
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

<style>
[data-aos] {
    transition-timing-function: ease-in-out;
}
</style>