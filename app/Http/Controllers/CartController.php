<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja
     */
    public function index()
    {
        // Ambil cart dari database berdasarkan user yang login
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        
        $cart = [];
        foreach ($cartItems as $item) {
            $cart[$item->product_id] = [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'image' => $item->product->image
            ];
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Menambahkan produk ke keranjang
     */
    public function add(Request $request, Product $product)
    {
        // Cek apakah produk sudah ada di cart
        $cartItem = Cart::where('user_id', auth()->id())
                       ->where('product_id', $product->id)
                       ->first();
        
        if ($cartItem) {
            // Update quantity jika sudah ada
            $cartItem->increment('quantity');
        } else {
            // Buat baru jika belum ada
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }
        
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    /**
     * Mengupdate jumlah produk di keranjang
     */
    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cartItem = Cart::where('user_id', auth()->id())
                           ->where('product_id', $request->id)
                           ->first();
            
            if ($cartItem) {
                $cartItem->update(['quantity' => $request->quantity]);
            }
            
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diupdate');
    }

    /**
     * Menghapus satu produk dari keranjang
     */
    public function remove(Request $request)
    {
        if ($request->id) {
            Cart::where('user_id', auth()->id())
               ->where('product_id', $request->id)
               ->delete();
        }
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Menghapus semua produk dari keranjang
     */
    public function clear()
{
    Cart::where('user_id', auth()->id())->delete();

    return redirect()->route('cart.index')
        ->with('success', 'Keranjang berhasil dikosongkan.');
}
}