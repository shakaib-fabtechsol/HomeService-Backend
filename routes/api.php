<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
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
        Route::get('Deal/{id}', 'Deal')->name('Deal');
        Route::get('DeleteDeal/{id}', 'DeleteDeal')->name('DeleteDeal');
    
        Route::get('DealPublish/{id}', 'DealPublish')->name('DealPublish');
    
    
        Route::post('MyDetails', 'MyDetails')->name('MyDetails');
    
        Route::post('UpdatePassword', 'UpdatePassword')->name('UpdatePassword');
    
        Route::post('BusinessProfile', 'BusinessProfile')->name('BusinessProfile');
    
    
        Route::post('AddPaymentDetails', 'AddPaymentDetails')->name('AddPaymentDetails');
        Route::post('UpdatePaymentDetails', 'UpdatePaymentDetails')->name('UpdatePaymentDetails');
    
        Route::get('DeletePaymentDetails/{id}', 'DeletePaymentDetails')->name('DeletePaymentDetails');
    
        Route::post('AdditionalPhotos', 'AdditionalPhotos')->name('AdditionalPhotos');

        Route::post('AddCertificateHours', 'AddCertificateHours')->name('AddCertificateHours');

        Route::post('AddConversation', 'AddConversation')->name('AddConversation');
        Route::post('Social', 'Social')->name('Social');
        Route::get('UserDetails/{id}', 'UserDetails')->name('UserDetails');
        Route::post('SocialDelete', 'SocialDelete')->name('SocialDelete');
        Route::post('AddBusinessLocation', 'AddBusinessLocation')->name('AddBusinessLocation');
        Route::post('UpdateBusinessLocation', 'UpdateBusinessLocation')->name('UpdateBusinessLocation');





    });

    Route::prefix('Customer')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('ListDeals', 'ListDeals')->name('ListDeals');
            Route::get('SingleDeal/{id}', 'SingleDeal')->name('SingleDeal');
            Route::post('MyDetail', 'MyDetail')->name('MyDetail');
            Route::post('NewPassword', 'NewPassword')->name('NewPassword');
            Route::post('AddPaymentMethod', 'AddPaymentMethod')->name('AddPaymentMethod');
            Route::get('DeletePaymentMethod/{id}', 'DeletePaymentMethod')->name('DeletePaymentMethod');
            Route::post('UpdatePaymentMethod', 'UpdatePaymentMethod')->name('UpdatePaymentMethod');
            Route::post('AddSocial', 'AddSocial')->name('AddSocial');
            Route::post('DeleteSocial', 'DeleteSocial')->name('DeleteSocial');
            Route::get('DealProvider/{user_id}', 'DealProvider')->name('DealProvider');
        });
    });
    
}); 