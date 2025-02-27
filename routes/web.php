<?php

use App\Http\Controllers\JustOrangeController;
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
Route::get('/login', function () {
    return redirect(route('filament.admin.auth.login'));
})->name('login');

Route::get('/', [JustOrangeController::class, 'index']);
Route::get('/p/{page}', [JustOrangeController::class, 'getPage'])->name('page');
Route::get('/category', [JustOrangeController::class, 'getCategory'])->name('category');
Route::get('/products', [JustOrangeController::class, 'getProducts'])->name('products');
Route::get('/product/{slug}', [JustOrangeController::class, 'detailProduct'])->name('detail.product');
Route::get('/category/{id}', [JustOrangeController::class, 'getProductByCategory'])->name('products.category');
Route::get('/linker', [JustOrangeController::class, 'linker']);
Route::get('/rdr/{label}',[JustOrangeController::class , 'redirector']);
