<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'ratings');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diupdate');
    }

    public function confirmPayment(Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Pembayaran telah dikonfirmasi');
    }

    public function rejectPayment(Order $order)
    {
        $order->update([
            'payment_status' => 'failed'
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Pembayaran ditolak');
    }
    
    public function ratings()
    {
        $ratings = Rating::with(['user', 'product', 'order'])->latest()->paginate(10);
        return view('admin.ratings.index', compact('ratings'));
    }
}