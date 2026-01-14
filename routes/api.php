<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompaintController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Routs For employee

// Route::apiResource('/users', EmployeeController::class)->middleware(['optional_auth']);
// Route::post('/users/{id}/restore', [EmployeeController::class, "restore"]);
// Route::get('/deletedusers', [EmployeeController::class, "DeletedUsers"]);


// Auth APIs
Route::post('register', [AuthController::class, 'register']);
Route::post('check', [AuthController::class, 'checkCode']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('checkCodeForPassword', [AuthController::class, "checkCodeForPassword"]);
Route::post('resetPassword', [AuthController::class, 'resetPassword']);
Route::post('resendcode', [AuthController::class, 'resendCode']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {
    // Profile APIs
    Route::prefix('profile')->group(function () {
        Route::get('get', [ProfileController::class, 'show']);
        Route::put('update', [ProfileController::class, 'update']);
        Route::put('changePass', [ProfileController::class, 'changePass']);
        Route::delete('delete', [ProfileController::class, 'destroy']);
    });
    // Favorite APIs
    Route::prefix('favorite')->group(function () {
        Route::post('add/remove', [FavoriteController::class, 'toggle']);
        Route::get('get', [FavoriteController::class, 'index']);

    });
    Route::prefix('complaints')->group(function () {
        Route::post('add', [ComplaintController::class, 'store']);
        Route::get('get', [ComplaintController::class, 'index']);
        Route::get('/user', [ComplaintController::class, 'userComplaints']);
    });

    // Order APIs
    Route::apiResource('orders', OrderController::class)->only(['index', 'store']);
    Route::post('orders/cancel', [OrderController::class, 'cancel']);
});

// Home APIs
Route::get('products/search', [HomeContoller::class, 'search']);
Route::get('getProducts', [HomeContoller::class, 'getProducts']);
Route::get('getcategories', [HomeContoller::class, 'getcategories']);
Route::get('getProductByCategoryId', [HomeContoller::class, 'getProductByCategoryId']);
