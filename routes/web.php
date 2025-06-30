<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\PaquetesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\RolesController;
use App\Http\Middleware\NoCache;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;



Route::get('/', function () {
    return redirect(Auth::check() ? route('alt-dashboard') : route('login'));
});


Route::middleware(['auth', NoCache::class,])->group(function () {

    // Dashboard
    Route::get('/alt-dashboard', DashboardController::class)->name('alt-dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuariosController::class);

    Route::resource('roles', RolesController::class);

    Route::get('clientes/{id}/edit-modal', [ClientesController::class, 'editModal'])->name('clientes.edit-modal');
    Route::get('clientes/{id}/delete-modal', [ClientesController::class, 'deleteModal'])->name('clientes.delete-modal');

    Route::resource('clientes', ClientesController::class);

    Route::resource('equipos', EquipoController::class);

    Route::get('/actividades-data', [ActividadController::class, 'data'])->name('actividades.data');

    Route::resource('actividades', ActividadController::class);

    Route::resource('paquetes', PaquetesController::class);

    Route::get('/ventas/recargo/{cliente}', [VentasController::class, 'calcularRecargo']);
    Route::get('/ventas/buscar-clientes', [VentasController::class, 'buscarClientes'])->name('ventas.buscar-clientes');
    Route::get('/ventas/estado-cliente/{clienteId}', [VentasController::class, 'estadoCliente']);

    Route::resource('ventas', VentasController::class)->except(['show']);

    Route::get('historial', [VentasController::class, 'historial'])->name('ventas.historial');
    Route::get('corte', [VentasController::class, 'corte'])->name('ventas.corte');

    Route::resource('auditoria', AuditoriaController::class);
    Route::put('/ventas/{venta}', [VentasController::class, 'update'])->name('ventas.update');



});


Route::get('/api/ventas/{venta}', function (App\Models\Venta $venta) {
    return response()->json([
        'cliente' => $venta->cliente->nombre,
        'paquete' => optional($venta->cliente->paquete)->nombre ?? 'N/A',
        'meses' => $venta->meses,
        'descuento' => $venta->descuento,
        'recargo_domicilio' => $venta->recargo_domicilio,
        'recargo_atraso' => $venta->recargo_atraso ?? 0,
        'total' => $venta->total,
    ]);
});
Route::get('/ticket/imprimir/{venta}', [TicketController::class, 'imprimible'])->name('ticket.imprimible');
Route::get('/ventas/{id}/ticket', [TicketController::class, 'reimprimir'])->name('ventas.ticket');


require __DIR__ . '/auth.php';
