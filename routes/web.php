<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DistributorController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

//Guest route
Route::group(['middleware' => 'guest'], function() {
    Route::get('/', function() {
        return view('welcome');
    });

    Route::get('/registration.html', [AuthController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthController::class, 'post_register'])->name('post.register');

    Route::post('/post-login', [AuthController::class, 'login']);
});

// Admin Route
Route::group(['middleware' => 'admin'], function() {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Product Route
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('/admin/product/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');

    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');

    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    // Flash Sale Route
    Route::get('/flash-sale', [FlashSaleController::class, 'index'])->name('admin.flash-sale');
    Route::get('/flash-sale/create', [FlashSaleController::class, 'create'])->name('flash-sale.create');
    Route::post('/flash-sale/store', [FlashSaleController::class, 'store'])->name('flash-sale.store');

    Route::get('/flash-sale/edit/{id}', [FlashSaleController::class, 'edit'])->name('flash-sale.edit');
    Route::post('/flash-sale/update/{id}', [FlashSaleController::class, 'update'])->name('flash-sale.update');

    Route::delete('/flash-sale/delete/{id}', [FlashSaleController::class, 'delete'])->name('flash-sale.delete');

    // Distributor Route
    Route::get('/distributor', [DistributorController::class, 'index'])->name('admin.distributor');
    Route::get('/distributor/create', [DistributorController::class, 'create'])->name('distributor.create');
    Route::post('/distributor/store', [DistributorController::class, 'store'])->name('distributor.store');
    Route::get('/distributor/edit/{id}', [DistributorController::class, 'edit'])->name('distributor.edit');
    Route::post('/distributor/update/{id}', [DistributorController::class, 'update'])->name('distributor.update');
    Route::delete('/distributor/delete/{id}', [DistributorController::class, 'delete'])->name('distributor.delete');
    Route::post('/distributor/import', [DistributorController::class, 'import'])->name('distributor.import');
    Route::get('/distributor/export', [DistributorController::class, 'export'])->name('distributor.export');

    // Admin History Route
    Route::get('/history', [HistoryController::class, 'index'])->name('admin.history');
    Route::get('/history/detail/{id}', [HistoryController::class, 'detail'])->name('history.detail');

    Route::get('/admin-logout', [AuthController::class, 'admin_logout'])->name('admin.logout');
});

// User Route
Route::group(['middleware' => 'auth'], function() {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
    // Product route
    Route::get('/user/products/detail/{id}', [UserController::class, 'detail_product'])->name('user.detail.product');
    Route::get('/product/purchase/{productId}/{userId}', [UserController::class, 'purchase']);

    // Flash Sale purchase route
    Route::get('/product/purchase-flash/{flashSaleId}/{userId}', [UserController::class, 'purchase_flash']);

    // User History Route
    Route::get('/user/history/{id}', [UserController::class, 'history'])->name('user.history');
    Route::get('/user/history/detail/{id}', [UserController::class, 'detail_history'])->name('user.detail.history');

    Route::get('/user-logout', [AuthController::class, 'user_logout'])->name('user.logout');
});