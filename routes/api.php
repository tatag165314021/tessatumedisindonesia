<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

Route::apiResource('/produk', App\Http\Controllers\Api\ProductController::class)->middleware(['cektoken']);

Route::get('/cari', [App\Http\Controllers\Api\ProductController::class, 'pencarian'])->middleware(['cektoken']);
