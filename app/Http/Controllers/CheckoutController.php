<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
    public function index()
    {
        // Cek apakah ada cart dari checkout terpilih
        $cart = session()->get('checkout_cart', session()->get('cart', []));
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('checkout.index', compact('cart', 'total'));
    }

    /**
     * Memproses checkout dari semua produk di keranjang
     */
    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'phone' => 'required|numeric|digits_between:10,15',
            'payment_method' => 'required|in:bank_transfer,cash,qris'
        ], [
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.numeric' => 'Nomor telepon harus berupa angka.',
            'phone.digits_between' => 'Nomor telepon harus terdiri dari 10-15 digit angka.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min' => 'Alamat pengiriman minimal 10 karakter.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        // Ambil cart dari checkout terpilih atau cart biasa
        $cart = session()->get('checkout_cart', session()->get('cart', []));
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong');
        }

        // Hitung total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Simpan ke database
        DB::beginTransaction();
        try {
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

            // Simpan item pesanan
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                
                // Hapus item dari cart asli
                $mainCart = session()->get('cart', []);
                if (isset($mainCart[$id])) {
                    unset($mainCart[$id]);
                    session()->put('cart', $mainCart);
                }
            }

            // Hapus checkout cart sementara
            session()->forget('checkout_cart');
            
            DB::commit();

            return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibuat! Silahkan lakukan pembayaran.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Memproses checkout hanya untuk produk yang dipilih
     */
    public function processSelected(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        
        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk yang ingin di-checkout terlebih dahulu!');
        }
        
        $cart = session()->get('cart', []);
        $selectedCart = [];
        
        foreach ($selectedItems as $itemId) {
            if (isset($cart[$itemId])) {
                $selectedCart[$itemId] = $cart[$itemId];
            }
        }
        
        if (empty($selectedCart)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih!');
        }
        
        // Simpan sementara ke session untuk checkout
        session()->put('checkout_cart', $selectedCart);
        
        return redirect()->route('checkout.index');
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadPaymentProof(Request $request, Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'Format gambar harus JPG, PNG, atau JPEG.',
            'payment_proof.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Hapus bukti lama jika ada
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }
            
            // Simpan bukti baru
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            $order->payment_proof = $proofPath;
            $order->payment_status = 'paid';
            $order->paid_at = now();
            $order->save();
        }

        return redirect()->route('orders.detail', $order)->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }
}