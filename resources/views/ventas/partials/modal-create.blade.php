<div class="modal fade" id="modalCrearVenta" tabindex="-1" aria-labelledby="modalCrearVentaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formCrearVenta" action="{{ route('ventas.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="cliente_id" id="cliente_id">

                    <div class="mb-3">
                        <label for="meses" class="form-label">Meses a pagar</label>
                        <input type="number" name="meses" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="descuento" class="form-label">Descuento</label>
                        <input type="number" name="descuento" class="form-control" min="0" step="0.01" value="0">
                    </div>

                    <div class="mb-3">
                        <label for="recargo_domicilio" class="form-label">Recargo por cobro a domicilio</label>
                        <input type="number" name="recargo_domicilio" class="form-control" min="0" step="0.01" value="0">
                    </div>

                    <div class="mb-3">
                        <label for="recargo_falta_pago" class="form-label">Recargo por falta de pago</label>
                        <input type="number" name="recargo_falta_pago" class="form-control" min="0" step="0.01" value="0">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Generar Venta</button>
                </div>
            </div>
        </form>
    </div>
</div>
