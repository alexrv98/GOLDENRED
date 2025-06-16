<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='clientes' />
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

                <table id="tabla-clientes" class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Nombre</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Teléfono 1</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Teléfono 2</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Día de cobro</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Referencias</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        {{-- Modal Crear Cliente --}}
        @include('clientes.partials.modal-create') {{-- Aquí debe usarse $paquetes pasado desde el controlador --}}
        @include('components.alert-toast')

        {{-- Modal Dinámico para Editar o Eliminar --}}
        <div class="modal fade" id="modalDinamico" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" id="modal-dialog-dinamico">
                <div class="modal-content" id="contenido-modal"></div>
            </div>
        </div>


    </main>
</x-layout>