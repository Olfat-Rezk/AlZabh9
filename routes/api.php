<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AcountController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PackingController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShreederController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController;

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

Route::middleware('auth:passport')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::middleware('auth:api')->group(function(){
    Route::get('logout',[AuthController::class,'logout']);
    Route::get('getAuthinticatedUser',[AuthController::class,'getAuthinticatedUser']);

});

################ Start Category routs##########################

Route::prefix('category')->controller(CategoryController::class)->group(function(){
    Route::get('/','index');
    Route::post('/store','store');
    Route::get('/{id}','show');
    Route::post('update/{id}','update');
    //Route::post()

});
################End  Category routs##########################
###########shreeder#############
Route::get('/shreeder',[ShreederController::class,'index']);
Route::get('/shreeder/{id}',[ShreederController::class,'show']);

#############packing
Route::get('/packing',[PackingController::class,'index']);
Route::get('/packing/{id}',[PackingController::class,'show']);
#################contact
Route::get('/contact',[ContactController::class,'index']);
Route::get('/contact/{id}',[ContactController::class,'show']);
#################
Route::get('/account',[ AcountController::class,'index']);
#############
Route::get('/product',[ProductController::class,'index']);
Route::get('/product/{id}',[ProductController::class,'show']);






