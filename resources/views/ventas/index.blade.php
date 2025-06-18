<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='ventas' />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <x-navbars.navs.auth titlePage="Ventas" />

        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Generar Ventas</h5>
                </div>

                {{-- Loader --}}
                <div id="loader-ventas" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

                @if (!$clientes->isEmpty())
                    <table id="tabla-ventas" class="table align-items-center mb-0 w-100 d-none">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nombre</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Teléfono 1</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Teléfono 2</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Estado</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>
                                        <h6 class="mb-0 text-xs">{{ $cliente->nombre }}</h6>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $cliente->telefono1 }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0">{{ $cliente->telefono2 }}</p>
                                    </td>
                                    <td>
                                        @if ($cliente->estado_pago === 'pendiente')
                                            <span class="badge bg-danger text-white">Pendiente</span>
                                        @else
                                            <span class="badge bg-success text-white">Pagado</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($cliente->estado_pago == 'pendiente')
                                            <button class="btn btn-primary btn-sm generar-venta-btn"
                                                data-cliente-id="{{ $cliente->id }}">
                                                Generar Venta
                                            </button>
                                        @else
                                            <span class="badge bg-success">Pagado</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-xs py-4">
                        No hay clientes registrados.
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal dinámico para cargar el formulario de venta --}}
        <div class="modal fade" id="modalDinamico" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" id="modal-dialog-dinamico">
                <div class="modal-content" id="contenido-modal"></div>
            </div>
        </div>
    </main>
</x-layout>

@include('ventas.partials.modal-create')