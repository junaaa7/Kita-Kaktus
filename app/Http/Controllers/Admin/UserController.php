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
        $totalUsers = User::whereIn('role', ['user', 'customer'])->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCustomers = User::whereIn('role', ['user', 'customer'])->count();
        
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
            'role' => 'required|in:admin,user,customer',
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
        $isCustomer = in_array($user->role, ['user', 'customer']);

        if ($currentUser->isSuperAdmin()) {
            if (
                $currentUser->id === $user->id ||
                ($user->role === 'admin' && !$user->isSuperAdmin()) ||
                $isCustomer
            ) {
                return view('admin.users.edit', compact('user'));
            }

            return redirect()->route('admin.users.index')->with('error', 'Admin utama hanya dapat mengedit dirinya sendiri, admin baru, dan customer.');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Admin baru tidak memiliki izin untuk mengedit Admin Utama.');
        }

        if ($user->role === 'admin' && !$user->isSuperAdmin() && $currentUser->id !== $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Admin baru tidak memiliki izin untuk mengedit admin lain.');
        }

        if ($currentUser->id === $user->id || $isCustomer) {
            return view('admin.users.edit', compact('user'));
        }

        return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk mengedit akun ini.');
    }

    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        $isCustomer = in_array($user->role, ['user', 'customer']);

        if ($currentUser->isSuperAdmin()) {
            if (
                $currentUser->id === $user->id ||
                ($user->role === 'admin' && !$user->isSuperAdmin()) ||
                $isCustomer
            ) {
                return $this->performUpdate($request, $user);
            }

            return redirect()->route('admin.users.index')->with('error', 'Admin utama hanya dapat mengupdate dirinya sendiri, admin baru, dan customer.');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Admin baru tidak memiliki izin untuk mengupdate Admin Utama.');
        }

        if ($user->role === 'admin' && !$user->isSuperAdmin() && $currentUser->id !== $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Admin baru tidak memiliki izin untuk mengupdate admin lain.');
        }

        if ($currentUser->id === $user->id || $isCustomer) {
            return $this->performUpdate($request, $user);
        }

        return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate akun ini.');
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
        
        if (auth()->user()->isSuperAdmin() && $request->has('role')) {
            $request->validate([
                'role' => 'required|in:admin,user,customer',
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
        $isCustomer = in_array($user->role, ['user', 'customer']);
        
        if ($currentUser->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Admin utama tidak dapat dihapus.');
        }

        if ($currentUser->isSuperAdmin()) {
            if ($user->role === 'admin' && !$user->isSuperAdmin()) {
                $user->delete();

                return redirect()->route('admin.users.index')->with('success', 'Admin baru berhasil dihapus');
            }

            if ($isCustomer) {
                $user->delete();

                return redirect()->route('admin.users.index')->with('success', 'Customer berhasil dihapus');
            }

            return redirect()->route('admin.users.index')->with('error', 'User tidak dapat dihapus.');
        }

        if ($currentUser->isAdmin() && !$currentUser->isSuperAdmin()) {
            if ($isCustomer) {
                $user->delete();

                return redirect()->route('admin.users.index')->with('success', 'Customer berhasil dihapus');
            }

            return redirect()->route('admin.users.index')->with('error', 'Admin baru hanya dapat menghapus customer.');
        }

        return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menghapus user.');
    }
}