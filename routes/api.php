<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceProviderController;

Route::post('Register', [AuthController::class, 'Register'])->name('Register');


Route::controller(ServiceProviderController::class)->group(function () {
    Route::post('BasicInfo', 'BasicInfo')->name('BasicInfo');
    Route::post('PriceAndPackage', 'PriceAndPackage')->name('PriceAndPackage');
    Route::post('MediaUpload', 'MediaUpload')->name('MediaUpload');
});

