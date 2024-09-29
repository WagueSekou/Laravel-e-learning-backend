<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function(){
    return response(['message'=>'api testing is working'], 200);
});

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

// Route::group(['namespace'=>'Api'], function(){

//     Route::post('/auth/register', [UserController::class, 'createUser']);
//     Route::post('/auth/login', [UserController::class, 'loginUser']);
//     // Route::post('/auth/login','UserController@loginUser');

//     //authentication middleware
//     Route::group(['middleware'=>['auth:sanctum']], function(){
//         Route::any('/courseList', [CourseController::class, 'courseList']);
//         // Route::any('/courseList', 'CourseController@courseList');
//     });
// });

