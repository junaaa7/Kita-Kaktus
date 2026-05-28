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
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                    Alamat Saya
                </h2>
                <button onclick="document.getElementById('addAddressModal').classList.remove('hidden')" 
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-sm transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Alamat
                </button>
            </div>
            
            <!-- Daftar Alamat -->
            <div class="space-y-3">
                @forelse($addresses as $addr)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $addr->is_default ? 'bg-green-50 dark:bg-green-900/20 border-green-500' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-semibold text-gray-800 dark:text-white">{{ $addr->label }}</span>
                                @if($addr->is_default)
                                    <span class="text-xs bg-green-500 text-white px-2 py-0.5 rounded-full">Utama</span>
                                @endif
                            </div>
                            <p class="text-gray-700 dark:text-gray-300"><strong>Penerima:</strong> {{ $addr->recipient_name }}</p>
                            <p class="text-gray-700 dark:text-gray-300"><strong>Telepon:</strong> {{ $addr->phone }}</p>
                            <p class="text-gray-700 dark:text-gray-300"><strong>Alamat:</strong> {{ $addr->address }}</p>
                            @if($addr->city)
                                <p class="text-gray-700 dark:text-gray-300"><strong>Kota:</strong> {{ $addr->city }}</p>
                            @endif
                            @if($addr->postal_code)
                                <p class="text-gray-700 dark:text-gray-300"><strong>Kode Pos:</strong> {{ $addr->postal_code }}</p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            @if(!$addr->is_default)
                                <form action="{{ route('profile.address.set-default', $addr) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700 text-sm">
                                        <i class="fas fa-check-circle"></i> Jadikan Utama
                                    </button>
                                </form>
                            @endif
                            <button onclick="editAddress({{ $addr->id }})" class="text-yellow-500 hover:text-yellow-700 text-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('profile.address.delete', $addr) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada alamat. Silakan tambah alamat baru.</p>
                @endforelse
            </div>
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
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimal 8 karakter</p>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password_confirmation" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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

<!-- Modal Tambah Alamat -->
<div id="addAddressModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Tambah Alamat Baru</h3>
                <button onclick="document.getElementById('addAddressModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('profile.address.add') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Label Alamat</label>
                    <select name="label" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                        <option value="Rumah">🏠 Rumah</option>
                        <option value="Kantor">💼 Kantor</option>
                        <option value="Kost">🏢 Kost</option>
                        <option value="Lainnya">📍 Lainnya</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Nama Penerima</label>
                    <input type="text" name="recipient_name" required placeholder="Nama lengkap penerima"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                </div>
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Nomor Telepon</label>
                    <input type="tel" name="phone" required placeholder="Contoh: 081234567890"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                </div>
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Kota</label>
                        <input type="text" name="city" placeholder="Kota/Kabupaten"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" placeholder="Kode pos"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_default" value="1" class="mr-2 rounded border-gray-300 text-green-600">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Jadikan alamat utama</span>
                    </label>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('addAddressModal').classList.add('hidden')" 
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg transition">Batal</button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">Simpan</button>
                </div>
            </form>
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
    
    // Edit address function (akan diimplementasikan nanti)
    function editAddress(id) {
        alert('Fitur edit alamat akan segera hadir');
    }
</script>
@endsection