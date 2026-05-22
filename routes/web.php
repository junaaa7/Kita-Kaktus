<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;

// Public routes
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/product/{product}', [UserController::class, 'productDetail'])->name('product.detail');

// Collection routes
Route::get('/koleksi', [CollectionController::class, 'index'])->name('collection.index');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Google Auth Routes
    Route::get('/auth/google/login', [GoogleController::class, 'redirectToGoogleLogin'])->name('google.login');
    Route::get('/auth/google/register', [GoogleController::class, 'redirectToGoogleRegister'])->name('google.register');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/delete-selected', [CartController::class, 'deleteSelected'])->name('cart.delete.selected');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout-selected', [CheckoutController::class, 'processSelected'])->name('checkout.selected');
    Route::get('/checkout-selected', [CheckoutController::class, 'indexSelected'])->name('checkout.selected.index');
    Route::post('/checkout-selected/process', [CheckoutController::class, 'processSelectedCheckout'])->name('checkout.selected.process');
    Route::post('/upload-payment/{order}', [CheckoutController::class, 'uploadPaymentProof'])->name('upload.payment');

    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders.history');
    Route::get('/orders/{order}', [UserController::class, 'orderDetail'])->name('orders.detail');

    Route::post('/orders/{order}/rating', [UserController::class, 'submitRating'])->name('orders.rating');
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
    Route::get('/ratings', [OrderController::class, 'ratings'])->name('ratings.index');

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
});