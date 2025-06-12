<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='clientes'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Clientes" />

        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Lista de Clientes</h5>
                    @can('Crear clientes')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCliente">
                        <span class="material-icons align-middle">add</span> Agregar Cliente
                    </button>
                    @endcan
                </div>

                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Teléfono 1</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Teléfono 2</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Día</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Referencias</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                        <tr>
                            <td><h6 class="mb-0 text-xs">{{ $cliente->nombre }}</h6></td>
                            <td><p class="text-xs mb-0">{{ $cliente->telefono1 }}</p></td>
                            <td><p class="text-xs mb-0">{{ $cliente->telefono2 }}</p></td>
                            <td><p class="text-xs mb-0">{{ $cliente->dia_cobro }}</p></td>
                            <td><p class="text-xs mb-0">{{ $cliente->referencias }}</p></td>
                            <td class="align-middle text-center">
                                @can('Editar clientes')
                                <button class="btn btn-link text-secondary p-0 mx-1" title="Editar"
                                    data-bs-toggle="modal" data-bs-target="#modalEditarCliente{{ $cliente->id }}">
                                    <span class="material-icons">edit</span>
                                </button>
                                @endcan

                                @can('Eliminar  clientes')
                                <button class="btn btn-link text-danger p-0 mx-1" title="Eliminar"
                                    data-bs-toggle="modal" data-bs-target="#modalEliminarCliente{{ $cliente->id }}">
                                    <span class="material-icons">delete_forever</span>
                                </button>
                                @endcan

                                <!-- Modales -->
                                @include('clientes.modal-edit', ['cliente' => $cliente])
                                @include('clientes.modal-delete', ['cliente' => $cliente])
                            </td>
                        </tr>
                        @endforeach

                        @if($clientes->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-xs">No hay clientes registrados.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para crear cliente -->
        @include('clientes.modal-create')
        @include('components.alert-toast')
    </main>
</x-layout>
