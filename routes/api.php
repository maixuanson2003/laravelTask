<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\bookingController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
Route::apiResource('users', UserController::class);
Route::apiResource('products', ProductController::class);
Route::post('/login', [UserController::class, 'login']);
Route::get('/search', [UserController::class, 'search']);
Route::post('/booking', [\App\Http\Controllers\bookingController::class, 'CreateBooking']);
Route::post('/upload',[ImageController::class, 'ImageUpload']);
Route::post('/createbooking',[bookingController::class, 'CreateNewBooking']);
Route::get('/getbooking/{userId}',[bookingController::class, 'GetBookingByUser']);
Route::post('/createbook',[BookController::class, 'create']);
Route::get("/getlist",[BookController::class, 'getList']);
