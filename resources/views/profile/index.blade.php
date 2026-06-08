@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-6 flex items-center">
        <i class="fas fa-user-cog text-green-500 mr-2 text-lg sm:text-xl"></i>
        Pengaturan Akun
    </h1>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-3 mb-4 rounded-lg text-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-3 mb-4 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-4 sm:space-y-6">
        
        <!-- ALAMAT SAYA - Card dengan Tombol Tambah -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-base sm:text-lg font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                    Alamat Saya
                </h2>
                <button onclick="document.getElementById('addAddressModal').classList.remove('hidden')" 
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm transition flex items-center gap-1">
                    <i class="fas fa-plus text-xs"></i>
                    <span>Tambah</span>
                </button>
            </div>
            
            <div class="p-4 space-y-3">
                @forelse($addresses as $addr)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 {{ $addr->is_default ? 'bg-green-50 dark:bg-green-900/20 border-green-500' : '' }}">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="font-semibold text-sm text-gray-800 dark:text-white">
                                    <i class="fas fa-tag text-green-500 mr-1 text-xs"></i>
                                    {{ $addr->label }}
                                </span>
                                @if($addr->is_default)
                                    <span class="text-xs bg-green-500 text-white px-2 py-0.5 rounded-full">Utama</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">
                                <i class="fas fa-user mr-1 text-gray-400 text-xs w-4"></i>
                                {{ $addr->recipient_name }}
                            </p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">
                                <i class="fas fa-phone mr-1 text-gray-400 text-xs w-4"></i>
                                {{ $addr->phone }}
                            </p>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                <i class="fas fa-location-dot mr-1 text-gray-400 text-xs w-4"></i>
                                {{ Str::limit($addr->address, 60) }}
                            </p>
                            @if($addr->city)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-city mr-1"></i> {{ $addr->city }}
                                    @if($addr->postal_code) - {{ $addr->postal_code }} @endif
                                </p>
                            @endif
                        </div>
                        <div class="flex gap-2 justify-end sm:justify-start">
                            @if(!$addr->is_default)
                                <form action="{{ route('profile.address.set-default', $addr) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700 text-xs sm:text-sm">
                                        <i class="fas fa-check-circle"></i> Utama
                                    </button>
                                </form>
                            @endif
                            <button onclick="editAddress({{ $addr->id }})" class="text-yellow-500 hover:text-yellow-700 text-xs sm:text-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('profile.address.delete', $addr) }}" method="POST" class="inline" onsubmit="return confirm('Hapus alamat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs sm:text-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6">
                    <i class="fas fa-map-marker-alt text-4xl text-gray-400 mb-2 block"></i>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada alamat. Silakan tambah alamat baru.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- KEAMANAN DAN AKUN -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-base sm:text-lg font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-lock text-green-500 mr-2"></i>
                    Keamanan dan Akun
                </h2>
            </div>
            
            <div class="p-4">
                <!-- Profil Saya -->
                <div class="mb-5 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                        <i class="fas fa-user-circle text-green-500 mr-2"></i>
                        Profil Saya
                    </h3>
                    
                    <form id="profileForm" action="{{ route('profile.update.profile') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        @method('PUT')
                        
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                @if($user->avatar)
                                    @if(Str::startsWith($user->avatar, ['http://', 'https://']))
                                        <img id="avatarPreview" src="{{ $user->avatar }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                    @elseif(Str::startsWith($user->avatar, 'uploads/'))
                                        <img id="avatarPreview" src="{{ asset($user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                    @else
                                        <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                    @endif
                                @else
                                    <div id="avatarPlaceholder" class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center border-2 border-gray-300 dark:border-gray-600">
                                        <i class="fas fa-user text-2xl text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <img id="avatarPreview" src="" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 hidden">
                                @endif
                            </div>

                            <div class="flex-1">
                                <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold mb-1">Foto Profil</label>

                                <input type="file" id="avatarInput" accept="image/*" class="w-full text-sm">
                                <input type="file" id="avatarWebpInput" name="avatar" class="hidden">

                                <p id="avatarInfo" class="text-xs text-gray-500 mt-1">
                                    JPG, PNG, WEBP. Otomatis menjadi 500×500 WEBP. Max 2MB
                                </p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <button type="submit" id="saveProfileBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-save mr-1"></i> Simpan Profil
                        </button>
                    </form>
                </div>
                
                <!-- Ganti Password -->
                <div>
                    <h3 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                        <i class="fas fa-key text-green-500 mr-2"></i>
                        Ganti Password
                    </h3>
                    
                    <form action="{{ route('profile.update.password') }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold mb-1">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password" required 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white pr-10">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400 text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold mb-1">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="new_password" required 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white pr-10">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400 text-sm"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold mb-1">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input type="password" name="new_password_confirmation" required 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white pr-10">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                    <i class="fas fa-eye text-gray-400 text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-key mr-1"></i> Ganti Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Alamat -->
