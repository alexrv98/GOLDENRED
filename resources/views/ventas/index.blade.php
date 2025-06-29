<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='ventas' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Generar Venta" />

        <div class="card m-4 p-4">
            <h5>Generar Venta</h5>

            <form id="formCrearVenta" action="{{ route('ventas.store') }}" method="POST">
                @csrf

                {{-- Buscar Cliente --}}
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">
                        <span class="material-icons-round align-middle me-1">search</span> Buscar Cliente
                    </label>
                    <select id="busqueda_cliente" class="form-control border rounded-2"></select>
                    <small id="estadoCliente" class="text-muted d-block mt-1"></small>
                    <input type="hidden" name="cliente_id" id="cliente_id">
                </div>

                <div id="datosCliente" class="border-top pt-3">
                    {{-- Información Cliente --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <span class="material-icons-round align-middle me-1">person</span> Cliente
                            </label>
                            <input type="text" id="nombre_cliente" class="form-control border rounded-2 px-2" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <span class="material-icons-round align-middle me-1">inventory_2</span> Paquete
                            </label>
                            <input type="text" id="nombre_paquete" class="form-control border rounded-2 px-2" readonly>
                        </div>
                    </div>

                    {{-- Configuración Venta --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Precio</label>
                            <input type="number" id="precio_paquete" class="form-control border rounded-2 px-2"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Meses</label>
                            <select name="meses" id="meses" class="form-select border rounded-2 px-2" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tipo de Pago</label>
                            <select name="tipo_pago" id="tipo_pago" class="form-select border rounded-2 px-2" required>
                                <option value="">Seleccione...</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>
                    </div>

                    {{-- Ajustes --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Descuento</label>
                            <input type="number" name="descuento" id="descuento"
                                class="form-control border rounded-2 px-2" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Recargo Domicilio</label>
                            <input type="number" name="recargo_domicilio" id="recargo_domicilio"
                                class="form-control border rounded-2 px-2" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Recargo Falta Pago</label>
                            <input type="number" name="recargo_falta_pago" id="recargo_falta_pago"
                                class="form-control border rounded-2 px-2" readonly>
                            <small id="info_falta_pago" class="text-muted d-block mt-1"></small>
                        </div>
                    </div>

                    {{-- Resumen --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Subtotal</label>
                            <input type="number" id="subtotal" class="form-control border rounded-2 px-2" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total</label>
                            <input type="number" id="total" class="form-control border rounded-2 px-2" readonly>
                        </div>
                    </div>

                    {{-- Botón --}}
                    <div class="text-end">
                        <button type="button" id="btnConfirmarVenta" class="btn btn-primary">
                            <span class="material-icons-round align-middle me-1">check_circle</span> Generar Venta
                        </button>
                    </div>
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
                            <th>Método de pago</th>
                            <th>Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventasHoy as $venta)
                            <tr>
                                <td>{{ $venta->cliente->nombre }}</td>
                                <td>{{ $venta->usuario->name }}</td>
                                <td>{{ $venta->created_at->format('Y-m-d') }} <br><small>{{ $venta->created_at->format('h:i A') }}</small></td>
                                <td>{{ ucfirst($venta->tipo_pago ?? 'N/A') }}</td> 
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

    @if(session('venta_id_para_imprimir'))
    <iframe
        src="{{ route('ticket.imprimible', session('venta_id_para_imprimir')) }}"
        style="width:0;height:0;border:0;visibility:hidden;">
    </iframe>
@endif



</x-layout>