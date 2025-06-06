<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller; 

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Ver roles')->only(['index', 'show']);
        $this->middleware('permission:Crear roles')->only(['create', 'store']);
        $this->middleware('permission:Editar roles')->only(['edit', 'update']);
        $this->middleware('permission:Eliminar roles')->only('destroy');
    }

    public function index()
    {
         $roles = Role::with('permissions')->get();
    $permissions = Permission::all();

    return view('roles.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array'
        ]);

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado.');
    }

    public function destroy($id)
{
    $role = Role::findOrFail($id);

    $usuariosConRol = \DB::table('model_has_roles')
        ->where('role_id', $role->id)
        ->count();

    if ($usuariosConRol > 0) {
        return redirect()->route('roles.index')->with('error', 'No puedes eliminar un rol que está asignado a usuarios.');
    }

    $role->delete();
    return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
}

}
