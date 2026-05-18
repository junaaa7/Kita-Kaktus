<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $cart = [];

        foreach ($cartItems as $item) {
            $cart[$item->product_id] = [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'image' => $item->product->image,
            ];
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $isSelectedCheckout = false;

        return view('checkout.index', compact('cart', 'total', 'isSelectedCheckout'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'phone' => 'required|digits_between:10,15',
            'payment_method' => 'required|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        return $this->createOrder($request, $cartItems, false);
    }

    public function processSelected(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'required|integer',
        ]);

        session([
            'selected_checkout_items' => $request->selected_items
        ]);

        return redirect()->route('checkout.selected.index');
    }

    public function indexSelected()
    {
        $selectedItems = session('selected_checkout_items');

        if (!$selectedItems) {
            return redirect()->route('cart.index')
                ->with('error', 'Pilih produk terlebih dahulu.');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('product_id', $selectedItems)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        $cart = [];

        foreach ($cartItems as $item) {
            $cart[$item->product_id] = [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'image' => $item->product->image,
            ];
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $isSelectedCheckout = true;

        return view('checkout.index', compact('cart', 'total', 'isSelectedCheckout'));
    }

    public function processSelectedCheckout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'phone' => 'required|digits_between:10,15',
            'payment_method' => 'required|string',
        ]);

        $selectedItems = session('selected_checkout_items');

        if (!$selectedItems) {
            return redirect()->route('cart.index')
                ->with('error', 'Pilih produk terlebih dahulu.');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('product_id', $selectedItems)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        return $this->createOrder($request, $cartItems, true);
    }

    private function createOrder(Request $request, $cartItems, $isSelectedCheckout = false)
    {
        DB::beginTransaction();

        try {
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $order = Order::create([
                'order_number' => 'ORD-' . date('YmdHis') . '-' . Auth::id(),
                'user_id' => Auth::id(),
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            if ($isSelectedCheckout) {
                Cart::where('user_id', Auth::id())
                    ->whereIn('product_id', $cartItems->pluck('product_id'))
                    ->delete();

                session()->forget('selected_checkout_items');
            } else {
                Cart::where('user_id', Auth::id())->delete();
            }

            DB::commit();

            return redirect()->route('orders.detail', $order->id)
                ->with('success', 'Pesanan berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function uploadPaymentProof(Request $request, Order $order)
{
    if ($order->user_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $path = $request->file('payment_proof')->store('payment-proofs', 'public');

    $order->update([
        'payment_proof' => $path,

        // status pembayaran
        'payment_status' => 'paid',

        // status order
        'status' => 'processed',

        // waktu pembayaran
        'paid_at' => now(),
    ]);

    return back()->with(
        'success',
        'Bukti pembayaran berhasil diupload. Pesanan sedang diproses.'
    );
}
}