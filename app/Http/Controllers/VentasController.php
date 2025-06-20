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
        // Cargar clientes con paquete (y última venta para info si quieres)
        $clientes = Cliente::with([
            'paquete',
            'ventas' => function ($q) {
                $q->orderBy('fecha_venta', 'desc')->limit(1);
            }
        ])->get();

        // Ventas de hoy para historial
        $ventasHoy = Venta::with(['cliente', 'usuario'])
            ->whereDate('fecha_venta', today())
            ->orderBy('fecha_venta', 'desc')
            ->get();

        return view('ventas.index', compact('clientes', 'ventasHoy'));
    }

    public function calcularRecargo(Cliente $cliente)
    {
        $fechaHoy = now()->startOfDay();
        $ultimaVenta = Venta::where('cliente_id', $cliente->id)->orderBy('fecha_venta', 'desc')->first();

        $recargo_falta_pago = 0;
        $diasAtraso = 0;

        if ($ultimaVenta) {
            $periodoFinAnterior = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
            $primerDiaDeAtraso = $periodoFinAnterior->copy()->addDay();

            if ($fechaHoy->greaterThanOrEqualTo($primerDiaDeAtraso)) {
                $diasAtraso = $primerDiaDeAtraso->diffInDays($fechaHoy) + 1;

                if ($diasAtraso >= 1 && $diasAtraso <= 3) {
                    $recargo_falta_pago = 40;
                } elseif ($diasAtraso > 3) {
                    $recargo_falta_pago = 140;
                }
            }
        }

        return response()->json([
            'recargo' => $recargo_falta_pago,
            'dias_atraso' => $diasAtraso,
        ]);
    }
    public function buscarClientes(Request $request)
    {
        $search = $request->input('q');

        $clientes = Cliente::with('paquete')
            ->where('nombre', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        $resultados = $clientes->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'text' => $cliente->nombre,
                'paquete' => [
                    'nombre' => $cliente->paquete->nombre ?? 'Sin paquete',
                    'precio' => $cliente->paquete->precio ?? 0,
                ],
            ];
        });

        return response()->json(['results' => $resultados]);
    }




    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'meses' => 'required|integer|min:1|max:12',
            'descuento' => 'nullable|numeric|min:0',
            'recargo_domicilio' => 'nullable|numeric|min:0',
        ]);

        $cliente = Cliente::with('paquete')->findOrFail($request->cliente_id);

        if (!$cliente->paquete) {
            return redirect()->back()->with('error', 'Este cliente no tiene paquete asignado.');
        }

        $precioPaquete = $cliente->paquete->precio;
        $meses = (int) $request->meses;
        $subtotal = $precioPaquete * $meses;

        $fechaHoy = now()->startOfDay();

        $ultimaVenta = Venta::where('cliente_id', $cliente->id)
            ->orderBy('fecha_venta', 'desc')
            ->first();

        $recargo_falta_pago = 0;

        if ($ultimaVenta) {
            $periodoFinAnterior = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
            $primerDiaAtraso = $periodoFinAnterior->copy()->addDay();

            if ($fechaHoy->gte($primerDiaAtraso)) {
                $diasAtraso = $primerDiaAtraso->diffInDays($fechaHoy) + 1;

                if ($diasAtraso >= 1 && $diasAtraso <= 3) {
                    $recargo_falta_pago = 40;
                } elseif ($diasAtraso > 3) {
                    $recargo_falta_pago = 140;
                }
            }
        }

        $total = $subtotal - ($request->descuento ?? 0) + ($request->recargo_domicilio ?? 0) + $recargo_falta_pago;

        $diaCobro = $cliente->dia_cobro ?? 1;

if ($ultimaVenta) {
    // 👉 Continuar justo después del periodo_fin anterior
    $periodoInicio = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
} else {
    // Primera venta: calcular desde el día de cobro más cercano a hoy
    $hoy = now()->startOfDay();
    $proximoCobro = $hoy->copy()->day($diaCobro);

    if ($hoy->day > $diaCobro) {
        $proximoCobro->addMonthNoOverflow();
    }

    $periodoInicio = $proximoCobro;
}

$periodoFin = $periodoInicio->copy()->addMonthsNoOverflow($meses);


        Venta::create([
            'usuario_id' => Auth::id(),
            'cliente_id' => $cliente->id,
            'estado' => 'pagado',
            'meses' => $meses,
            'descuento' => $request->descuento ?? 0,
            'recargo_domicilio' => $request->recargo_domicilio ?? 0,
            'recargo_falta_pago' => $recargo_falta_pago,
            'fecha_venta' => now(),
            'subtotal' => $subtotal,
            'total' => $total,
            'periodo_inicio' => $periodoInicio,
            'periodo_fin' => $periodoFin
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }
}
