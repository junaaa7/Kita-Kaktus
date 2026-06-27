@extends('layouts.app')

@section('title', 'Home - Kita Kaktus')

@section('content')
<section class="relative overflow-hidden rounded-3xl mb-8 md:mb-16 h-[400px] md:h-[500px] lg:h-[600px] py-10 md:py-20 flex items-center">
    <div class="absolute inset-0">
        <img src="{{ asset('images/promosi/hero new 1.webp') }}" alt="Hero Background" class="w-full h-full object-cover object-center" fetchpriority="high" loading="eager" decoding="sync">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-green-800/60"></div>
    </div>
    
    <div class="absolute top-10 md:top-20 left-5 md:left-10 animate-float-slow">
        <i aria-hidden="true" class="fas fa-cactus text-2xl md:text-4xl text-white/30"></i>
    </div>
    
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 text-center text-white">
        <div class="inline-block mb-3 md:mb-4 px-3 md:px-4 py-1 bg-white/20 rounded-full backdrop-blur-sm animate-fade-in-up">
            <span class="text-xs md:text-sm">Welcome to Kita Kaktus</span>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-3 md:mb-6 animate-slide-down">
            Temukan Kaktus
            <span class="block text-yellow-300">Impian Anda</span>
        </h1>
        
        <p class="text-sm sm:text-base md:text-lg lg:text-xl mb-6 md:mb-8 max-w-2xl mx-auto animate-slide-up opacity-90 px-4">
            Koleksi kaktus terbaik dengan kualitas premium. Dapatkan tanaman hias yang unik untuk mempercantik rumah Anda.
        </p>
    </div>
</section>

