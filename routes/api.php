<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/user',[UserController::class,'store']);


Route::get('/products', [ProductsController::class,'index']);
Route::post('/productstore', [ProductsController::class,'store']);
Route::get('/show/{id}', [ProductsController::class,'show']);
Route::put('/productupdate/{id}', [ProductsController::class,'update']);
Route::delete('/productdelete/{id}', [ProductsController::class,'destroy']);
Route::get('/search', [ProductsController::class, 'search']);

Route::get('/ch', [ProductsController::class, 'useSharedValue']);




Route::get('/users', [UserController::class,'index']);
Route::post('/userstore', [UserController::class,'store']);
Route::put('/userupdate/{id}', [UserController::class,'update']);
Route::delete('/userdelete/{id}', [UserController::class,'destroy']);


Route::get('/hello', function () {
    return "Hello World!";
  });

  