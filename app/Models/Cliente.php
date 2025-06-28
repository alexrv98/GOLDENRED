<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Cliente extends Model
{
    use HasFactory, LogsActivity;

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

    protected $casts = [
        'fecha_contrato' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('cliente')
            ->logOnly([
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
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    /**
     * Agrega datos personalizados al log (nombre del cliente).
     */
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->merge([
            'cliente_nombre' => $this->nombre,
        ]);
    }

    public function scopeOnlyBasicFields($query)
    {
        return $query->select('id', 'nombre', 'telefono1', 'fecha_contrato');
    }

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

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
        $ultimaVenta = $this->ventas()->latest()->first();
        return !$ultimaVenta || $ultimaVenta->estado == 'pendiente';
    }
}
