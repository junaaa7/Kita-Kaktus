@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Pengaturan Akun</h1>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 mb-4 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-6">
        <!-- Alamat Saya -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                Alamat Saya
            </h2>
            
            <form action="{{ route('profile.update.address') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nomor Telepon/WA</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="Contoh: 081234567890">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">* Diisi dengan angka (10-15 digit)</p>
                </div>
                
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                </div>
                
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i> Simpan Alamat
                </button>
            </form>
        </div>

        <!-- Keamanan dan Akun -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <i class="fas fa-lock text-green-500 mr-2"></i>
                Keamanan dan Akun
            </h2>
            
            <!-- Profil Saya -->
            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-user-circle text-green-500 mr-2"></i>
                    Profil Saya
                </h3>
                
                <form action="{{ route('profile.update.profile') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-2xl text-green-600 dark:text-green-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Foto Profil</label>
                            <input type="file" name="avatar" accept="image/*" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Format: JPG, PNG. Max: 2MB</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Username</label>
                        <input type="text" value="{{ $user->name }}" disabled 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i> Simpan Profil
                    </button>
                </form>
            </div>
            
            <!-- Ganti Password -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-key text-green-500 mr-2"></i>
                    Ganti Password
                </h3>
                
                <form action="{{ route('profile.update.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimal 8 karakter</p>
                        @error('new_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password_confirmation" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-key mr-2"></i> Ganti Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection