<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ClientesController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* Nuevo dashboard, en la carpeta “dasboard” */
Route::get('/alt-dashboard', function () {
    return view('dashboard.index');           // resources/views/dasboard/index.blade.php
})->middleware(['auth', 'verified'])
  ->name('dashboard.alt');  

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');