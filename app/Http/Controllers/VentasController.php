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
        [$diasAtraso, $recargo_falta_pago] = $this->obtenerAtrasoYRecargo($cliente);

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
                'dia_pago' => $cliente->dia_cobro,
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
            'tipo_pago' => 'required|in:Efectivo,Transferencia',
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

        [$diasAtraso, $recargo_falta_pago] = $this->obtenerAtrasoYRecargo($cliente);

        $total = $subtotal - ($request->descuento ?? 0) + ($request->recargo_domicilio ?? 0) + $recargo_falta_pago;

        $diaCobro = $cliente->dia_cobro ?? 1;

        if ($ultimaVenta) {
            $periodoInicio = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
        } else {
            $hoy = now()->startOfDay();
            $proximoCobro = $hoy->copy()->day($diaCobro);

            if ($hoy->day > $diaCobro) {
                $proximoCobro->addMonthNoOverflow();
            }

            $periodoInicio = $proximoCobro;
        }

        $periodoFin = $periodoInicio->copy()->addMonthsNoOverflow($meses);

        $venta = Venta::create([
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
            'periodo_fin' => $periodoFin,
            'tipo_pago' => $request->tipo_pago,
        ]);

        return redirect()->route('ventas.index')
            ->with('venta_id_para_imprimir', $venta->id);


    }

    public function historial()
    {
        $ventas = Venta::with(['cliente', 'usuario'])
            ->orderBy('fecha_venta', 'desc')
            ->paginate(20); // Puedes ajustar la paginación

        return view('ventas_historial.index', compact('ventas'));
    }

    public function corte(Request $request)
    {
        $fecha = $request->input('fecha') ?? now()->toDateString();
        $usuario_id = $request->input('usuario_id');

        $query = Venta::with(['cliente', 'usuario'])
            ->whereDate('created_at', $fecha);

        if ($usuario_id) {
            $query->where('usuario_id', $usuario_id);
        }

        $ventas = $query->orderBy('fecha_venta', 'desc')->get();
        $totalEfectivo = $ventas->where('tipo_pago', 'Efectivo')->sum('total');
        $totalTransferencia = $ventas->where('tipo_pago', 'Transferencia')->sum('total');

        $conteoEfectivo = $ventas->where('tipo_pago', 'Efectivo')->count();
        $conteoTransferencia = $ventas->where('tipo_pago', 'Transferencia')->count();


        $usuarios = \App\Models\User::all(); // Para llenar el select

        return view('ventas_corte.index', compact(
            'ventas',
            'usuarios',
            'totalEfectivo',
            'totalTransferencia',
            'conteoEfectivo',
            'conteoTransferencia'
        ));

    }

    public function obtenerVenta($id)
    {
        $venta = Venta::with('cliente', 'usuario')->findOrFail($id);

        return response()->json([
            'cliente' => $venta->cliente->nombre,
            'paquete' => $venta->cliente->paquete->nombre ?? 'Sin paquete',
            'meses' => $venta->meses,
            'descuento' => $venta->descuento,
            'recargo_domicilio' => $venta->recargo_domicilio,
            'recargo_falta_pago' => $venta->recargo_falta_pago ?? 0,
            'total' => $venta->total
        ]);
    }

    private function obtenerAtrasoYRecargo(Cliente $cliente): array
    {
        $hoy = now()->startOfDay();
        $ultimaVenta = Venta::where('cliente_id', $cliente->id)->orderBy('fecha_venta', 'desc')->first();

        if ($ultimaVenta) {
            $fechaBase = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
        } else {
            $diaCobro = $cliente->dia_cobro ?? 1;
            $fechaBase = $hoy->copy()->day($diaCobro);

            if ($hoy->lt($fechaBase)) {
                $fechaBase->subMonthNoOverflow();
            }
        }

        $primerDiaAtraso = $fechaBase->copy()->addDay();

        $diasAtraso = 0;
        $recargo = 0;

        if ($hoy->greaterThanOrEqualTo($primerDiaAtraso)) {
            $diasAtraso = $primerDiaAtraso->diffInDays($hoy) + 1;

            $recargo = $diasAtraso <= 3 ? 40 : 140;
        }

        return [$diasAtraso, $recargo];
    }

    public function estadoCliente($clienteId)
    {
        $cliente = Cliente::with('ventas')->findOrFail($clienteId);
        $hoy = now()->startOfDay();
        $diaCobro = $cliente->dia_cobro ?? 1;

        $ultimaVenta = $cliente->ventas->sortByDesc('fecha_venta')->first();

        if ($ultimaVenta) {
            $periodoFin = Carbon::parse($ultimaVenta->periodo_fin)->startOfDay();
            $mesAnio = $periodoFin->locale('es')->isoFormat('MMMM [de] YYYY');
            $mesAnio = ucfirst($mesAnio); // capitaliza la primera letra

            if ($hoy->lt($periodoFin)) {
                $diasRestantes = $hoy->diffInDays($periodoFin);
                if ($diasRestantes <= 5) {
                    return response()->json([
                        'estado' => 'proximo',
                        'mensaje' => "Cliente próximo a pagar. Está cubierto hasta {$mesAnio}"
                    ]);
                } else {
                    return response()->json([
                        'estado' => 'corriente',
                        'mensaje' => "Cliente al corriente. Pagado hasta el mes de {$mesAnio}"
                    ]);
                }
            } else {
                return response()->json([
                    'estado' => 'atrasado',
                    'mensaje' => "Cliente con atraso. Su último mes cubierto fue {$mesAnio}"
                ]);
            }
        }

        // Cliente sin ventas previas
        $referencia = $hoy->copy()->day($diaCobro);
        if ($hoy->day <= $diaCobro) {
            $referencia->subMonthNoOverflow();
        }

        $primerDiaAtraso = $referencia->copy()->addDay();
        $mesAnio = $referencia->locale('es')->isoFormat('MMMM [de] YYYY');
        $mesAnio = ucfirst($mesAnio);

        if ($hoy->gte($primerDiaAtraso)) {
            return response()->json([
                'estado' => 'atrasado',
                'mensaje' => "Cliente con atraso desde su día de cobro. Mes pendiente: {$mesAnio}"
            ]);
        } else {
            return response()->json([
                'estado' => 'corriente',
                'mensaje' => "Cliente al corriente. Primer mes de pago: {$mesAnio}"
            ]);
        }
    }



    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return redirect()->route('ventas.historial')->with('success', 'Venta eliminada correctamente.');
    }
}
