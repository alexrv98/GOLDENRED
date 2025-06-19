<div class="modal fade" id="modalCrearVenta" tabindex="-1" aria-labelledby="modalCrearVentaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form id="formCrearVenta" action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <!-- ENCABEZADO -->
        <div class="modal-header bg-gradient-dark border-bottom border-primary">
          <h5 class="modal-title fw-bold d-flex align-items-center text-white">
            <i class="material-icons me-2 text-white">shopping_cart</i> Generar Venta
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
        </div>

        <!-- CUERPO -->
        <div class="modal-body">
          <input type="hidden" name="cliente_id" id="cliente_id">

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Cliente</label>
              <input type="text" id="nombre_cliente" class="form-control border" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Paquete</label>
              <input type="text" id="nombre_paquete" class="form-control border" readonly>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Precio del paquete</label>
              <input type="number" id="precio_paquete" class="form-control border" readonly>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Meses a pagar</label>
              <select name="meses" id="meses" class="form-select border" required>
                @for ($i = 1; $i <= 12; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Descuento</label>
              <input type="number" name="descuento" id="descuento" class="form-control border" min="0" step="0.01" value="0">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Recargo por cobro a domicilio</label>
              <input type="number" name="recargo_domicilio" id="recargo_domicilio" class="form-control border" min="0" step="0.01" value="0">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Recargo por falta de pago</label>
              <input type="number" name="recargo_falta_pago" id="recargo_falta_pago" class="form-control border" readonly>
              <small id="info_falta_pago" class="text-muted"></small>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Subtotal</label>
              <input type="number" id="subtotal" class="form-control border" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Total</label>
              <input type="number" id="total" class="form-control border" readonly>
            </div>
          </div>
        </div>

        <!-- PIE -->
        <div class="modal-footer border-0">
          <button type="submit" class="btn btn-primary">
            <i class="material-icons align-middle">attach_money</i> Generar Venta
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
