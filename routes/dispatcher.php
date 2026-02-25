<?php

use App\Http\Controllers\Api\Dispatcher\DispatcherController;
use App\Http\Controllers\Api\Dispatcher\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'dispatcher', 'as' => 'dispatcher.'], function () {

    Route::post('login', [AuthController::class, 'login']);


    Route::group(['middleware' => 'auth:dispatcher'], function () {

        Route::get('profile', [AuthController::class, 'profile']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('update-push-token', [AuthController::class, 'updatePushToken'])->name('update-push-token');
        Route::get('countries', [AuthController::class, 'countries']);
        Route::post('update-profile/{id}', [AuthController::class, 'updateProfile']);
        Route::post('update-profile-avatar/{id}', [AuthController::class, 'updateProfileAvatar']);

        Route::post('dashboard', [DispatcherController::class, 'dashboard']);
        Route::post('tasks', [DispatcherController::class, 'tasks']);
        Route::get('get-task/{id}', [DispatcherController::class, 'getTask']);
        Route::get('create', [DispatcherController::class, 'create']);
        Route::post('get-services', [DispatcherController::class, 'getServices']);

        Route::post('store-task', [DispatcherController::class, 'store']);
        Route::post('update-task', [DispatcherController::class, 'update']);
        Route::post('help', [DispatcherController::class, 'help']);
        Route::get('drivers', [DispatcherController::class, 'getDrivers']);
        Route::post('places', [DispatcherController::class, 'googlePlaces']);
        Route::post('map-drivers',[DispatcherController::class,'mapDrivers']);
        Route::post('add-driver', [DispatcherController::class, 'addDriver']);
        Route::post('assign-driver', [DispatcherController::class, 'assignDriver']);
        Route::get('destination-details/{id}',[DispatcherController::class,'destinationDetails']);  
        Route::get('epods/{id}',[DispatcherController::class,'getEpods']);

    });
});
