<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCustomers = User::where('role', 'user')->count();
        
        return view('admin.users.index', compact('users', 'totalUsers', 'totalAdmins', 'totalCustomers'));
    }

    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menambah user.');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menambah user.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_super_admin' => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $currentUser = auth()->user();

        // Admin Utama / Super Admin:
        // Bisa edit dirinya sendiri dan admin baru
        if ($currentUser->isSuperAdmin()) {
            if ($currentUser->id === $user->id || ($user->role === 'admin' && !$user->isSuperAdmin())) {
                return view('admin.users.edit', compact('user'));
            }

            return redirect()->route('admin.users.index')->with('error', 'Admin utama hanya dapat mengedit dirinya sendiri dan admin baru.');
        }

        // Admin baru tidak bisa edit Admin Utama
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Admin baru tidak memiliki izin untuk mengedit Admin Utama.');
        }

        // Admin baru hanya bisa edit dirinya sendiri
        if ($currentUser->id === $user->id) {
            return view('admin.users.edit', compact('user'));
        }

        return redirect()->route('admin.users.index')->with('error', 'Anda hanya dapat mengedit akun sendiri.');
    }

    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();

        // Admin Utama / Super Admin:
        // Bisa update dirinya sendiri dan admin baru
        if ($currentUser->isSuperAdmin()) {
            if ($currentUser->id === $user->id || ($user->role === 'admin' && !$user->isSuperAdmin())) {
                return $this->performUpdate($request, $user);
            }

            return redirect()->route('admin.users.index')->with('error', 'Admin utama hanya dapat mengupdate dirinya sendiri dan admin baru.');
        }

        // Admin baru tidak bisa update Admin Utama
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Admin baru tidak memiliki izin untuk mengupdate Admin Utama.');
        }

        // Admin baru hanya bisa update dirinya sendiri
        if ($currentUser->id === $user->id) {
            return $this->performUpdate($request, $user);
        }

        return redirect()->route('admin.users.index')->with('error', 'Anda hanya dapat mengupdate akun sendiri.');
    }
    
    private function performUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);

            $data['password'] = Hash::make($request->password);
        }
        
        // Hanya Super Admin yang bisa mengubah role
        // Tapi Super Admin tidak boleh menurunkan role dirinya sendiri
        if (auth()->user()->isSuperAdmin() && $request->has('role')) {
            $request->validate([
                'role' => 'required|in:admin,user',
            ]);

            if (auth()->id() !== $user->id) {
                $data['role'] = $request->role;
            }
        }
        
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $currentUser = auth()->user();
        
        // Tidak bisa menghapus diri sendiri
        if ($currentUser->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }
        
        // Hanya Admin Utama / Super Admin yang boleh menghapus
        if (!$currentUser->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Admin baru tidak memiliki izin untuk menghapus user.');
        }

        // Admin Utama hanya boleh hapus admin baru
        if ($user->role === 'admin' && !$user->isSuperAdmin()) {
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'Admin baru berhasil dihapus');
        }

        // Admin Utama tidak boleh hapus Admin Utama / Customer
        return redirect()->route('admin.users.index')->with('error', 'Admin utama hanya dapat menghapus admin baru.');
    }
}