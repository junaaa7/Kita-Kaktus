<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;

// Public routes (dapat diakses tanpa login)
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/product/{product}', [UserController::class, 'productDetail'])->name('product.detail');

// Guest routes (hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User routes (hanya untuk yang sudah login)
Route::middleware(['auth'])->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/upload-payment/{order}', [CheckoutController::class, 'uploadPaymentProof'])->name('upload.payment');
    
    // Order history
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders.history');
    Route::get('/orders/{order}', [UserController::class, 'orderDetail'])->name('orders.detail');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
    Route::post('/orders/{order}/reject-payment', [OrderController::class, 'rejectPayment'])->name('orders.reject-payment');
    
    Route::get('/', function() {
        return redirect()->route('admin.dashboard');
    });
});