<div class="mb-12 md:mb-16" data-aos="fade-up">
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white text-center mb-2 md:mb-4 px-4">Kenapa Harus Kita Kaktus?</h2>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 text-center mb-8 md:mb-12 max-w-2xl mx-auto px-4">Karena Kami menyediakan kaktus berkualitas dengan pelayanan terbaik</p>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 px-4 sm:px-0">
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
            <div class="relative h-40 sm:h-48 overflow-hidden">
                <img src="{{ asset('images/promosi/pengiriman.webp') }}" alt="Pengiriman" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-3 md:bottom-4 left-3 md:left-4 text-white"><i aria-hidden="true" class="fas fa-truck text-2xl md:text-3xl"></i></div>
            </div>
            <div class="p-4 md:p-6 text-center">
                <h3 class="font-bold text-lg md:text-xl text-gray-800 dark:text-white mb-1 md:mb-2">Gratis Ongkir</h3>
                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Minimal belanja Rp 500.000</p>
            </div>
        </div>
        
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
            <div class="relative h-40 sm:h-48 overflow-hidden">
                <img src="{{asset('images/promosi/kaktus.webp') }}" alt="Kaktus Sehat" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-3 md:bottom-4 left-3 md:left-4 text-white"><i aria-hidden="true" class="fas fa-seedling text-2xl md:text-3xl"></i></div>
            </div>
            <div class="p-4 md:p-6 text-center">
                <h3 class="font-bold text-lg md:text-xl text-gray-800 dark:text-white mb-1 md:mb-2">Kaktus Sehat</h3>
                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Tanaman berkualitas terbaik</p>
            </div>
        </div>
        
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
            <div class="relative h-40 sm:h-48 overflow-hidden">
                <img src="{{asset('images/promosi/pembayaran.webp') }}" alt="Pembayaran" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-3 md:bottom-4 left-3 md:left-4 text-white"><i aria-hidden="true" class="fas fa-credit-card text-2xl md:text-3xl"></i></div>
            </div>
            <div class="p-4 md:p-6 text-center">
                <h3 class="font-bold text-lg md:text-xl text-gray-800 dark:text-white mb-1 md:mb-2">Pembayaran Mudah</h3>
                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Transfer Bank, QRIS, COD</p>
            </div>
        </div>
        
        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
            <div class="relative h-40 sm:h-48 overflow-hidden">
                <img src="{{asset('images/promosi/layanan.webp') }}" alt="Layanan" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-3 md:bottom-4 left-3 md:left-4 text-white"><i aria-hidden="true" class="fas fa-headset text-2xl md:text-3xl"></i></div>
            </div>
            <div class="p-4 md:p-6 text-center">
                <h3 class="font-bold text-lg md:text-xl text-gray-800 dark:text-white mb-1 md:mb-2">Layanan 24/7</h3>
                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Konsultasi via WhatsApp</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-12 md:mb-20" data-aos="fade-up">
    <div class="flex justify-between items-end mb-6 md:mb-8 px-4 sm:px-0">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">Produk Terlaris</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Pilihan favorit pelanggan Kita Kaktus</p>
        </div>
        <a href="{{ route('collection.index') }}" class="hidden sm:inline-flex items-center text-green-600 dark:text-green-400 font-medium hover:text-green-700 dark:hover:text-green-300 transition-colors">
            Lihat Semua Koleksi <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 px-4 sm:px-0">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
            <div class="relative h-40 md:h-52 overflow-hidden bg-gray-100 dark:bg-gray-700">
                <img src="{{ asset('images/promosi/dasboard (2).webp') }}" alt="Kaktus Gymnocalycium" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute top-2 right-2 bg-red-500 text-xs font-bold px-2 py-1 rounded text-white shadow-sm">Hot</div>
            </div>
            <div class="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white mb-1 text-sm md:text-base line-clamp-2">Kaktus Gymnocalycium Mini</h3>
                    <div class="flex text-yellow-400 text-[10px] md:text-xs mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">(4.8)</span>
                    </div>
                    <p class="text-green-600 dark:text-green-400 font-bold mb-3 text-sm md:text-base">Rp 35.000</p>
                </div>
                <a href="{{ route('collection.index') }}" class="block w-full py-2 text-center text-xs md:text-sm border-2 border-green-500 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-500 hover:text-white transition duration-300 font-semibold">
                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
            <div class="relative h-40 md:h-52 overflow-hidden bg-gray-100 dark:bg-gray-700">
                <img src="{{ asset('images/promosi/kebun kaktus.webp') }}" alt="Kaktus Koboi" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            </div>
            <div class="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white mb-1 text-sm md:text-base line-clamp-2">Kaktus Koboi (Cereus)</h3>
                    <div class="flex text-yellow-400 text-[10px] md:text-xs mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">(5.0)</span>
                    </div>
                    <p class="text-green-600 dark:text-green-400 font-bold mb-3 text-sm md:text-base">Rp 55.000</p>
                </div>
                <a href="{{ route('collection.index') }}" class="block w-full py-2 text-center text-xs md:text-sm border-2 border-green-500 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-500 hover:text-white transition duration-300 font-semibold">
                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
            <div class="relative h-40 md:h-52 overflow-hidden bg-gray-100 dark:bg-gray-700">
                <img src="{{ asset('images/promosi/dasboard (3).webp') }}" alt="Sukulen Haworthia" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            </div>
            <div class="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white mb-1 text-sm md:text-base line-clamp-2">Sukulen Haworthia Zebra</h3>
                    <div class="flex text-yellow-400 text-[10px] md:text-xs mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">(4.0)</span>
                    </div>
                    <p class="text-green-600 dark:text-green-400 font-bold mb-3 text-sm md:text-base">Rp 25.000</p>
                </div>
                <a href="{{ route('collection.index') }}" class="block w-full py-2 text-center text-xs md:text-sm border-2 border-green-500 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-500 hover:text-white transition duration-300 font-semibold">
                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
            <div class="relative h-40 md:h-52 overflow-hidden bg-gray-100 dark:bg-gray-700">
                <img src="{{ asset('images/promosi/hero new 1.webp') }}" alt="Paket Pemula" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute top-2 right-2 bg-yellow-500 text-xs font-bold px-2 py-1 rounded text-white shadow-sm">Promo</div>
            </div>
            <div class="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white mb-1 text-sm md:text-base line-clamp-2">Paket Kaktus Pemula (Isi 3)</h3>
                    <div class="flex text-yellow-400 text-[10px] md:text-xs mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">(5.0)</span>
                    </div>
                    <p class="text-green-600 dark:text-green-400 font-bold mb-3 text-sm md:text-base">Rp 80.000 <span class="line-through text-gray-400 text-xs font-normal ml-1">Rp 100.000</span></p>
                </div>
                <a href="{{ route('collection.index') }}" class="block w-full py-2 text-center text-xs md:text-sm border-2 border-green-500 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-500 hover:text-white transition duration-300 font-semibold">
                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                </a>
            </div>
        </div>
    </div>
    
    <div class="mt-6 text-center sm:hidden px-4">
        <a href="{{ route('collection.index') }}" class="inline-flex items-center justify-center w-full py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg font-medium transition-colors">
            Lihat Semua Koleksi
        </a>
    </div>
