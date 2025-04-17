<?php

use App\Http\Controllers\JustOrangeController;
use Illuminate\Support\Facades\Route;
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
    $sitemap = Sitemap::create();

    // Halaman statis
    // Produk (misalnya ambil dari database)
    foreach (\App\Models\Product::all() as $produk) {
        $sitemap->add(
            Url::create('/product/' . $produk->slug)
                ->setLastModificationDate($produk->updated_at)
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );
    }


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

