<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='ventas' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Generar Venta" />

        <div class="card m-4 p-4">
            <h5>Generar Venta</h5>

            <form id="formCrearVenta" action="{{ route('ventas.store') }}" method="POST">
                @csrf

                <div class="col-md-8 mb-3 position-relative">
                    <label class="form-label fw-bold text-dark">Buscar Cliente por Nombre</label>
                    <select id="busqueda_cliente" class="form-control"></select>
                    <small id="estadoCliente" class="text-muted d-block mt-1"></small>

                    <input type="hidden" name="cliente_id" id="cliente_id">
                </div>

                <div id="datosCliente">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <input type="text" id="nombre_cliente" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Paquete</label>
                            <input type="text" id="nombre_paquete" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Precio paquete</label>
                            <input type="number" id="precio_paquete" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Meses</label>
                            <select name="meses" id="meses" class="form-select" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Descuento</label>
                            <input type="number" name="descuento" id="descuento" class="form-control" value="0">
                        </div>
                        <div class="col-md-4">
                            <label>Recargo domicilio</label>
                            <input type="number" name="recargo_domicilio" id="recargo_domicilio" class="form-control"
                                value="0">
                        </div>
                        <div class="col-md-4">
                            <label>Recargo falta pago</label>
                            <input type="number" name="recargo_falta_pago" id="recargo_falta_pago" class="form-control"
                                readonly>
                            <small id="info_falta_pago" class="d-block mt-1"></small>
                        </div>

                        <div class="col-md-4">
                            <label>Subtotal</label>
                            <input type="number" id="subtotal" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Total</label>
                            <input type="number" id="total" class="form-control" readonly>
                        </div>
                    </div>

                    <button type="button" id="btnConfirmarVenta" class="btn btn-primary">Generar Venta</button>
                </div>
            </form>
        </div>

        <!-- Historial -->
        <div class="card m-4 p-4">
            <h5>Historial de Ventas de Hoy</h5>

            @if($ventasHoy->isEmpty())
                <p>No hay ventas registradas hoy.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Fecha Venta</th>
                            <th>Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventasHoy as $venta)
                            <tr>
                                <td>{{ $venta->cliente->nombre }}</td>
                                <td>{{ $venta->usuario->name }}</td>
                                <td>{{ $venta->fecha_venta }}</td>
                                <td>${{ number_format($venta->total, 2) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-link text-info p-0 mx-1 btn-ver-venta" title="Ver"
                                        data-id="{{ $venta->id }}" data-bs-toggle="modal" data-bs-target="#modalDetalleVenta">
                                        <span class="material-icons">visibility</span>
                                    </button>
                                    <button type="button" class="btn btn-link text-danger p-0 mx-1 btn-modal-eliminar"
                                        data-id="{{ $venta->id }}" data-cliente="{{ $venta->cliente->nombre }}"
                                        title="Eliminar">
                                        <span class="material-icons">delete_forever</span>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="#" class="btn btn-secondary">Ver historial completo</a>
        </div>
    </main>
    @include('ventas.partials.scripts')
    @include('ventas.partials.modal-confirmacion')
    @include('components.alert-toast')
    @include('ventas_historial.partials.modal-confirmacion')
    @include('ventas_historial.partials.scripts')
    @include('ventas_historial.partials.modal-eliminar')


</x-layout>