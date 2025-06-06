<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller; 

class UsuariosController extends Controller
{

    public function __construct()
{
    $this->middleware('permission:Ver usuarios')->only(['index', 'show']);
    $this->middleware('permission:Crear usuarios')->only(['create', 'store']);
    $this->middleware('permission:Editar usuarios')->only(['edit', 'update']);
    $this->middleware('permission:Eliminar usuarios')->only('destroy');
}

    public function index()
    {
        return view('usuarios.index');
    }
}
