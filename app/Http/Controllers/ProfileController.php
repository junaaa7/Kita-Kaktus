<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    // Menampilkan halaman setting/profile
    public function index()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', $user->id)->orderBy('is_default', 'desc')->get();
        return view('profile.index', compact('user', 'addresses'));
    }

    // Menambah alamat baru
    public function addAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'address' => 'required|string|max:1000',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        // Jika ini alamat pertama atau user memilih sebagai default
        $isFirstAddress = Address::where('user_id', auth()->id())->count() == 0;
        $isDefault = $isFirstAddress || $request->has('is_default');

        $address = Address::create([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'is_default' => $isDefault
        ]);

        // Jika alamat ini dijadikan default, hapus default pada alamat lain
        if ($isDefault) {
            Address::where('user_id', auth()->id())
                   ->where('id', '!=', $address->id)
                   ->update(['is_default' => false]);
        }

        return redirect()->route('profile.index')->with('success', 'Alamat berhasil ditambahkan');
    }

    // Update alamat
    public function updateAddress(Request $request, Address $address)
    {
        // Pastikan alamat milik user yang login
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'address' => 'required|string|max:1000',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $address->update([
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ]);

        // Jika dijadikan default
        if ($request->has('is_default') && !$address->is_default) {
            Address::where('user_id', auth()->id())->update(['is_default' => false]);
            $address->is_default = true;
            $address->save();
        }

        return redirect()->route('profile.index')->with('success', 'Alamat berhasil diupdate');
    }

    // Hapus alamat
    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        // Cek jika ini alamat default dan masih ada alamat lain
        if ($address->is_default) {
            $anotherAddress = Address::where('user_id', auth()->id())
                                     ->where('id', '!=', $address->id)
                                     ->first();
            if ($anotherAddress) {
                $anotherAddress->is_default = true;
                $anotherAddress->save();
            }
        }

        $address->delete();

        return redirect()->route('profile.index')->with('success', 'Alamat berhasil dihapus');
    }

    // Set alamat sebagai default
    public function setDefaultAddress(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        Address::where('user_id', auth()->id())->update(['is_default' => false]);
        $address->is_default = true;
        $address->save();

        return redirect()->route('profile.index')->with('success', 'Alamat utama berhasil diubah');
    }

    // Update profil (nama, email, avatar)
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = 'avatars/avatar_' . $user->id . '_' . time() . '.webp';

            $image = Image::read($request->file('avatar'))
                ->cover(500, 500)
                ->toWebp(85);

            Storage::disk('public')->put($avatarPath, (string) $image);

            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diupdate');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah');
    }
}