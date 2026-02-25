<?php

use App\Http\Controllers\Api\Driver\AppController;
use App\Http\Controllers\Api\Driver\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Unaunthenticated Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Aunthenticated Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('dashboard',[AuthController::class,'dashboard']);
    Route::post('update-push-token', [AuthController::class, 'updatePushToken'])->name('update-push-token');

    
    //Tasks
    Route::post('tasks', [AppController::class, 'taskList'])->name('tasks');
    Route::get('task-detail/{id}', [AppController::class, 'taskDetail'])->name('task-detail');
    Route::get('active-task/{id}',[AppController::class,'activeTask'])->name('active-task');
    Route::post('driver-location',[AppController::class,'driverLocation'])->name('driver-location');
    Route::post('driver-task',[AppController::class,'driverTask'])->name('driver-task');
    Route::get('driver-task',[AppController::class,'getDriverTask'])->name('driver-task');
    Route::post('task-complete/{task_id}',[AppController::class,'completeTask']);
    Route::get('get-price/{id}', [AppController::class, 'calculateFee']);

    Route::post('arrive-distance',[AppController::class,'arriveDistance'])->name('arrive-distance');
    Route::post('drop-distance',[AppController::class,'dropDistance'])->name('drop-distance');

    Route::post('upload-doc/{task_id}/{type}/{name}',[AppController::class,'uploadDoc'])->name('upload-doc');
    Route::post('upload-doc-camera/{task_id}/{type}/{name}',[AppController::class,'uploadDocCamera'])->name('upload-doc-camera');
    
    Route::get('pickup-epod/{task_id}',[AppController::class,'pickupEpod']);
    Route::post('post-note',[AppController::class,'postNote'])->name('post-note');

    Route::get('activity/{type}',[AppController::class,'activity'])->name('activity');
    Route::post('help',[AppController::class,'help']);
    Route::get('go-offline',[AppController::class,'goOffline']);

    Route::get('driver-docs',[AppController::class,'driverDocs']);
    Route::post('reset-password',[AuthController::class,'resetPassword']);

});

Route::post('update-location', [TestController::class, 'updateLocation'])->name('update-location');
Route::post('update-online-status', [TestController::class, 'updateOnlineStatus'])->name('update-online-status');
