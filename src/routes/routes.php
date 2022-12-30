<?php

use Illuminate\Support\Facades\Route;
use Custome\Auth\Http\Controllers\AuthController;
use Custome\Auth\Http\Controllers\RegisterController;
use Custome\Auth\Http\Controllers\GoogleController;
use Custome\Auth\Http\Controllers\FacebookController;
use Custome\Auth\Http\Controllers\Admin\UserController;

Route::group(['middleware' => ['web']], function () {

    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'destroy'])
    ->name('logout');

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::controller(GoogleController::class)->group(function(){
        Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
        Route::get('auth/google/callback', 'handleGoogleCallback');
    });

    
    Route::controller(FacebookController::class)->group(function(){
        Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
        Route::get('auth/facebook/callback', 'handleFacebookCallback');
    });

    Route::middleware([
        'auth',
        'verified'
    ])->group(function () {

        Route::get('/home', function () {
            return view('auth::dashboard');
        })->name('home');

        Route::resources([
            'users' => UserController::class
        ]);
        
    });
});