<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'cliente_id',
        'estado',
        'meses',
        'descuento',
        'recargo_domicilio',
        'recargo_atraso',
        'tipo_pago',
        'fecha_venta',
        'subtotal',
        'total',
        'periodo_inicio',
        'periodo_fin'
    ];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con usuario (encargado)   // Relación hacia el usuario (quien generó la venta)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

}
