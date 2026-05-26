@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen User</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola semua user yang terdaftar di aplikasi</p>
        </div>
        @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.users.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        @endif
    </div>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total User</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalUsers }}</p>
            </div>
            <i class="fas fa-users text-3xl text-blue-600"></i>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Admin</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalAdmins }}</p>
            </div>
            <i class="fas fa-user-shield text-3xl text-yellow-600"></i>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Customer</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalCustomers }}</p>
            </div>
            <i class="fas fa-user text-3xl text-green-600"></i>
        </div>
    </div>
</div>

<!-- Tabel User -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal Daftar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($users as $index => $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $users->firstItem() + $index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                @if($user->isSuperAdmin())
                                    <span class="text-xs bg-yellow-500 text-white px-1.5 py-0.5 rounded-full">🌟 Super Admin</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->role == 'admin')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <i class="fas fa-user-shield mr-1"></i> Admin
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <i class="fas fa-user mr-1"></i> Customer
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-2">
                            <!-- Tombol Detail -->
                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <!-- Tombol Edit -->
                            @if(auth()->user()->isSuperAdmin())
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:text-green-800 dark:text-green-400" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @elseif($user->role == 'admin' && !$user->isSuperAdmin() && auth()->user()->id !== $user->id)
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:text-green-800 dark:text-green-400" title="Edit Admin">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @else
                                <span class="text-gray-400 cursor-not-allowed" title="Tidak dapat mengedit">
                                    <i class="fas fa-edit"></i>
                                </span>
                            @endif
                            
                            <!-- Tombol Hapus -->
                            @if($user->id !== auth()->id())
                                @if(auth()->user()->isSuperAdmin())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @elseif($user->role == 'user')
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus customer {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Hapus Customer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 cursor-not-allowed" title="Tidak dapat menghapus admin lain">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <i class="fas fa-users text-5xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">Belum ada user terdaftar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $users->links() }}
    </div>
</div>
@endsection