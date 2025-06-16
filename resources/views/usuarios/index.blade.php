<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='usuarios'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Usuarios"></x-navbars.navs.auth>
        <!-- End Navbar -->


        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Lista de Usuarios</h5>
                    @can('Crear usuarios')
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                            <span class="material-icons align-middle">add</span> Agregar Usuario
                        </button>
                    @endcan
                </div>

                <table id="tabla-usuarios" class="table align-items-center mb-0 w-100" style="visibility: hidden;">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Nombre</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Correo
                            </th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 text-center">
                                Roles</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 text-center">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-xs">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-normal mb-0">{{ $user->email }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-secondary text-white text-xs">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="align-middle text-center">
                                    @can('Editar usuarios')
                                        <button class="btn btn-link text-success p-0 mx-1" title="Editar"
                                            data-bs-toggle="modal" data-bs-target="#modalEditarUsuario{{ $user->id }}">
                                            <span class="material-icons">edit</span>
                                        </button>
                                    @endcan

                                    @can('Eliminar usuarios')
                                        <button type="button" class="btn btn-link text-danger p-0 mx-1" data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarUsuario{{ $user->id }}" title="Eliminar">
                                            <span class="material-icons">delete_forever</span>
                                        </button>
                                    @endcan

                                    <!-- Modales de Editar y Eliminar -->
                                    @include('usuarios.modal-edit', ['user' => $user, 'roles' => $roles])
                                    @include('usuarios.modal-delete', ['user' => $user])
                                </td>
                            </tr>
                        @endforeach

                        @if($users->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-xs">No hay usuarios registrados.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para crear usuario -->
        @include('usuarios.modal-create', ['roles' => $roles])

        <!-- Alertas -->
        @include('components.alert-toast')
    </main>
</x-layout>