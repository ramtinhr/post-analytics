<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuthWebController;

Route::get('/', function () {
    return redirect('/login');
});


Route::get(
    '/login',
    [AuthWebController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthWebController::class, 'login']
);

Route::get('/register',
    [AuthWebController::class,'showRegister']
)->name('register');

Route::post(
    '/register',
    [AuthWebController::class,'register']
)->name('register.post');



    Route::middleware([
        'auth',
        'admin'
    ])->group(function(){

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

        Route::resource(
            'posts',
            PostController::class
        );

            Route::get(
            '/analytics',
            [AnalyticsController::class,'index']
        )->name('analytics');

        Route::post(
            '/logout',
            [AuthWebController::class, 'logout']
        )->name('logout');

});
