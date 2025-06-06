<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\RolesController;



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
  ->name('alt-dashboard');  

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('usuarios', UsuariosController::class)->middleware('auth');
    
Route::resource('roles', controller: RolesController::class)->middleware('auth');

Route::get('/clientes', [ClientesController::class, 'index'])->name(name: 'clientes.index');

