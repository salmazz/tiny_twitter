<?php

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

// Auth routes
Route::post('auth/register', [\App\Http\Controllers\PassportAuthController::class, 'register']);
Route::post('auth/login', [\App\Http\Controllers\PassportAuthController::class, 'login']);

Route::get('/report',[\App\Http\Controllers\ReportController::class,'report']);

Route::group(['middleware' => 'auth:api'], function() {
    // Tweets resource
    Route::apiResource('/tweets',\App\Http\Controllers\TweetController::class);

    // Follow routes
    Route::post('/follow/{id}', [\App\Http\Controllers\FollowController::class, 'follow']);
    Route::post('/unfollow/{id}', [\App\Http\Controllers\FollowController::class, 'unfollow']);
});



