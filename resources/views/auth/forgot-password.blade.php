@extends('layouts.app')

@section('title', 'Lupa Password - Kita Kaktus')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 sm:py-12 px-3 sm:px-4 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="{{ asset('images/promosi/logo new.webp') }}"
             alt="Background Kita Kaktus"
             class="w-full h-full object-cover scale-110 blur-sm">

        <div class="absolute inset-0 bg-black/65 dark:bg-black/75 backdrop-blur-[2px]"></div>

        <div class="absolute top-10 left-10 w-48 sm:w-72 h-48 sm:h-72 bg-green-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-48 sm:w-72 h-48 sm:h-72 bg-yellow-500/20 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md space-y-6 sm:space-y-8 animate-fade-in-up px-2 sm:px-0">
        <div class="text-center">
            <div class="animate-bounce-slow">
                <div class="w-auto h-auto px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                    <span class="text-sm sm:text-xl font-bold text-white">Kita Kaktus</span>
                </div>
            </div>

            <h2 class="mt-4 sm:mt-6 text-2xl sm:text-3xl font-extrabold text-white">
                Lupa Password
            </h2>

            <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-200">
                Masukkan email akun kamu untuk menerima link reset password
            </p>
        </div>

        <form class="mt-6 sm:mt-8 space-y-4 sm:space-y-5 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md p-5 sm:p-8 rounded-2xl shadow-2xl"
              method="POST"
              action="{{ route('password.email') }}">
            @csrf

            @if (session('error'))
                <div class="p-3 rounded-xl bg-red-100 text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="p-3 rounded-xl bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400 dark:text-gray-300 text-sm sm:text-base"></i>
                    </div>

                    <input id="email"
                           name="email"
                           type="email"
                           autocomplete="email"
                           required
                           value="{{ old('email') }}"
                           class="block w-full rounded-xl border-gray-300 dark:border-gray-600 pl-10 pr-3 py-2.5 sm:py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-green-500 focus:ring-green-500 focus:outline-none focus:ring-2 transition-all duration-200 text-sm sm:text-base"
                           placeholder="Alamat Email">
                </div>

                @error('email')
                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 sm:mt-8">
                <button type="submit"
                        class="group relative w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-[1.02] active:scale-95 shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-paper-plane text-green-300 group-hover:text-green-200 transition-colors duration-200 text-sm sm:text-base"></i>
                    </span>
                    Kirim Link Reset Password
                </button>
            </div>

            <div class="text-center mt-3 sm:mt-4">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center font-medium text-green-600 hover:text-green-500 transition-colors duration-200 hover:underline text-xs sm:text-sm">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i>
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out;
}

.animate-bounce-slow {
    animation: bounce 2s infinite;
}
</style>
@endsection