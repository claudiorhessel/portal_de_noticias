<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\SettingsController;
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
            Route::post('/', [AuthorController::class, 'store']);
            Route::put('/{id}', [AuthorController::class, 'update']);
            Route::delete('/{id}', [AuthorController::class, 'destroy']);
        });

        Route::group(['prefix' => 'news'], function() {
            Route::post('/', [NewsController::class, 'store']);
            Route::put('/{id}', [NewsController::class, 'update']);
            Route::delete('/{id}', [NewsController::class, 'destroy']);
        });

        Route::group(['prefix' => 'settings'], function() {
            Route::post('/', [SettingsController::class, 'store']);
            Route::put('/{id}', [SettingsController::class, 'update']);
            Route::delete('/{id}', [SettingsController::class, 'destroy']);
        });

        Route::group(['prefix' => 'category'], function() {
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => 'author'], function() {
        Route::get('/', [AuthorController::class, 'index']);
        Route::get('/{id}', [AuthorController::class, 'show']);
    });

    Route::group(['prefix' => 'news'], function() {
        Route::get('/', [NewsController::class, 'index']);
        Route::get('/{id}', [NewsController::class, 'show']);
    });

    Route::group(['prefix' => 'settings'], function() {
        Route::get('/', [SettingsController::class, 'index']);
        Route::get('/{id}', [SettingsController::class, 'show']);
    });

    Route::group(['prefix' => 'category'], function() {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);
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
