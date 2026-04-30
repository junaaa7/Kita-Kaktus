<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'payment_method' => 'required|in:bank_transfer,cash,qris'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(6)) . time(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending'
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibuat! Silahkan lakukan pembayaran.');
    }

    public function uploadPaymentProof(Request $request, Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('payment_proof')) {
            // Hapus bukti bayar lama jika ada
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }
            
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            $order->payment_proof = $proofPath;
            $order->payment_status = 'paid';
            $order->paid_at = now();
            $order->save();
        }

        return redirect()->route('orders.detail', $order)->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }
}