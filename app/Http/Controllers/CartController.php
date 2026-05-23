<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        
        $cart = [];
        foreach ($cartItems as $item) {
            if (!$item->product || $item->product->stock <= 0) {
                continue;
            }

            $cart[$item->product_id] = [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'image' => $item->product->image,
                'stock' => $item->product->stock,
            ];
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Stok produk habis.');
        }

        $cartItem = Cart::where('user_id', auth()->id())
                       ->where('product_id', $product->id)
                       ->first();
        
        if ($cartItem) {
            if ($cartItem->quantity >= $product->stock) {
                return redirect()->back()->with('error', 'Jumlah produk di keranjang sudah mencapai batas stok.');
            }

            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }
        
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $product = Product::find($request->id);

            if (!$product || $product->stock <= 0) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok produk habis.'
                    ]);
                }

                return redirect()->route('cart.index')->with('error', 'Stok produk habis.');
            }

            if ($request->quantity > $product->stock) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jumlah melebihi stok tersedia.'
                    ]);
                }

                return redirect()->route('cart.index')->with('error', 'Jumlah melebihi stok tersedia.');
            }

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

    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }
}