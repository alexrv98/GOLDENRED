<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='Roles'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Roles"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Lista de Roles</h5>
                    @can('Crear roles')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearRol">
                        <span class="material-icons align-middle">add</span> Agregar Rol
                    </button>
                    @endcan
                </div>

                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rol</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Permisos del rol</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Colocar primero el rol superadmin
                            $roles = $roles->sortByDesc(function($role) {
                                return $role->name === 'Superadmin';
                            });
                        @endphp

                        @foreach($roles as $role)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="my-auto">
                                        <h6 class="mb-0 text-xs">{{ $role->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-normal mb-0">
                                    @php
                                        $allPermissions = $role->permissions->pluck('name');
                                        $firstFew = $allPermissions->take(3)->join(', ');
                                        $remainingCount = $allPermissions->count() - 3;
                                    @endphp
                                    {{ $firstFew }}@if($remainingCount > 0) y {{ $remainingCount }} más...@endif
                                </p>
                            </td>
                            <td class="acciones-centro">
                                @if($role->name !== 'Superadmin')
                                    @can('Editar roles')
                                    <button class="btn btn-link text-secondary p-0 mx-1" title="Editar"
                                        data-bs-toggle="modal" data-bs-target="#modalEditarRol{{ $role->id }}">
                                        <span class="material-icons">edit</span>
                                    </button>
                                    @endcan
                                    @include('roles.modal-edit', ['role' => $role, 'permissions' => $permissions])

                                    @can('Eliminar roles')
                                    <button type="button" class="btn btn-link text-danger p-0 mx-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEliminarRol{{ $role->id }}" 
                                            title="Eliminar">
                                        <span class="material-icons">delete_forever</span>
                                    </button>
                                    @endcan
                                    @include('roles.modal-delete', ['role' => $role])
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        @include('roles.modal-create')
        @include('components.alert-toast')
    </main>
</x-layout>
