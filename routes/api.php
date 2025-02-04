<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceProviderController;

Route::controller(AuthController::class)->group(function () {
Route::post('Register','Register')->name('Register');
Route::post('UpdateUser','UpdateUser')->name('UpdateUser');
Route::post('Userlogin','Userlogin')->name('Userlogin');

});
Route::middleware('auth:sanctum')->group( function () {
    Route::controller(ServiceProviderController::class)->group(function () {
        Route::post('BasicInfo', 'BasicInfo')->name('BasicInfo');
        Route::post('UpdateBasicInfo', 'UpdateBasicInfo')->name('UpdateBasicInfo');

        Route::post('PriceAndPackage', 'PriceAndPackage')->name('PriceAndPackage');
        Route::post('UpdatePriceAndPackage', 'UpdatePriceAndPackage')->name('UpdatePriceAndPackage');

        Route::post('MediaUpload', 'MediaUpload')->name('MediaUpload');
        Route::post('UpdateMediaUpload', 'UpdateMediaUpload')->name('UpdateMediaUpload');

        Route::get('Deals', 'Deals')->name('Deals');
        Route::post('Deal', 'Deal')->name('Deal');
        Route::post('DeleteDeal', 'DeleteDeal')->name('DeleteDeal');

        Route::post('DealPublish', 'DealPublish')->name('DealPublish');

        Route::post('AddPaymentDetails', 'AddPaymentDetails')->name('AddPaymentDetails');
        Route::post('UpdatePaymentDetails', 'UpdatePaymentDetails')->name('UpdatePaymentDetails');
        Route::post('DeletePaymentDetails', 'DeletePaymentDetails')->name('DeletePaymentDetails');



    });
});


