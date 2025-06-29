<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Venta;


class TicketController extends Controller
{
public function imprimible(Venta $venta)
{
    $venta->load('cliente');

    return view('tickets.imprimible', compact('venta'));
}


}
