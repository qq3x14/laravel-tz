<?php

use App\Http\Controllers\ShopCartsController;
use App\Http\Controllers\ShopOrdersController;
use App\Http\Controllers\ShopProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ShopProductsController::class, 'list'])->name('products.list');

Route::get('/cart', [ShopCartsController::class, 'show'])->name('cart.show');
Route::post('/cart', [ShopCartsController::class, 'add'])->name('cart.add');

Route::get('/orders', [ShopOrdersController::class, 'list'])->name('orders.list');
Route::get('/order/create', [ShopOrdersController::class, 'create'])->name('order.create');
Route::get('/order/{id}/delete', [ShopOrdersController::class, 'delete'])->name('order.delete')->where('id', '[0-9]+');
