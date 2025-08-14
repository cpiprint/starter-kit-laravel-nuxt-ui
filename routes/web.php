<?php

use App\Http\Controllers\CurrentUserController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('index');
});
Route::get('pricing', [PricingController::class, 'index'])
    ->name('pricing.index');


Route::middleware(['auth'])->group(function () {
    Route::get('user/profile', [UserProfileController::class, 'show'])
        ->name('profile.show');

    Route::delete('user', [CurrentUserController::class, 'destroy'])
        ->name('current-user.destroy');

    Route::delete('/user/profile-photo', [ProfilePhotoController::class, 'destroy'])
        ->name('current-user-photo.destroy');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('dashboard');
    })
        ->name('dashboard');
});
