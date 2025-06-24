<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        // Según el permiso, retorna una vista distinta
        if ($user->can('Ver dashboard')) {
            return view('dashboard.index'); // Vista con todo el contenido
        }

        return view('dashboard.limitado'); // Vista restringida
    }
}
