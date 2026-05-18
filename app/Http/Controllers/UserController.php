<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        $products = Product::with('category')->latest()->paginate(12);
        return view('home', compact('products'));
    }

    public function productDetail(Product $product)
    {
        $product->load('category', 'ratings');
        $averageRating = $product->averageRating();
        $ratingCount = $product->ratingCount();
        return view('product.detail', compact('product', 'averageRating', 'ratingCount'));
    }

    public function orderHistory()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('orders.history', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load('items.product');
        return view('orders.detail', compact('order'));
    }
    
    public function submitRating(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
            'product_id' => 'required|exists:products,id'
        ]);
        
        // Cek apakah sudah pernah memberi rating untuk produk ini di order ini
        $existingRating = Rating::where('user_id', auth()->id())
                                ->where('product_id', $request->product_id)
                                ->where('order_id', $order->id)
                                ->first();
        
        if ($existingRating) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk produk ini.');
        }
        
        Rating::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);
        
        return redirect()->back()->with('success', 'Terima kasih atas rating dan review Anda!');
    }
}