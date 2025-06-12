<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\RolesController;
use App\Http\Middleware\NoCache; 
use App\Http\Controllers\EquipoController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/alt-dashboard', function () {
    return view('dashboard.index'); // resources/views/dashboard/index.blade.php
})->middleware(['auth', 'verified', NoCache::class])->name('alt-dashboard');

Route::middleware(['auth', NoCache::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuariosController::class);

    Route::resource('roles', RolesController::class);

    Route::resource('clientes', ClientesController::class);

    Route::resource('equipos', EquipoController::class);

});

require __DIR__.'/auth.php';
