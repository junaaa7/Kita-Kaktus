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
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
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
     * Admin hanya bisa edit user dengan role admin, tidak bisa edit customer
     */
    public function edit(User $user)
    {
        // Jika user yang akan diedit adalah customer, redirect ke halaman index
        if ($user->role === 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit data customer. Hanya admin yang dapat diedit.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     * Admin hanya bisa update user dengan role admin, tidak bisa update customer
     */
    public function update(Request $request, User $user)
    {
        // Jika user yang akan diupdate adalah customer, redirect ke halaman index
        if ($user->role === 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengupdate data customer. Hanya admin yang dapat diupdate.');
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

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil diupdate');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Cegah menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }
        
        // Cegah menghapus customer
        if ($user->role === 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun customer');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil dihapus');
    }
}