<?php

use App\Logistic\Http\Controllers\AvailabilityController;
use App\Logistic\Http\Controllers\HoldController;
use Illuminate\Support\Facades\Route;

Route::get('/slots/availability', [AvailabilityController::class, 'availability'])
    ->name('slots.availability');

Route::post('/slots/{id}/hold', [HoldController::class, 'create'])
    ->name('slots.hold');

Route::get('/holds/current', [HoldController::class, 'current'])
    ->name('holds.current');

Route::post('/holds/{id}/confirm', [HoldController::class, 'confirm'])
    ->name('holds.confirm');

Route::delete('/holds/{id}', [HoldController::class, 'destroy'])
    ->name('holds.destroy');
