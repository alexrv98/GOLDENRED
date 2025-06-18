<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VentasController extends Controller
{
    public function index()
    {
        // Traemos los clientes
        $clientes = Cliente::select('id', 'nombre', 'telefono1', 'telefono2')->get();

        // Para cada cliente buscamos su última venta
        $clientes->map(function ($cliente) {
            $ultimaVenta = Venta::where('cliente_id', $cliente->id)
                ->orderBy('fecha_venta', 'desc')
                ->first();

            if (!$ultimaVenta) {
                $cliente->estado_pago = 'pendiente';
            } else {
                $cliente->estado_pago = $ultimaVenta->estado;
            }

            return $cliente;
        });

        return view('ventas.index', compact('clientes'));
    }

public function store(Request $request)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'meses' => 'required|integer|min:1',
        'descuento' => 'nullable|numeric|min:0',
        'recargo_domicilio' => 'nullable|numeric|min:0',
        'recargo_falta_pago' => 'nullable|numeric|min:0',
    ]);

    $cliente = Cliente::findOrFail($request->cliente_id);

    $precioPaquete = $cliente->paquete->precio ?? 0;
    $mesesPagados = (int) $request->meses;

    $subtotal = $precioPaquete * $mesesPagados;

    $total = $subtotal 
        - ($request->descuento ?? 0)
        + ($request->recargo_domicilio ?? 0)
        + ($request->recargo_falta_pago ?? 0);

    $periodoInicio = Carbon::now()->startOfDay();
    $periodoFin = (clone $periodoInicio)->addMonths($mesesPagados)->subDay();

    Venta::create([
        'cliente_id' => $cliente->id,
            'usuario_id' => Auth::id(), // <-- Aquí agregamos el usuario logueado

        'estado' => 'pagado',
        'meses' => $mesesPagados,
        'descuento' => $request->descuento ?? 0,
        'recargo_domicilio' => $request->recargo_domicilio ?? 0,
        'recargo_falta_pago' => $request->recargo_falta_pago ?? 0,
        'fecha_venta' => now(),
        'subtotal' => $subtotal,
        'total' => $total,
        'periodo_inicio' => $periodoInicio,
        'periodo_fin' => $periodoFin,
    ]);

    return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
}

}
