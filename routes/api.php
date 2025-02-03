<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceProviderController;

Route::controller(AuthController::class)->group(function () {
Route::post('Register','Register')->name('Register');
Route::post('Userlogin','Userlogin')->name('Userlogin');

});
Route::middleware('auth:sanctum')->group( function () {

});
Route::controller(ServiceProviderController::class)->group(function () {
    
    Route::post('addDeal', 'addDeal')->name('AddDeal');
});

