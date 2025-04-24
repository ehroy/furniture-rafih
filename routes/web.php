<?php

use App\Http\Controllers\JustOrangeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;
use Inertia\Inertia;
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


Route::get('/sitemap.xml', function () {
    $path = public_path('sitemap.xml');

    if (!file_exists($path)) {
        abort(404, 'Sitemap tidak ditemukan');
    }

    return Response::file($path, [
        'Content-Type' => 'application/xml',
        'Cache-Control' => 'public, max-age=3600', // Optional: Set cache headers
    ]);
});
Route::get('/login', function () {
    return redirect(route('filament.admin.auth.login'));
})->name('login');

Route::get('/', [JustOrangeController::class, 'index'])->name('justorange-default');
Route::get('/p/{page}', [JustOrangeController::class, 'getPage'])->name('page');
Route::get('/category', [JustOrangeController::class, 'getCategory'])->name('category');
Route::get('/products', [JustOrangeController::class, 'getProducts'])->name('products');
Route::get('/product/{slug}', [JustOrangeController::class, 'detailProduct'])->name('detail.product');
Route::get('/contact', [JustOrangeController::class, 'linker']);
Route::get('/rdr/{label}',[JustOrangeController::class , 'redirector']);
Route::get('/cart', [JustOrangeController::class , 'cart']);
Route::post('/cart', [JustOrangeController::class, 'checkout']);
Route::get('/cart/success/{order_number}', [JustOrangeController::class, 'checkoutSuccess'])->name('cart.success');
Route::get('/galery', [JustOrangeController::class, 'getGallery'])->name('galery');;

