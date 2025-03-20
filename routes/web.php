<?php

use App\Events\BookingCreated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-broadcast', function () {
    return view('test-broadcast');
});

Route::get('/test', function () {
    event(new BookingCreated("aa"));
    return 1;
});