</div>

<div class="mb-12 md:mb-16" data-aos="fade-up">
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white text-center mb-2 md:mb-4 px-4">Galeri Tempat Kita Kaktus</h2>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 text-center mb-8 md:mb-12 max-w-2xl mx-auto px-4">Lihat langsung suasana kebun dan toko kami yang asri dan nyaman</p>

    <div class="max-w-4xl mx-auto px-4 sm:px-0">
        <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-64 sm:h-80 md:h-[420px]" data-aos="zoom-in" data-aos-delay="100">
            <div class="gallery-slider relative w-full h-full">
                <div class="gallery-slide gallery-slide-1 absolute inset-0">
                    <img src="{{ asset('images/promosi/kebun kaktus.webp') }}" alt="Kebun Kaktus" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent flex items-end p-5 md:p-6">
                        <p class="text-white font-semibold text-sm md:text-lg">Kebun Kaktus Indah</p>
                    </div>
                </div>

                <div class="gallery-slide gallery-slide-2 absolute inset-0">
                    <img src="{{ asset('images/promosi/dasboard (3).webp') }}" alt="Toko Kaktus" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent flex items-end p-5 md:p-6">
                        <p class="text-white font-semibold text-sm md:text-lg">Toko Kaktus Modern</p>
                    </div>
                </div>

                <div class="gallery-slide gallery-slide-3 absolute inset-0">
                    <img src="{{ asset('images/promosi/dasboard (2).webp') }}" alt="Koleksi Kaktus" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent flex items-end p-5 md:p-6">
                        <p class="text-white font-semibold text-sm md:text-lg">Koleksi Lengkap Kaktus</p>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
                <span class="gallery-dot gallery-dot-1 w-2.5 h-2.5 rounded-full bg-white/80"></span>
                <span class="gallery-dot gallery-dot-2 w-2.5 h-2.5 rounded-full bg-white/80"></span>
                <span class="gallery-dot gallery-dot-3 w-2.5 h-2.5 rounded-full bg-white/80"></span>
            </div>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 md:p-8 mb-12 mx-4 sm:mx-0" data-aos="fade-right">
    <div class="text-center mb-6 md:mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-3 md:mb-4">Tentang Kita Kaktus</h2>
        <div class="w-20 md:w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
    </div>
    
    <div class="flex flex-col md:flex-row items-center gap-6 md:gap-8">
        <div class="md:w-1/2 w-full" data-aos="zoom-in">
            <div class="relative rounded-xl overflow-hidden group">
                <img src="{{ asset('images/promosi/logo new.webp') }}" alt="Kebun Kaktus" class="w-full h-64 sm:h-80 object-cover group-hover:scale-110 transition duration-500" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition duration-300"></div>
            </div>
        </div>
        <div class="md:w-1/2 w-full">
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-3 md:mb-4 leading-relaxed" data-aos="fade-left" data-aos-delay="100">
                Kaktus adalah salah satu anggota famili Cactaceae yang sangat khas karena dapat hidup lama tanpa air. 
                Habitat Kaktus ada di daerah gurun, padang rumput kering atau wilayah yang panas. 
                Kita Kaktus adalah brand tanaman hias yang berdiri sejak tahun 2024.
            </p>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-3 md:mb-4 leading-relaxed" data-aos="fade-left" data-aos-delay="200">
                Fokus pada pengembangan dan penjualan berbagai jenis Kaktus dan Sekulen yang berkualitas. 
                Kami berkomitmen menghadirkan Koleksi Kaktus terbaik untuk pecinta tanaman di Indonesia.
            </p>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed" data-aos="fade-left" data-aos-delay="300">
                Kami menyediakan puluhan jenis kaktus mulai dari bibit, media tanam, pot, topping tanaman. 
                Seluruh tanaman kami rawat secara profesional, ditanam di media yang sehat dan dipilih dengan teliti sebelum dikirim.
            </p>
        </div>
    </div>
