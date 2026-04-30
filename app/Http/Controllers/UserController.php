<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
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
        $product->load('category');
        return view('product.detail', compact('product'));
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
}