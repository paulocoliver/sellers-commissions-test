<?php
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('sellers', 'SellerController');
Route::apiResource('sales',   'SalesController');
