<?php

use App\Http\Controllers\Api\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Api\Admin\LeadSourceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\SalesController;
use App\Http\Controllers\Api\Admin\ServiceController;
use App\Http\Controllers\Api\Sales\LeadController;
use App\Http\Controllers\Api\Sales\SalesController as SalesSalesController;
use App\Http\Controllers\Api\TestMailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Test
|--------------------------------------------------------------------------
*/

Route::get('/test-mail', [TestMailController::class, 'send']);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot/password', [AuthController::class, 'forgotPassword']);
Route::post('/verify/otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset/password', [AuthController::class, 'resetPassword']);


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/update/profile', [AuthController::class, 'updateProfile']);
    Route::post('/change/password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->middleware('admin')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | all leads 
            |--------------------------------------------------------------------------
            */
            Route::get('/all/leads', [AdminLeadController::class, 'index']);
            Route::get('/show/lead/{id}', [AdminLeadController::class, 'show']);
            /*
            |--------------------------------------------------------------------------
            | Sales Management
            |--------------------------------------------------------------------------
            */
            Route::post('/create/sales', [SalesController::class, 'store']);
            Route::get('/all/sales', [SalesController::class, 'index']);
            Route::get('/show/sales/{id}', [SalesController::class, 'show']);
            Route::post('/update/sales/{id}', [SalesController::class, 'updateStatus']);
            Route::delete('/delete/sales/{id}', [SalesController::class, 'destroy']);


            // ========================================================================
            // ========================================================================

            /*
            |--------------------------------------------------------------------------
            | services Management
            |--------------------------------------------------------------------------
            */
            Route::post('/create/services', [ServiceController::class, 'store']);
            Route::get('/all/services', [ServiceController::class, 'index']);
            Route::post('/update/services/{id}', [ServiceController::class, 'update']);
            Route::get('/show/services/{id}', [ServiceController::class, 'show']);
            Route::delete('/delete/services/{id}', [ServiceController::class, 'destroy']);


            // ========================================================================
            // ========================================================================

            /*
            |--------------------------------------------------------------------------
            | lead sources Management
            |--------------------------------------------------------------------------
            */
            Route::post('/create/lead-sources', [LeadSourceController::class, 'store']);
            Route::get('/all/lead-sources', [LeadSourceController::class, 'index']);
            Route::post('/update/lead-sources/{id}', [LeadSourceController::class, 'update']);
            Route::get('/show/lead-sources/{id}', [LeadSourceController::class, 'show']);
            Route::delete('/delete/lead-sources/{id}', [LeadSourceController::class, 'destroy']);
        });


    /*
    |--------------------------------------------------------------------------
    | Sales Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('sales')
        ->middleware('sales')
        ->group(function () {


            // Services & Lead Sources
            Route::get('/all/services', [SalesSalesController::class, 'services']);
            Route::get('/all/lead-sources', [SalesSalesController::class, 'leadSources']);

            // Leads
            Route::post('/create/lead', [LeadController::class, 'store']);
            Route::get('/all/leads', [LeadController::class, 'index']);
            Route::get('/show/lead/{id}', [LeadController::class, 'show']);
            Route::post('/update/lead/{id}', [LeadController::class, 'update']);
        });
});
