<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Frontend\HomeController;
use App\Http\Controllers\Api\Frontend\ShopController;
use App\Http\Controllers\Api\Frontend\TagProductController;
use App\Http\Controllers\Api\Frontend\ProductController;
use App\Http\Controllers\Api\Frontend\ApiTicketController;
use App\Http\Controllers\Api\Frontend\CartController;
use App\Http\Controllers\Api\Frontend\ApiAuthController;
use App\Http\Controllers\Api\Frontend\ApiProfileController;
use App\Http\Controllers\Api\Frontend\CheckoutController;
use App\Http\Controllers\Api\Frontend\ConditionalMoneyReceiverController;
use App\Http\Controllers\Api\Frontend\ConfigurationController;
use App\Http\Controllers\Api\Frontend\OrderController;
use App\Http\Controllers\Api\Frontend\PaymentMethodController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'frontend', 'as' => 'api.frontend.'], function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
    Route::get('/tag-product/{tagSlug}', [TagProductController::class, 'tagProduct'])->name('tagProduct');
    Route::get('/single-product/{productSlug}', [ProductController::class, 'singleProduct'])->name('singleProduct');
    Route::get('/category-product/{categorySlug}', [ProductController::class, 'categoryProduct'])->name('categoryProduct');
    Route::get('/ticket-response/{token}', [ApiTicketController::class, 'ticketResponse'])->name('ticket-response');
    Route::post('/ticket-response-action/{token}', [ApiTicketController::class, 'ticketResponseAction'])->name('ticketResponseAction');
    Route::post('/ticketStore', [ApiTicketController::class, 'ticketStore'])->name('ticketStore');
    Route::get('/ticket-close/{token}', [ApiTicketController::class, 'ticketClose'])->name('ticketClose');
    //Cart
    Route::post('/cart-products', [CartController::class, 'cartProducts'])->name('cart.products');
    //configuration
    Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration');
    //checkout
    Route::post('/checkout-product-info-template-render', [CheckoutController::class, 'checkoutProductInfo'])->name('checkout.product.info.render');
    Route::post('/order-store', [CheckoutController::class, 'orderStore'])->name('order.store');
    //ordder
    Route::apiResource('orders', OrderController::class);
    //payment method
    Route::get('/active-payment-methods', [PaymentMethodController::class, 'getActivePaymentMethods'])->name('active.payment.method');
    Route::get('/payment-method/{id}', [PaymentMethodController::class, 'getPaymentMethodById'])->name('single.payment.method');
    //conditinal money receiver
    Route::get('/condition-money-receiver-alive', [ConditionalMoneyReceiverController::class, 'conditionalMoneyReceiverAlive'])->name('condition.receiver.alive');
    //Auth
    Route::get('/email-existence/{email}', [ApiAuthController::class, 'emailExistence'])->name('emailExistence');
    Route::post('/registration-store', [ApiAuthController::class, 'registrationStore'])->name('registrationStore');
    Route::get('/account-verification/{token}', [ApiAuthController::class, 'accountVarification'])->name('accountVarification');
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [ApiAuthController::class, 'me'])->name('me');
        Route::get('/profile/{auth_id}', [ApiProfileController::class, 'profile'])->name('profile');
        Route::get('/add_shipping_details/{auth_id}', [ApiProfileController::class, 'add_shipping_details'])->name('add_shipping_details');
        Route::post('/store_shipping_details/{user_id}', [ApiProfileController::class, 'store_shipping_details'])->name('store_shipping_details');
        Route::get('/ticket_history/{user_id}', [ApiTicketController::class, 'ticket_history'])->name('ticket_history');
    });

});
