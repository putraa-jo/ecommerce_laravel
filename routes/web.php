<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

//Guest route
Route::group(['middleware' => 'guest'], function() {
    Route::get('/', function() {
        return view('welcome');
    });

    Route::get('/register', [AuthController::class, 'register']) -> name('register');
    Route::post('/post-register', [AuthController::class, 'post_register']) -> name('post.register');

    Route::post('/post-login', [AuthController::class, 'login']);
})->middleware('guest');

// Admin Route
Route::group(['middleware' => 'admin'], function() {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Product Route
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product');

    Route::get('/admin-loglout', [AuthController::class, 'admin_logout'])->name('admin.logout');
})->middleware('admin');

// User Route
Route::group(['middleware' => 'web'], function() {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/user-loglout', [AuthController::class, 'user_logout'])->name('user.logout');
})->middleware('web');