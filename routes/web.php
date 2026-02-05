<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-db', function () {
    return [
        'connection' => config('database.default'),
        'database' => config('database.connections.' . config('database.default') . '.database'),
        'file_exists' => file_exists(config('database.connections.sqlite.database')),
    ];
});
