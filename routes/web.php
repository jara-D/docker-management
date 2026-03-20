<?php

use App\Http\Controllers\ContainerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

use App\Http\Controllers\DashboardController;

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::controller(ContainerController::class)
    ->prefix('containers')
    ->name('containers.')
    ->group(function () {
        Route::post('sync', 'sync')->name('sync');
        Route::post('{id}/start', 'start')->name('start');
        Route::post('{id}/stop', 'stop')->name('stop');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('compose/up', 'createContainer')->name('compose.up');
        Route::post('compose/down/{project}', 'createContainer')->name('compose.down');
    });



require __DIR__.'/settings.php';
