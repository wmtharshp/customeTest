<?php

use Illuminate\Support\Facades\Route;
use Custome\Auth\Http\Controllers\AuthController;
use Custome\Auth\Http\Controllers\RegisterController;

Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'destroy'])
->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);



Route::middleware([
    'auth',
    'verified'
])->group(function () {
    Route::get('/home', function () {
        return view('auth::dashboard');
    })->name('home');
});