<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'telefono1',
        'telefono2',
        'fecha_contrato',
        'dia_cobro',
        'paquete_id',
        'Mac',
        'IP',
        'direccion',
        'coordenadas',
        'referencias',
        'torre', 
        'panel',
    ];

    /**
     * Casts de atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_contrato' => 'date',
    ];

    /**
     * Scope personalizado para listar campos básicos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyBasicFields($query)
    {
        return $query->select('id', 'nombre', 'telefono1', 'fecha_contrato');
    }

    /**
     * Relación con el modelo Paquete.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    /**
     * Relación con el modelo Equipo.
     *
     * Un cliente puede tener varios equipos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function ventaPendiente()
    {
        // aquí va tu lógica de control para saber si ya pagó el mes actual
        $ultimaVenta = $this->ventas()->latest()->first();
        return !$ultimaVenta || $ultimaVenta->estado == 'pendiente';
    }

}
