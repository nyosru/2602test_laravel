<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('users')->group(function () {
    Route::prefix('random')->group(function () {
        Route::get('', [\App\Http\Controllers\Api\TestController::class, 'getRandomUser']);
        Route::get('token', [\App\Http\Controllers\Api\TestController::class, 'getRandomToken']);
    });
});

Route::
//prefix('api')->
as('api.')->
group(function () {


// Публичные маршруты для продуктов (без авторизации, если нужно)
    Route::prefix('public')->group(function () {
        Route::get('products', [ProductController::class, 'indexPublic'])
            ->withoutMiddleware('auth:sanctum')
            ->name('products.public.index');
        Route::get('products/{product}', [ProductController::class, 'showPublic'])->name('products.public.show');

    });

// Защищенные маршруты (требуется Bearer Token)
    Route::middleware(['auth:sanctum'])->group(function () {
        // Аутентификация
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [AuthController::class, 'user'])->name('user');


        Route::apiResource('products', ProductController::class);
        Route::get('products/search', [ProductController::class, 'searchByName'])
            ->name('products.search');

        Route::post('products/{product}/restore', [ProductController::class, 'restore'])
            ->name('products.restore')
            ->withTrashed();

        Route::delete('products/{product}/force', [ProductController::class, 'forceDestroy'])
            ->name('products.force-destroy')
            ->withTrashed();

    });

});


// Пример маршрута с проверкой
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