<div id="addAddressModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-800 p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Tambah Alamat Baru</h3>
            <button onclick="document.getElementById('addAddressModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="p-4">
            <form action="{{ route('profile.address.add') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Label Alamat</label>
                    <select name="label" required class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                        <option value="Rumah">🏠 Rumah</option>
                        <option value="Kantor">💼 Kantor</option>
                        <option value="Kost">🏢 Kost</option>
                        <option value="Lainnya">📍 Lainnya</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Nama Penerima</label>
                    <input type="text" name="recipient_name" required placeholder="Nama lengkap penerima"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                </div>
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Nomor Telepon</label>
                    <input type="tel" name="phone" required placeholder="Contoh: 081234567890"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                </div>
                
                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"
                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Kota</label>
                        <input type="text" name="city" placeholder="Kota/Kabupaten"
                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" placeholder="Kode pos"
                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
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
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg text-sm transition">Batal</button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
    
    function editAddress(id) {
        alert('Fitur edit alamat akan segera hadir');
    }

    const profileForm = document.getElementById('profileForm');
    const avatarInput = document.getElementById('avatarInput');
    const avatarWebpInput = document.getElementById('avatarWebpInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarPlaceholder = document.getElementById('avatarPlaceholder');
    const avatarInfo = document.getElementById('avatarInfo');
    const saveProfileBtn = document.getElementById('saveProfileBtn');

    let avatarIsProcessing = false;
    let avatarIsReady = false;

    function setAvatarInfo(message, type = 'normal') {
        if (!avatarInfo) return;

        avatarInfo.innerText = message;
        avatarInfo.classList.remove('text-gray-500', 'text-green-500', 'text-red-500', 'text-yellow-500');

        if (type === 'success') {
            avatarInfo.classList.add('text-green-500');
        } else if (type === 'error') {
            avatarInfo.classList.add('text-red-500');
        } else if (type === 'warning') {
            avatarInfo.classList.add('text-yellow-500');
        } else {
            avatarInfo.classList.add('text-gray-500');
        }
    }

    function setProfileButtonLoading(isLoading) {
        if (!saveProfileBtn) return;

        if (isLoading) {
            saveProfileBtn.disabled = true;
            saveProfileBtn.classList.add('opacity-60', 'cursor-not-allowed');
            saveProfileBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memproses Foto...';
        } else {
            saveProfileBtn.disabled = false;
            saveProfileBtn.classList.remove('opacity-60', 'cursor-not-allowed');
            saveProfileBtn.innerHTML = '<i class="fas fa-save mr-1"></i> Simpan Profil';
        }
    }

    if (avatarInput && avatarWebpInput) {
        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            avatarIsReady = false;
            avatarWebpInput.value = '';

            if (!file) {
                setAvatarInfo('JPG, PNG, WEBP. Otomatis menjadi 500×500 WEBP. Max 2MB');
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                avatarInput.value = '';
                avatarWebpInput.value = '';
                setAvatarInfo('File harus berupa gambar.', 'error');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran gambar maksimal 2MB.');
                avatarInput.value = '';
                avatarWebpInput.value = '';
                setAvatarInfo('Ukuran gambar maksimal 2MB.', 'error');
                return;
            }

            avatarIsProcessing = true;
            setProfileButtonLoading(true);
            setAvatarInfo('Memproses foto menjadi 500×500 WEBP...', 'warning');

            const img = new Image();
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
            };

            img.onload = function() {
                const canvas = document.createElement('canvas');
                const size = 500;

                canvas.width = size;
                canvas.height = size;

                const ctx = canvas.getContext('2d');

                if (!ctx) {
                    alert('Browser tidak mendukung pemrosesan gambar.');
                    avatarIsProcessing = false;
                    setProfileButtonLoading(false);
                    setAvatarInfo('Browser tidak mendukung pemrosesan gambar.', 'error');
                    return;
                }

                const minSide = Math.min(img.width, img.height);
                const sx = (img.width - minSide) / 2;
                const sy = (img.height - minSide) / 2;

                ctx.drawImage(img, sx, sy, minSide, minSide, 0, 0, size, size);

                canvas.toBlob(function(blob) {
                    if (!blob) {
                        alert('Gagal memproses gambar menjadi WEBP.');
                        avatarIsProcessing = false;
                        setProfileButtonLoading(false);
                        setAvatarInfo('Gagal memproses gambar menjadi WEBP.', 'error');
                        return;
                    }

                    const webpFile = new File(
                        [blob],
                        'avatar_' + Date.now() + '.webp',
                        { type: 'image/webp' }
                    );

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(webpFile);
                    avatarWebpInput.files = dataTransfer.files;

                    if (avatarPreview) {
                        avatarPreview.src = URL.createObjectURL(blob);
                        avatarPreview.classList.remove('hidden');
                    }

                    if (avatarPlaceholder) {
                        avatarPlaceholder.classList.add('hidden');
                    }

                    avatarIsProcessing = false;
                    avatarIsReady = true;
                    setProfileButtonLoading(false);
                    setAvatarInfo('Foto siap diupload: 500×500 WEBP.', 'success');
                }, 'image/webp', 0.85);
            };

            img.onerror = function() {
                alert('Gagal membaca gambar. Coba gunakan file JPG, PNG, atau WEBP lain.');
                avatarInput.value = '';
                avatarWebpInput.value = '';
                avatarIsProcessing = false;
                setProfileButtonLoading(false);
                setAvatarInfo('Gagal membaca gambar.', 'error');
            };

            reader.readAsDataURL(file);
        });
    }

    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            if (avatarInput && avatarInput.files.length > 0) {
                if (avatarIsProcessing || !avatarIsReady || avatarWebpInput.files.length === 0) {
                    e.preventDefault();
                    alert('Foto sedang diproses menjadi WEBP 500×500. Tunggu sebentar lalu klik Simpan Profil lagi.');
                }
            }
        });
    }
</script>
@endsection