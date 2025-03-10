<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SaleRapController;


Route::controller(AuthController::class)->group(function () {
    Route::post('Register', 'Register')->name('Register');
    Route::post('UpdateUser', 'UpdateUser')->name('UpdateUser');
    Route::post('Userlogin', 'Userlogin')->name('Userlogin');
    Route::get('googleLogin', 'googleLogin')->name('googleLogin');
    Route::get('auth/google/callback', 'googleHandle');
    Route::get('facebookLogin', 'facebookLogin')->name('facebookLogin');
    Route::get('auth/facebook/callback', 'facebookHandle');


    
});
Route::middleware('auth:sanctum')->group(function () {
    
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
        Route::post('UpdateCertificateHours', 'UpdateCertificateHours')->name('UpdateCertificateHours');
    
    
        Route::post('AddConversation', 'AddConversation')->name('AddConversation');
        Route::post('Social', 'Social')->name('Social');
        Route::get('UserDetails/{id}', 'UserDetails')->name('UserDetails');
        Route::post('SocialDelete', 'SocialDelete')->name('SocialDelete');
        Route::post('AddBusinessLocation', 'AddBusinessLocation')->name('AddBusinessLocation');
        Route::post('UpdateBusinessLocation', 'UpdateBusinessLocation')->name('UpdateBusinessLocation');
        Route::get('GetBusiness/{id}', 'GetBusiness')->name('GetBusiness');

        Route::get('OrdersList', 'OrdersList')->name('OrdersList');
        Route::get('SettingPublish/{id}', 'SettingPublish')->name('SettingPublish');
        Route::post('GetDealsByCategory', 'GetDealsByCategory')->name('GetDealsByCategory');
        
        Route::post('OrderBeforeImages', 'OrderBeforeImages')->name('OrderBeforeImages');
        Route::post('OrderConfirmImages', 'OrderConfirmImages')->name('OrderConfirmImages');
        Route::post('OrdeAfterImages', 'OrdeAfterImages')->name('OrdeAfterImages');

        Route::post('CreateOffer', 'CreateOffer')->name('CreateOffer');
        
        
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
            Route::get('DetailUser/{id}', 'DetailUser')->name('DetailUser');
    
            Route::post('AddOrder', 'AddOrder')->name('AddOrder');
            Route::post('UpdateOrder', 'UpdateOrder')->name('UpdateOrder');
            Route::get('Orders', 'Orders')->name('Orders');
            Route::get('Order/{id}', 'Order')->name('Order');

            Route::post('UploadReview', 'UploadReview')->name('UploadReview');
            Route::post('UpdateReview', 'UpdateReview')->name('UpdateReview');
            Route::get('DeleteReview/{id}', 'DeleteReview')->name('DeleteReview');

            Route::post('FilterService', 'FilterService')->name('FilterService');

            Route::post('AskForRevison', 'AskForRevison')->name('AskForRevison');
        });
    });

    Route::prefix('SuperAdmin')->group(function () {
        Route::controller(SuperAdminController::class)->group(function () {
    
            Route::get('SuperAdminDashboard', 'SuperAdminDashboard')->name('SuperAdminDashboard');
            Route::get('ServiceProviders', 'ServiceProviders')->name('ServiceProviders');
            Route::get('ProviderDetail/{user_id}', 'ProviderDetail')->name('ProviderDetail');
            Route::get('Customers', 'Customers')->name('Customers');
    
            Route::post('AddSalesReps', 'AddSalesReps')->name('AddSalesReps');
            Route::get('ViewSalesReps/{id}', 'ViewSalesReps')->name('ViewSalesReps');
            Route::post('UpdateSalesReps', 'UpdateSalesReps')->name('UpdateSalesReps');
            Route::get('DeleteSalesReps/{id}', 'DeleteSalesReps')->name('DeleteSalesReps');
    
            Route::post('UpdatePersonal', 'UpdatePersonal')->name('UpdatePersonal');
            Route::post('Security', 'Security')->name('Security');
            Route::post('NotificationSetting', 'NotificationSetting')->name('NotificationSetting');
            
            
        });
    });

    Route::prefix('SaleRep')->group(function () {
        Route::controller(SaleRapController::class)->group(function () {
    
            Route::get('SaleRepProviders', 'SaleRepProviders')->name('SaleRepProviders');
            Route::get('Dashboard', 'Dashboard')->name('Dashboard');
            Route::post('SalesPersonal', 'SalesPersonal')->name('SalesPersonal');
            Route::post('SalesSecurity', 'SalesSecurity')->name('SalesSecurity');
            Route::post('AddTask', 'AddTask')->name('AddTask');
            Route::get('FetchAllTask', 'FetchAllTask')->name('FetchAllTask');
            Route::get('ViewTask/{id}', 'ViewTask')->name('ViewTask');
            Route::post('UpdateTask', 'UpdateTask')->name('UpdateTask');
            Route::get('DeleteTask/{id}', 'DeleteTask')->name('DeleteTask');

            

          
        });
    });
    
});