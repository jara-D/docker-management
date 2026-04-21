<?php

use App\Http\Controllers\ContainerController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::controller(ContainerController::class)
    ->prefix('containers')
    ->name('containers.')
    ->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::post('sync', 'sync')->name('sync');
        Route::post('{id}/start', 'start')->name('start');
        Route::post('{id}/stop', 'stop')->name('stop');
        Route::delete('{id}', 'delete')->name('delete');
        Route::post('compose/up', 'createContainer')->name('compose.up');
        Route::post('compose/down/{project}', 'createContainer')->name('compose.down');
    });

Route::controller(ProjectController::class)
    ->prefix('projects')
    ->name('projects.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{project}', 'status')->name('status');
        Route::post('{project}/start', 'start')->name('start');
        Route::post('{project}/stop', 'stop')->name('stop');
        Route::post('{project}/delete', 'delete')->name('delete');
    });



require __DIR__.'/settings.php';
