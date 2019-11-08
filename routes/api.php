<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//Buyer
Route::apiResource('buyers','Buyer\BuyerController',['only'=>['index','show']]);
//Seller
Route::apiResource('sellers','Seller\SellerController',['only'=>['index','show']]);
//Category
Route::apiResource('categories','Category\CategoryController',['except'=>['create','edit']]);
//Products
Route::apiResource('products','Product\ProductController',['only'=>['index','show']]);
//Transaction
Route::apiResource('Transaction','Transaction\TransactionController',['only'=>['index','show']]);
//User
Route::apiResource('users','User\UserController',['except'=>['create','edit']]);


