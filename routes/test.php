<?php

use Illuminate\Support\Facades\Route;

Route::get('/activity', function () {
    return \Spatie\Activitylog\Models\Activity::with('causer')->latest()->take(50)->get();
})->middleware(['auth', 'verified']);