<?php

use Beier\FilamentPages\Http\Controllers\FilamentPageController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebpayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Livewire\Payment;
use App\Http\Livewire\Checkout;
use App\Http\Livewire\ProductView;
use App\Http\Livewire\Shop\OrderSuccess;
use App\Models\Order;
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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeCookieRedirect', 'localeViewPath']
], function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/payment/{code}', Payment::class)->name('checkout.payment');
    Route::get('/webpay/redirect/{code}', [WebpayController::class, 'redirect'])->name('webpay.redirect');
    Route::get('/payment-success', [PaymentController::class, 'success'])->name('checkout.success');
    Route::get('/order-success/{order}', OrderSuccess::class)->name('order.success');
    Route::get('/payment-canceled', [PaymentController::class, 'canceled'])->name('checkout.cancel');


    Route::get('/product/{product}', ProductView::class)->name('product.view');
    Route::get('/checkout', Checkout::class)->name('shop.checkout');
    
    // Category and Product routes (unified)
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/products', [CategoryController::class, 'products'])->name('products.index');
    Route::get('/products/category/{category}', [CategoryController::class, 'category'])->name('products.category');

//    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'show'])->name('shop.checkout');

    Route::get('/order-confirmed/{tracking?}', function(?string $tracking = null){
        if(!$tracking){
            return redirect()->route('shop.index');
        }
        $order = Order::where('tracking_id', $tracking)->firstOrFail();
        return view('order.confirmed', compact('order'));
    })->name('order.confirmed');

    Route::get('/page/{filamentPage}', [FilamentPageController::class, 'show']);
    Route::get('/shop', [CategoryController::class, 'shop'])->name('shop.index');
    Route::get('/blog', fn () => view('blog.index'))->name('blog.index');
    Route::get('/blog/article', fn () => view('blog.view'))->name('blog.view');



    // All Auth Route here

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
        Route::get('/dashboard', function () {
            session()->flash('flash.banner', 'Get a huge discount of up to 80% on all items!');
            session()->flash('flash.bannerStyle', 'warning');
            return view('dashboard');
        })->name('dashboard');
    });



    require base_path('vendor/laravel/fortify/routes/routes.php');
    require base_path('vendor/laravel/jetstream/routes/livewire.php');
});
