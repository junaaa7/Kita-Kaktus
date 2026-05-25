<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCustomers = User::where('role', 'user')->count();
        
        return view('admin.users.index', compact('users', 'totalUsers', 'totalAdmins', 'totalCustomers'));
    }

    /**
     * Show the form for creating a new user.
     * Hanya Super Admin yang bisa menambah user
     */
    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menambah user.');
        }
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     * Hanya Super Admin yang bisa menyimpan user baru
     */
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

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();
        
        // Super Admin bisa mengedit semua user (termasuk dirinya sendiri)
        if ($currentUser->isSuperAdmin()) {
            return view('admin.users.edit', compact('user'));
        }
        
        // Admin biasa tidak bisa mengedit Super Admin
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk mengedit Super Admin.');
        }
        
        // Admin biasa tidak bisa mengedit customer
        if ($user->role === 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit data customer.');
        }
        
        // Admin biasa bisa mengedit admin biasa lainnya
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        
        // Super Admin bisa mengupdate semua user
        if ($currentUser->isSuperAdmin()) {
            return $this->performUpdate($request, $user);
        }
        
        // Admin biasa tidak bisa mengupdate Super Admin
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate Super Admin.');
        }
        
        // Admin biasa tidak bisa mengupdate customer
        if ($user->role === 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengupdate data customer.');
        }
        
        return $this->performUpdate($request, $user);
    }
    
    /**
     * Perform the actual update
     */
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
        if (auth()->user()->isSuperAdmin() && $request->has('role')) {
            $request->validate([
                'role' => 'required|in:admin,user',
            ]);
            $data['role'] = $request->role;
        }
        
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();
        
        // Tidak bisa menghapus diri sendiri
        if ($currentUser->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }
        
        // Super Admin bisa menghapus semua (kecuali diri sendiri)
        if ($currentUser->isSuperAdmin()) {
            $roleText = $user->role === 'admin' ? 'Admin' : 'Customer';
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', $roleText . ' berhasil dihapus');
        }
        
        // Admin biasa tidak bisa menghapus Super Admin
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menghapus Super Admin.');
        }
        
        // Admin biasa tidak bisa menghapus admin lain
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus admin lain.');
        }
        
        // Admin biasa bisa menghapus customer
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Customer berhasil dihapus');
    }
}