<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PaymentController;
//use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

use App\Http\Controllers\Vendor\Auth\LoginController as VendorLoginController;
use App\Http\Controllers\Vendor\Auth\EmployeeLoginController;

use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\SenangPayController;
use App\Http\Controllers\PaymobController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\PaytabsController;
use App\Http\Controllers\BkashPaymentController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\LiqPayController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DeliveryManController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= HOME & STATIC PAGES =================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('terms-and-conditions', [HomeController::class, 'terms_and_conditions'])->name('terms-and-conditions');
Route::get('about-us', [HomeController::class, 'about_us'])->name('about-us');
Route::get('contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
Route::get('privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');

// ================= NEWSLETTER =================
Route::post('newsletter/subscribe', [NewsletterController::class, 'newsLetterSubscribe'])
    ->name('newsletter.subscribe');

// ================= AUTH =================

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('admin/login', [AdminLoginController::class, 'login'])
    ->name('admin.login');

Route::post('admin/login', [AdminLoginController::class, 'submit'])
    ->name('admin.login.submit');

Route::get('vendor-panel/auth/login', [VendorLoginController::class, 'login'])
    ->name('vendor.auth.login');

Route::post('vendor-panel/auth/login', [VendorLoginController::class, 'submit']);


// ================= AUTH FAILED =================
Route::get('authentication-failed', function () {
    return response()->json([
        'errors' => [
            ['code' => 'auth-001', 'message' => 'Unauthenticated.']
        ]
    ], 401);
})->name('authentication-failed');

// ================= Admin Dashboard file Vendor-view POS order =================
use App\Http\Controllers\Vendor\OrderController;

Route::post('/vendor/orders/add-delivery-man',
    [OrderController::class, 'addDeliveryMan']
)->name('vendor.orders.add-delivery-man');


// ================= PAYMENT MOBILE =================
Route::prefix('payment-mobile')->group(function () {
    Route::get('/', [PaymentController::class, 'payment'])->name('payment-mobile');
    Route::get('set-payment-method/{name}', [PaymentController::class, 'set_payment_method'])
        ->name('set-payment-method');
});

// ================= SSLCOMMERZ =================
Route::post('pay-ssl', [SslCommerzPaymentController::class, 'index']);
Route::post('success', [SslCommerzPaymentController::class, 'success']);
Route::post('fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('ipn', [SslCommerzPaymentController::class, 'ipn']);

// ================= PAYPAL =================
Route::post('pay-paypal', [PaypalPaymentController::class, 'payWithpaypal'])->name('pay-paypal');
Route::get('paypal-status', [PaypalPaymentController::class, 'getPaymentStatus'])->name('paypal-status');

// ================= STRIPE =================
Route::get('pay-stripe', [StripePaymentController::class, 'payment_process_3d'])->name('pay-stripe');
Route::get('pay-stripe/success', [StripePaymentController::class, 'success'])->name('pay-stripe.success');
Route::get('pay-stripe/fail', [StripePaymentController::class, 'fail'])->name('pay-stripe.fail');

// ================= RAZORPAY =================
Route::get('paywithrazorpay', [RazorPayController::class, 'payWithRazorpay'])->name('paywithrazorpay');
Route::post('payment-razor/{order_id}', [RazorPayController::class, 'payment'])->name('payment-razor');

// ================= PAYMENT RESULT =================
Route::get('payment-success', [PaymentController::class, 'success'])->name('payment-success');
Route::get('payment-fail', [PaymentController::class, 'fail'])->name('payment-fail');

// ================= SENANG PAY =================
Route::match(
    ['get', 'post'],
    'return-senang-pay',
    [SenangPayController::class, 'return_senang_pay']
)->name('return-senang-pay');

// ================= PAYMOB =================
Route::post('paymob-credit', [PaymobController::class, 'credit'])->name('paymob-credit');
Route::get('paymob-callback', [PaymobController::class, 'callback'])->name('paymob-callback');

// ================= PAYSTACK =================
Route::post('paystack-pay', [PaystackController::class, 'redirectToGateway'])->name('paystack-pay');
Route::get('paystack-callback', [PaystackController::class, 'handleGatewayCallback'])->name('paystack-callback');
Route::get('paystack', function () {
    return view('paystack');
});

// ================= FLUTTERWAVE =================
Route::post('flutterwave-pay', [FlutterwaveController::class, 'initialize'])->name('flutterwave_pay');
Route::get('rave/callback', [FlutterwaveController::class, 'callback'])->name('flutterwave_callback');

// ================= MERCADOPAGO =================
Route::get('mercadopago/home', [MercadoPagoController::class, 'index'])->name('mercadopago.index');
Route::post('mercadopago/make-payment', [MercadoPagoController::class, 'make_payment'])
    ->name('mercadopago.make_payment');
Route::get('mercadopago/get-user', [MercadoPagoController::class, 'get_test_user'])
    ->name('mercadopago.get-user');

// ================= PAYTABS =================
Route::any('paytabs-payment', [PaytabsController::class, 'payment'])->name('paytabs-payment');
Route::any('paytabs-response', [PaytabsController::class, 'callback_response'])->name('paytabs-response');

// ================= BKASH =================
Route::prefix('bkash')->group(function () {
    Route::post('get-token', [BkashPaymentController::class, 'getToken'])->name('bkash-get-token');
    Route::post('create-payment', [BkashPaymentController::class, 'createPayment'])->name('bkash-create-payment');
    Route::post('execute-payment', [BkashPaymentController::class, 'executePayment'])->name('bkash-execute-payment');
    Route::get('query-payment', [BkashPaymentController::class, 'queryPayment'])->name('bkash-query-payment');
    Route::post('success', [BkashPaymentController::class, 'bkashSuccess'])->name('bkash-success');
});

// ================= PAYTM =================
Route::get('paytm-payment', [PaytmController::class, 'payment'])->name('paytm-payment');
Route::any('paytm-response', [PaytmController::class, 'callback'])->name('paytm-response');

// ================= LIQPAY =================
Route::get('liqpay-payment', [LiqPayController::class, 'payment'])->name('liqpay-payment');
Route::any('liqpay-callback', [LiqPayController::class, 'callback'])->name('liqpay-callback');

// ================= TEST =================
Route::get('test', function () {
    return 'Hello tester';
});

// ================= STORE REGISTRATION =================
Route::prefix('store')->name('restaurant.')->group(function () {
    Route::get('apply', [VendorController::class, 'create'])->name('create');
    Route::post('apply', [VendorController::class, 'store'])->name('store');
});

// ================= DELIVERYMAN REGISTRATION =================
Route::prefix('deliveryman')->name('deliveryman.')->group(function () {
    Route::get('apply', [DeliveryManController::class, 'create'])->name('create');
    Route::post('apply', [DeliveryManController::class, 'store'])->name('store');
});


Route::group(['prefix' => 'admin'], function () {
    require base_path('routes/admin.php');
});
