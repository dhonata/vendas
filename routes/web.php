<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::get('/product/new', [App\Http\Controllers\ProductController::class, 'create'])->name('product.new');
Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::get('/product/show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::delete('/product/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');

Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders');
Route::get('/order/new', [App\Http\Controllers\OrderController::class, 'create'])->name('order.new');
Route::post('/order/store', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
Route::get('/order/show/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
Route::get('/order/edit/{id}', [App\Http\Controllers\OrderController::class, 'edit'])->name('order.edit');
Route::put('/order/update/{id}', [App\Http\Controllers\OrderController::class, 'update'])->name('order.update');
Route::delete('/order/destroy/{id}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('order.destroy');

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/user/new', [App\Http\Controllers\UserController::class, 'create'])->name('user.new');
Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::get('/user/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');
Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
