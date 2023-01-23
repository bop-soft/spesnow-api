<?php

use App\Http\Controllers\v1\AdvertController;
use App\Http\Controllers\v1\CategoryController;
use App\Http\Controllers\v1\FavoriteController;
use App\Http\Controllers\v1\RentalController;
use App\Http\Controllers\v1\SubscriptionController;
use App\Http\Controllers\v1\UnlockController;
use App\Http\Controllers\v1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ------------ PUBLIC ROUTES -----------------
Route::group(['prefix' => 'v1',], function(){
    // ------------ users -----------------
    Route::controller(UserController::class)->group(function(){
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
        Route::get('auth/check', 'authCheck')->name('auth.check');
    });
    // ------------ subscriptions -----------------
    Route::controller(SubscriptionController::class)->group(function(){
        Route::get('subscriptions', 'index')->name('subscriptions.index');
        Route::get('subscriptions/{subscription}', 'show')->name('subscriptions.show');
    });
    // ------------ categories -----------------
    Route::controller(CategoryController::class)->group(function(){
        Route::get('categories', 'index')->name('categories.index');
        Route::get('categories/{category}', 'show')->name('categories.show');
    });
    // ------------ rentals -----------------
    Route::controller(RentalController::class)->group(function(){
        Route::get('rentals', 'index')->name('rentals.index');
        Route::get('rentals/latest', 'latestRentals')->name('rentals.latest');
        Route::get('categories/{id}/rentals', 'categoryRentals')->name('categories.rentals');
        Route::get('rentals/{rental}', 'show')->name('rentals.show');
        Route::get('query', 'query')->name('query');
    });
});

// ------------ PROTECTED ROUTES -----------------
Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function(){
    // ------------ users -----------------
    Route::controller(UserController::class)->group(function(){
        Route::post('logout', 'logout')->name('logout');
        Route::get('users', 'index')->name('users.index');
        Route::get('users/{user}', 'show')->name('users.show');
        Route::delete('users/{user}', 'destroy')->name('users.destroy');
});
    // ------------ adverts -----------------
    Route::apiResource('adverts', AdvertController::class);
    // ------------ subscriptions -----------------
    Route::controller(SubscriptionController::class)->group(function(){
        Route::post('subscriptions', 'store')->name('subscriptions.store');
        Route::match('put/patch', 'subscriptions/{subscription}', 'update')->name('subscriptions.update');
        Route::delete('subscriptions/{subscription}', 'destroy')->name('subscriptions.destroy');
    });
    // ------------ categories -----------------
    Route::controller(CategoryController::class)->group(function(){
        Route::post('categories', 'store')->name('categories.store');
        Route::match('put/patch', 'categories/{category}', 'update')->name('categories.update');
        Route::delete('categories/{category}', 'destroy')->name('categories.destroy');
    });
    // ------------ rentals -----------------
    Route::controller(RentalController::class)->group(function(){
        Route::post('rentals', 'store')->name('rentals.store');
        Route::match('put/patch', 'rentals/{rental}', 'update')->name('rentals.update');
        Route::delete('rentals/{rental}', 'destroy')->name('rentals.destroy');
    });
    // ------------ favorites -----------------
    Route::post('favorites/check', [FavoriteController::class, 'checkFavorite'])->name('favorite.check');
    Route::apiResource('favorites', FavoriteController::class);
     // ------------ unlocks -----------------
     Route::apiResource('unlocks', UnlockController::class);
});
