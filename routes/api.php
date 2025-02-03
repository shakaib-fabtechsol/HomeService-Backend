<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('Register', [AuthController::class, 'Register'])->name('Register');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceProviderController;

Route::controller(ServiceProviderController::class)->group(function () {
    Route::post('addDeal', 'addDeal')->name('AddDeal');
});

