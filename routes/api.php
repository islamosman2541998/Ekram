<?php

use App\Http\Controllers\Api\Management\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PaymentController;
use App\Http\Controllers\Site\ProfileCardsController;
use App\Http\Controllers\Api\Test\NotficationTestController;


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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'as' => 'api.'
], function () {
    // payment apis
    Route::any('payfort-intital', [PaymentController::class, 'authorizateResponse'])->name('payfort-intital');
    Route::any('payfort-purchase', [PaymentController::class, 'purchaseResponse'])->name('payfort-purchase');
    Route::any('payfort-purchase/product', [PaymentController::class, 'category_product']);
    Route::any('payfort-purchase/products', [PaymentController::class, 'category_products']);



    Route::any('payfort-respond-card', [ProfileCardsController::class, 'payfortrespondSaveCard'])->name('profile.cards.payfortrespondSaveCard'); // save card [update status 1]

    // Test Notfication
    Route::POST('notfication-whatsapp', [NotficationTestController::class, 'whatsapp']);
    Route::POST('notfication-sms', [NotficationTestController::class, 'sms']);
    Route::POST('notfication-email', [NotficationTestController::class, 'email']);


     // Start Api Management System --------------------------------------------
     Route::group([
        // 'prefix' => LaravelLocalization::setLocale(),
        // 'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'CheckStoreCookies'], // Route translate middleware
        'prefix' => 'management'
    ], function () {
        Route::get('orders', [OrderController::class, 'index']);
    });  
    // End Api Management kafara --------------------------------------

});
