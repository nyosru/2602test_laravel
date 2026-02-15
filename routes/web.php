<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\View;
use Inertia\Inertia;


Route::get('/login', function () {
    return inertia('Auth/Login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/vue3/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::post('/parse-yandex', function (Request $request) {

        $url = $request->input('url');

        if (!$request->header('X-Inertia')) {
            return response()->json(['error' => 'This route is for Inertia requests only'], 418);
        }
        // Простой парсер (замените на реальный)
        $data = [
            'title' => 'Пример заголовка Яндекса',
            'description' => 'Описание страницы',
            'host' => parse_url($url, PHP_URL_HOST),
            'path' => parse_url($url, PHP_URL_PATH),
            'openGraph' => ['og:title' => 'OG Title', 'og:image' => 'image.jpg'],
            'links' => ['https://yandex.ru/link1', 'https://yandex.ru/link2'],
            'images' => ['https://via.placeholder.com/150']
        ];

        return inertia('YandexParser', ['parsedData' => $data, 'parsedUrl' => $url]);

    })->name('parse-yandex');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
