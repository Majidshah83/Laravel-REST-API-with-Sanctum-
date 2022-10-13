<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\http\Controllers\ProductController;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//public routes
Route::get('/product',[ProductController::class,'index']);
Route::get('/getSingleProduct/{id}',[ProductController::class,'edit']);
Route::get('/searchProduct/{name}',[ProductController::class,'search']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
 Route::post('/products',[ProductController::class,'store']);
Route::put('/updateProduct/{id}',[ProductController::class,'update']);
Route::delete('/deleteProduct/{id}',[ProductController::class,'destroy']);
});
Route::post('/userRigster',[AuthController::class,'register']);