</div>

<div class="mb-12 md:mb-16" data-aos="fade-up">
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white text-center mb-2 px-4">Apa Kata Mereka?</h2>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 text-center mb-8 md:mb-12 max-w-2xl mx-auto px-4">Pengalaman pelanggan yang sudah berbelanja di Kita Kaktus</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6 px-4 sm:px-0">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 relative mt-6 hover:-translate-y-2 transition-transform duration-300">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-14 h-14 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden bg-green-100">
                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=22c55e&color=fff" alt="User Budi" class="w-full h-full object-cover">
            </div>
            <div class="text-center mt-6">
                <div class="text-yellow-400 text-xs mb-3">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-sm italic mb-4">"Kaktusnya sampai dengan selamat, packingnya super aman banget berlapis-lapis! Tanaman sehat dan akar bagus. Bakal order lagi buat nambah koleksi di meja kerja."</p>
                <h4 class="font-bold text-gray-800 dark:text-white text-sm">Budi Santoso</h4>
                <p class="text-xs text-gray-500">Pembeli Kaktus Gymno</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 relative mt-6 hover:-translate-y-2 transition-transform duration-300" data-aos-delay="100">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-14 h-14 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden bg-blue-100">
                <img src="https://ui-avatars.com/api/?name=Siti+Aisyah&background=3b82f6&color=fff" alt="User Siti" class="w-full h-full object-cover">
            </div>
            <div class="text-center mt-6">
                <div class="text-yellow-400 text-xs mb-3">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-sm italic mb-4">"Penjualnya ramah, nanya-nanya cara perawatan dijawab dengan detail. Sukulen Haworthia-nya cantik banget, cocok buat hiasan di ruang tamu. Terima kasih Kita Kaktus!"</p>
                <h4 class="font-bold text-gray-800 dark:text-white text-sm">Siti Aisyah</h4>
                <p class="text-xs text-gray-500">Pembeli Sukulen Haworthia</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 relative mt-6 hover:-translate-y-2 transition-transform duration-300" data-aos-delay="200">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-14 h-14 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden bg-purple-100">
                <img src="https://ui-avatars.com/api/?name=Reza+F&background=a855f7&color=fff" alt="User Reza" class="w-full h-full object-cover">
            </div>
            <div class="text-center mt-6">
                <div class="text-yellow-400 text-xs mb-3">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-sm italic mb-4">"Pengiriman lumayan cepat padahal beda provinsi. Beli paket pemula, semua hidup dan segar. Sangat direkomendasikan buat yang baru mau coba pelihara tanaman hias."</p>
                <h4 class="font-bold text-gray-800 dark:text-white text-sm">Reza Fahlevi</h4>
                <p class="text-xs text-gray-500">Pembeli Paket Pemula</p>
            </div>
        </div>
    </div>
</div>

