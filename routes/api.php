<?php

use App\Http\Controllers\Api\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function() {
    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::group(['prefix' => 'user'], function() {
            Route::get('/', function (Request $request) {
                return $request->user();
            });
        });

        Route::group(['prefix' => 'author'], function() {
            Route::post('/', [FileApiController::class, 'store']);
            Route::put('/{id}', [FileApiController::class, 'update']);
            Route::delete('/{id}', [FileApiController::class, 'destroy']);
        });

        Route::group(['prefix' => 'news'], function() {
            Route::post('/', [FileApiController::class, 'store']);
            Route::put('/{id}', [FileApiController::class, 'update']);
            Route::delete('/{id}', [FileApiController::class, 'destroy']);
        });

        Route::group(['prefix' => 'settings'], function() {
            Route::post('/', [FileApiController::class, 'store']);
            Route::put('/{id}', [FileApiController::class, 'update']);
            Route::delete('/{id}', [FileApiController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => 'author'], function() {
        Route::get('/', [FileApiController::class, 'index']);
        Route::get('/{id}', [FileApiController::class, 'show']);
    });

    Route::group(['prefix' => 'news'], function() {
        Route::get('/', [FileApiController::class, 'index']);
        Route::get('/{id}', [FileApiController::class, 'show']);
    });

    Route::group(['prefix' => 'settings'], function() {
        Route::get('/', [FileApiController::class, 'index']);
        Route::get('/{id}', [FileApiController::class, 'show']);
    });

    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AuthController::class, 'createUser']);
        Route::get('login', [AuthController::class, 'loginUser']);
    });
});

Route::get('unauthorized', function () {
    return response()->json(['error' => 'Unauthorized.'], 401);
})->name('unauthorized');

Route::any('{segment}', function () {
    return response()->json(['error' => 'Bad request.'], 400);
})->where('segment', '.*');
