<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipo';

    protected $fillable = [
        'cliente_id',
        'marca_antena',
        'modelo_antena',
        'numero_serie_antena',
        'marca_router',
        'modelo_router',
        'numero_serie_router',
    ];

    // Relación con clientes
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}


