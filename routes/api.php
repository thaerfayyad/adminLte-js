<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('auth')->group(function () {
    Route::post('login',[AuthController::class,'login']);
    Route::post('user-login',[AuthController::class,'userLogin']);
    Route::post('register',[AuthController::class,'register']);
    Route::post('forget-password',[AuthController::class,'forgetPassword']);
    Route::post('rest-password',[AuthController::class,'resetPassword']);
});
Route::get('cities',[CityController::class,'index']);
Route::get('categories',[CategoryController::class,'index']);


Route::prefix('auth')->middleware('auth:user-api')->group(function () {
    Route::get('logout', [AuthController::class,'logout']);

});
