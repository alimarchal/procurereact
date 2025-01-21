<?php

use App\Http\Controllers\Api\V1\BusinessController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\IbrController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('businesses', BusinessController::class);
        Route::get('businesses/{id}/user/{user_id}', [BusinessController::class, 'getUserBusiness']);
        Route::patch('businesses/{id}/restore', [BusinessController::class, 'restore']);
        Route::delete('businesses/{id}/force', [BusinessController::class, 'forceDelete']);
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('categories', CategoryController::class);


        Route::apiResource('items', ItemController::class);


        Route::apiResource('wallets', WalletController::class);

        // Commission and Network Routes
        Route::controller(WalletController::class)->group(function () {
            Route::get('direct-commissions', 'directCommissions');
            Route::get('indirect-commissions', 'indirectCommissions');
            Route::get('earnings', 'myEarnings');
            Route::get('clients', 'myClients');
            Route::get('network', 'myNetworks');
        });

    });
});
