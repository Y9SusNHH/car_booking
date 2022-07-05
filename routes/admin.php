<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('layout_backend.master');
})->name('welcome');
Route::group(['middleware' => ['web']], function() {
    Route::group([
        'as'     => 'users.',
        'prefix' => 'users',
    ], function() {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/create', [UserController::class, 'store'])->name('store');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::group([
        'as'     => 'users.',
        'prefix' => 'cars',
    ], function() {
        Route::get('/', [CarController::class, 'index'])->name('index');
        Route::get('/create', [CarController::class, 'create'])->name('create');
        Route::post('/create', [CarController::class, 'store'])->name('store');
        Route::get('/edit/{car}', [CarController::class, 'edit'])->name('edit');
        Route::put('/edit/{car}', [CarController::class, 'update'])->name('update');
        Route::delete('/{car}', [CarController::class, 'destroy'])->name('destroy');

    });

});