<div class="relative bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 md:p-10 mb-12 text-center overflow-hidden mx-4 sm:mx-0" data-aos="flip-up">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>
    <div class="relative z-10">
        <i class="fab fa-whatsapp text-4xl md:text-5xl text-white mb-3 md:mb-4 animate-bounce"></i>
        <h3 class="text-xl md:text-2xl lg:text-3xl font-bold text-white mb-2 md:mb-3 px-4">Ada yang ingin ditanyakan?</h3>
        <p class="text-sm md:text-base text-green-100 mb-4 md:mb-6 px-4">Hubungi kami melalui WhatsApp untuk konsultasi atau pemesanan khusus</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 gap-3 px-4">
            <a href="https://wa.me/6287871797367?text=Halo%20Kita%20Kaktus%2C%20saya%20tertarik%20dengan%20produk%20kaktus%20Anda" 
               target="_blank" 
               class="inline-flex items-center justify-center space-x-2 bg-white text-green-600 px-6 md:px-8 py-2 md:py-3 rounded-lg hover:bg-gray-100 transition transform hover:scale-105 duration-300 font-semibold shadow-lg text-sm md:text-base">
                <i class="fab fa-whatsapp text-lg md:text-xl"></i> <span>Chat WhatsApp</span>
            </a>
            <a href="{{ route('collection.index') }}" class="inline-flex items-center justify-center space-x-2 bg-green-800 text-white px-6 md:px-8 py-2 md:py-3 rounded-lg hover:bg-green-900 transition transform hover:scale-105 duration-300 font-semibold shadow-lg text-sm md:text-base">
                <i class="fas fa-store mr-2"></i> <span>Lihat Koleksi</span>
            </a>
        </div>
    </div>
</div>

@guest
<div class="mt-8 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-4 md:p-6 rounded-lg mx-4 sm:mx-0" data-aos="fade-up">
    <div class="flex items-start">
        <div class="flex-shrink-0"><i class="fas fa-info-circle text-xl md:text-2xl text-blue-500"></i></div>
        <div class="ml-3 md:ml-4">
            <h3 class="text-base md:text-lg font-semibold text-blue-800 dark:text-blue-200">Ingin berbelanja?</h3>
            <p class="text-sm md:text-base text-blue-700 dark:text-blue-300 mt-1">
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

/* Responsive animations */
@media (max-width: 640px) {
    .animate-slide-down {
        animation: slide-down 0.4s ease-out;
    }
    .animate-slide-up {
        animation: slide-up 0.4s ease-out;
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out forwards;
    }
}

@keyframes slide-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float-slow {
    0%, 100% { transform: translateY(0px) translateX(0px); }
    50% { transform: translateY(-15px) translateX(8px); }
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.animate-float-slow {
    animation: float-slow 6s ease-in-out infinite;
}

.animate-bounce {
    animation: bounce 2s ease-in-out infinite;
}
.gallery-slide {
    opacity: 0;
    transform: scale(1.04);
    animation: galleryFade 12s infinite;
}

.gallery-slide-1 {
    animation-delay: 0s;
}

.gallery-slide-2 {
    animation-delay: 4s;
}

.gallery-slide-3 {
    animation-delay: 8s;
}

.gallery-dot {
    opacity: 0.45;
    animation: galleryDot 12s infinite;
}

.gallery-dot-1 {
    animation-delay: 0s;
}

.gallery-dot-2 {
    animation-delay: 4s;
}

.gallery-dot-3 {
    animation-delay: 8s;
}

@keyframes galleryFade {
    0% {
        opacity: 0;
        transform: scale(1.04);
    }
    8% {
        opacity: 1;
        transform: scale(1);
    }
    30% {
        opacity: 1;
        transform: scale(1);
    }
    40% {
        opacity: 0;
        transform: scale(1.04);
    }
    100% {
        opacity: 0;
        transform: scale(1.04);
    }
}

@keyframes galleryDot {
    0%, 40%, 100% {
        opacity: 0.45;
        transform: scale(1);
    }
    8%, 30% {
        opacity: 1;
        transform: scale(1.25);
    }
}

@media (prefers-reduced-motion: reduce) {
    .gallery-slide,
    .gallery-dot {
        animation: none;
    }

    .gallery-slide-1 {
        opacity: 1;
        transform: scale(1);
    }
}
</style>