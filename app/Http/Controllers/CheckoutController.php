<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Produk di keranjang sudah habis.');
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

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Produk yang dipilih sudah habis.');
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
            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if (!$product || $product->stock <= 0) {
                    DB::rollBack();
                    return back()->with('error', 'Produk ' . ($item->product->name ?? '') . ' sudah habis.');
                }

                if ($item->quantity > $product->stock) {
                    DB::rollBack();
                    return back()->with('error', 'Stok produk ' . $product->name . ' hanya tersisa ' . $product->stock . '.');
                }
            }

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
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $item->quantity);
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
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/payment-proofs');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            $order->update([
                'payment_proof' => 'uploads/payment-proofs/' . $filename,
                'payment_status' => 'paid',
                'status' => 'processed',
                'paid_at' => now(),
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Pesanan sedang diproses.');
    }
}