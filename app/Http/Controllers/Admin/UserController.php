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
        // Hanya super admin yang bisa menambah user
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menambah user.');
        }
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Hanya super admin yang bisa menyimpan user baru
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
        // Cek izin edit
        if (!$this->canEditUser($user)) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk mengedit user ini.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Cek izin update
        if (!$this->canEditUser($user)) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate user ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        // Cek izin hapus
        if (!$this->canDeleteUser($user)) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menghapus user ini.');
        }

        $user->delete();
        
        $roleText = $user->role === 'admin' ? 'Admin' : 'Customer';
        return redirect()->route('admin.users.index')->with('success', $roleText . ' berhasil dihapus');
    }
    
    /**
     * Cek apakah user saat ini bisa mengedit target user
     */
    private function canEditUser($targetUser)
    {
        $currentUser = auth()->user();
        
        // Super admin bisa mengedit semua (kecuali dirinya sendiri? biarkan saja)
        if ($currentUser->isSuperAdmin()) {
            return true;
        }
        
        // Admin biasa tidak bisa mengedit super admin
        if ($targetUser->isSuperAdmin()) {
            return false;
        }
        
        // Admin biasa tidak bisa mengedit customer
        if ($targetUser->role === 'user') {
            return false;
        }
        
        // Admin biasa bisa mengedit admin biasa lainnya
        return true;
    }
    
    /**
     * Cek apakah user saat ini bisa menghapus target user
     */
    private function canDeleteUser($targetUser)
    {
        $currentUser = auth()->user();
        
        // Tidak bisa menghapus diri sendiri
        if ($currentUser->id === $targetUser->id) {
            return false;
        }
        
        // Super admin bisa menghapus semua (kecuali diri sendiri)
        if ($currentUser->isSuperAdmin()) {
            return true;
        }
        
        // Admin biasa tidak bisa menghapus super admin
        if ($targetUser->isSuperAdmin()) {
            return false;
        }
        
        // Admin biasa tidak bisa menghapus admin lain
        if ($targetUser->role === 'admin') {
            return false;
        }
        
        // Admin biasa bisa menghapus customer
        return $targetUser->role === 'user';
    }
}