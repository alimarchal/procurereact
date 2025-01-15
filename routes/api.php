<?php

use App\Http\Controllers\Api\V1\BusinessController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\IbrController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\ProjectController;
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
        Route::patch('businesses/{id}/restore', [BusinessController::class, 'restore']);
        Route::delete('businesses/{id}/force', [BusinessController::class, 'forceDelete']);
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('categories', CategoryController::class);


        Route::apiResource('items', ItemController::class);




        // IBR
        Route::get('business-referrals', [IbrController::class, 'business_referrals']);

        Route::get('ibr-referrals', [IbrController::class, 'ibr_referrals']);




        /* Profile Update Routes */
        Route::post('profile/update/', [IbrController::class, 'profileUpdate']);
        /* Profile Update Routes */

        /* Direct Commission Routes */
        Route::get('direct-commissions', [IbrController::class, 'directCommissions']);
        /* Direct Commission Routes */

        /* Indirect Commission Routes */
        Route::get('indirect-commissions', [IbrController::class, 'inDirectCommissions']);
        /* Indirect Commission Routes */

        /* Dashboard related routes start */

        /* My earnings Route */
        Route::get('earnings', [IbrController::class, 'myEarnings']);
        /* My earnings Route */

        /* My clients Route */
        Route::get('clients', [IbrController::class, 'myClients']);
        /* My clients Route */

        /* My network Route */
        Route::get('network', [IbrController::class, 'myNetworks']);
        /* My network Route */



    });
});
