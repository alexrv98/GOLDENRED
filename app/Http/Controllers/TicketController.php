<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Venta;
use App\Models\ProfileAssignment;
use App\Models\Profile;


class TicketController extends Controller
{
    public function imprimible(Venta $venta)
    {
        $venta->load('cliente');
        $cliente = $venta->cliente;

        switch ($cliente->tipo) {
            case 'A':
                $view = 'tickets.tipo-a';
                break;
            case 'B':
                $view = 'tickets.tipo-b';
                break;
            case 'C':
                $view = 'tickets.tipo-c';
                break;
            default:
                $view = 'tickets.generico';
                break;
        }

        // Renderizamos la vista a HTML
        $html = view($view, compact('venta', 'cliente'))->render();

        // Devolvemos la vista sin redirección
        return response($html);
    }

    public function reimprimir($id)
    {
        $venta = Venta::with(['cliente.paquete', 'usuario'])->findOrFail($id);
        $cliente = $venta->cliente;

        switch ($cliente->tipo) {
            case 'A':
                $view = 'tickets.tipo-a';
                break;
            case 'B':
                $view = 'tickets.tipo-b';
                break;
            case 'C':
                $view = 'tickets.tipo-c';
                break;
            default:
                $view = 'tickets.generico';
                break;
        }

        $html = view($view, compact('venta', 'cliente'))->render();

        return response($html);
    }

    public function perfil($id)
    {
        $assignment = ProfileAssignment::with('profile.account.platform', 'user')
            ->findOrFail($id);

        return view('tickets.perfil', compact('assignment'));
    }

   public function reimprimirPerfil($profileId)
{
    $assignment = ProfileAssignment::with('profile.account.platform', 'user')
        ->where('profile_id', $profileId)
        ->orderBy('created_at', 'desc')
        ->firstOrFail();

    // Usa la misma vista de impresión
    return view('tickets.perfil', compact('assignment'));
}




}
