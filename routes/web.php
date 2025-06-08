<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\RolesController;
use App\Http\Middleware\NoCache; // Importa tu middleware aquí

Route::get('/', function () {
    return view('welcome');
});

// Dashboard protegido
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', NoCache::class])->name('dashboard');

// Nuevo dashboard protegido
Route::get('/alt-dashboard', function () {
    return view('dashboard.index'); // resources/views/dashboard/index.blade.php
})->middleware(['auth', 'verified', NoCache::class])->name('alt-dashboard');

// Rutas protegidas con auth y sin caché
Route::middleware(['auth', NoCache::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuariosController::class);

    Route::resource('roles', RolesController::class);

    Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');
});

require __DIR__.'/auth.php';
