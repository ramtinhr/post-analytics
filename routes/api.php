<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AnalyticsController;

Route::post(
    '/register',
    [AuthController::class, 'register']
);

Route::post(
    '/login',
    [AuthController::class, 'login']
);


// Public

Route::get(
    '/posts',
    [PostController::class,'index']
);


Route::get(
    '/posts/{post}',
    [PostController::class,'show']
);


// Protected

Route::middleware('auth:sanctum')->group(function () {

    Route::post(
        '/posts',
        [PostController::class,'store']
    );


    Route::put(
        '/posts/{post}',
        [PostController::class,'update']
    );


    Route::delete(
        '/posts/{post}',
        [PostController::class,'destroy']
    );

});

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get(
            '/posts/{post}/analytics/daily',
            [AnalyticsController::class,'daily']
        );

        Route::get(
            '/posts/{post}/analytics/summary',
            [AnalyticsController::class,'summary']
        );

        Route::get(
            '/posts/top-viewed',
            [AnalyticsController::class,'topViewed']
        );


        Route::get(
            '/user',
            [AuthController::class, 'user']
        );

        Route::post(
            '/logout',
            [AuthController::class, 'logout']
        );
    });
