@extends('layouts.app')

@section('title', 'Login - Kita Kaktus')

@section('content')
<style>
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        transition: background-color 9999s ease-in-out 0s;
        box-shadow: 0 0 0px 1000px #ffffff inset !important;
        -webkit-text-fill-color: #111827 !important;
        caret-color: #111827 !important;
    }

    .dark input:-webkit-autofill,
    .dark input:-webkit-autofill:hover,
    .dark input:-webkit-autofill:focus,
    .dark input:-webkit-autofill:active {
        transition: background-color 9999s ease-in-out 0s;
        box-shadow: 0 0 0px 1000px #1f2937 inset !important;
        -webkit-text-fill-color: #f9fafb !important;
        caret-color: #f9fafb !important;
    }

    @keyframes fade-in-up {
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    @keyframes shake {
        0%, 100% { 
            transform: translateX(0); 
        }
        25% { 
            transform: translateX(-5px); 
        }
        75% { 
            transform: translateX(5px); 
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
    }

    .animate-shake {
        animation: shake 0.3s ease-in-out;
    }

    .login-page-wrapper {
        min-height: calc(100vh - 80px);
    }

    @media (max-width: 768px) {
        .login-page-wrapper {
            min-height: calc(100vh - 70px);
        }
    }
</style>

<div class="login-page-wrapper bg-gray-50 dark:bg-gray-900 flex items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
    <div class="w-full max-w-6xl bg-white dark:bg-gray-800 rounded-none md:rounded-3xl overflow-hidden shadow-2xl animate-fade-in-up grid grid-cols-1 lg:grid-cols-2">

        <!-- Left Branding Section -->
        <div class="hidden lg:flex relative min-h-[620px] items-center overflow-hidden">
            <img src="{{ asset('images/promosi/logo new.webp') }}"
                 alt="Kita Kaktus"
                 class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-br from-green-950/80 via-green-900/65 to-black/75"></div>

            <div class="relative z-10 px-10 xl:px-14 text-white">
                <div class="mb-10">
                    <h1 class="text-2xl font-extrabold leading-tight">
                        Kita Kaktus
                    </h1>
                    <p class="text-sm text-green-100">
                        Cactus E-commerce
                    </p>
                </div>

                <div class="max-w-md">
                    <h2 class="text-4xl xl:text-5xl font-extrabold leading-tight mb-5">
                        Temukan Koleksi Kaktus Terbaik
                    </h2>

                    <p class="text-base xl:text-lg text-gray-100 leading-relaxed">
                        Belanja berbagai pilihan kaktus cantik, unik, dan berkualitas untuk memperindah rumah, meja kerja, atau hadiah spesial.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Login Section -->
        <div class="relative flex items-center justify-center px-5 py-10 sm:px-10 lg:px-14 min-h-[620px] bg-white dark:bg-gray-800">
            <div class="absolute top-8 right-8 hidden sm:block">
                <div class="w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 blur-2xl"></div>
            </div>

            <div class="absolute bottom-8 left-8 hidden sm:block">
                <div class="w-24 h-24 rounded-full bg-yellow-100 dark:bg-yellow-900/20 blur-2xl"></div>
            </div>

            <div class="w-full max-w-md relative z-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white">
                        Selamat Datang
                    </h2>

                    <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
                        Lanjutkan perjalanan hijau Anda bersama Kita Kaktus.
                    </p>
                </div>

                <form method="POST"
                      action="{{ secure_url('/login') }}"
                      class="space-y-5">
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
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            Email Address
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 text-sm"></i>
                            </div>

                            <input id="email"
                                   name="email"
                                   type="email"
                                   autocomplete="email"
                                   required
                                   value="{{ old('email') }}"
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 pl-11 pr-4 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:border-green-600 focus:ring-green-600 focus:outline-none focus:ring-2 transition-all duration-200 text-sm"
                                   placeholder="Masukkan Email Anda">
                        </div>

                        @error('email')
                            <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400 animate-shake">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Password
                            </label>

                            <a href="{{ route('password.request') }}"
                               class="text-xs sm:text-sm font-semibold text-green-700 dark:text-green-500 hover:text-green-600 hover:underline">
                                Lupa Password?
                            </a>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400 text-sm"></i>
                            </div>

                            <input id="password"
                                   name="password"
                                   type="password"
                                   autocomplete="current-password"
                                   required
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 pl-11 pr-11 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:border-green-600 focus:ring-green-600 focus:outline-none focus:ring-2 transition-all duration-200 text-sm"
                                   placeholder="Masukkan Password">

                            <button type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <i id="eyeIcon" class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-sm"></i>
                            </button>
                        </div>

                        @error('password')
                            <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400 animate-shake">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="remember"
                               name="remember"
                               type="checkbox"
                               value="1"
                               {{ old('remember') ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-green-600">

                        <label for="remember"
                               class="ml-2 block text-xs sm:text-sm text-gray-600 dark:text-gray-300 cursor-pointer">
                            Ingat saya untuk login berikutnya
                        </label>
                    </div>

                    <button type="submit"
                            class="group relative w-full flex items-center justify-center gap-2 py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-green-800 hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 transform transition-all duration-300 hover:scale-[1.01] active:scale-95 shadow-lg">
                        Masuk
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform duration-200"></i>
                    </button>

                    <div class="relative flex items-center justify-center my-5">
                        <div class="absolute left-0 w-full border-t border-gray-300 dark:border-gray-600"></div>
                        <span class="relative px-4 bg-white dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 font-semibold">
                            ATAU
                        </span>
                    </div>

                    <a href="{{ route('google.login') }}"
                       style="position: relative; z-index: 99999; cursor: pointer; display: flex;"
                       class="w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm text-sm font-semibold">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                             alt="Google"
                             style="width: 18px !important; height: 18px !important; max-width: 18px !important;">

                        <span>Masuk dengan Google</span>
                    </a>

                    <div class="text-center pt-3 relative z-10">
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                               class="relative z-20 inline-flex items-center font-bold text-green-700 dark:text-green-500 hover:text-green-600 transition-colors duration-200 hover:underline text-xs sm:text-sm">
                                Daftar Sekarang
                            </a>
                        </p>
                    </div>
                </form>

                <p class="mt-10 text-center text-xs text-gray-500 dark:text-gray-400">
                    Kita Kaktus © {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>
@endpush
@endsection