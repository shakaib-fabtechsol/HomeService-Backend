<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('Register', [AuthController::class, 'Register'])->name('Register');