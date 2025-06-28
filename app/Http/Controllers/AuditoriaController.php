<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Routing\Controller;

class AuditoriaController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('permission:Ver auditoria')->only(['index', 'show']);
    }
    public function index()
    {
        $logs = Activity::with('causer') // trae el usuario que hizo la acción
            ->latest()
            ->limit(200) // puedes ajustar el límite
            ->get();

        return view('auditoria.index', compact('logs'));
    }
}
