<?php

use App\Http\Controllers\ActividadController;
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

Route::middleware(['auth', NoCache::class,])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuariosController::class);

    Route::resource('roles', RolesController::class);

    Route::get('/clientes/data', [ClientesController::class, 'data'])->name('clientes.data');
    Route::get('clientes/{id}/edit-modal', [ClientesController::class, 'editModal'])->name('clientes.edit-modal');
    Route::get('clientes/{id}/delete-modal', [ClientesController::class, 'deleteModal'])->name('clientes.delete-modal');

    Route::resource('clientes', ClientesController::class);

    Route::resource('equipos', EquipoController::class);

    Route::get('/actividades-data', [ActividadController::class, 'data'])->name('actividades.data');

    Route::resource('actividades', ActividadController::class);


});

require __DIR__ . '/auth.php';
