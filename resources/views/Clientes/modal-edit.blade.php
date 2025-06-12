<!-- Modal Editar Cliente -->
<div class="modal fade" id="modalEditarCliente{{ $cliente->id }}" tabindex="-1" aria-labelledby="modalEditarClienteLabel{{ $cliente->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- ENCABEZADO -->
        <div class="modal-header bg-gradient-dark border-bottom border-warning">
          <h5 class="modal-title fw-bold d-flex align-items-center text-white" id="modalEditarClienteLabel{{ $cliente->id }}">
            <i class="material-icons me-2 text-white">edit</i> Editar Cliente: {{ $cliente->nombre }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
        </div>

        <!-- CUERPO -->
        <div class="modal-body text-start">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Nombre</label>
              <input type="text" name="nombre" class="form-control border" value="{{ $cliente->nombre }}" required>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Teléfono 1</label>
              <input type="text" name="telefono1" class="form-control border" value="{{ $cliente->telefono1 }}">
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Teléfono 2</label>
              <input type="text" name="telefono2" class="form-control border" value="{{ $cliente->telefono2 }}">
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Fecha de contrato</label>
              <input type="date" name="fecha_contrato" class="form-control border" value="{{ $cliente->fecha_contrato->format('Y-m-d') }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Día de cobro</label>
              <input type="number" name="dia_cobro" class="form-control border" min="1" max="31" value="{{ $cliente->dia_cobro }}" required>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Paquete</label>
              <select name="paquete_id" class="form-select border">
                <option value="">-- Selecciona un paquete --</option>
                @foreach($paquetes as $paquete)
                  <option value="{{ $paquete->id }}" {{ $cliente->paquete_id == $paquete->id ? 'selected' : '' }}>
                    {{ $paquete->nombre }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Dirección MAC</label>
              <input type="text" name="Mac" class="form-control border" value="{{ $cliente->Mac }}">
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Dirección IP</label>
              <input type="text" name="IP" class="form-control border" value="{{ $cliente->IP }}">
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Dirección</label>
              <input type="text" name="direccion" class="form-control border" value="{{ $cliente->direccion }}">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Coordenadas</label>
              <input type="text" name="coordenadas" class="form-control border" value="{{ $cliente->coordenadas }}">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold text-dark">Referencias</label>
              <textarea name="referencias" class="form-control border" rows="2">{{ $cliente->referencias }}</textarea>
            </div>
          </div>

<!-- Apartado desplegable -->
<details class="mb-3">
  <summary class="fw-bold text-dark">Información del equipo</summary>
  <div class="mt-3">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Marca Antena</label>
        <input type="text" name="equipo[marca_antena]" class="form-control border" value="{{ $cliente->equipos->first()->marca_antena ?? '' }}">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Modelo Antena</label>
        <input type="text" name="equipo[modelo_antena]" class="form-control border" value="{{ $cliente->equipos->first()->modelo_antena ?? '' }}">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Número de Serie Antena</label>
        <input type="text" name="equipo[numero_serie_antena]" class="form-control border" value="{{ $cliente->equipos->first()->numero_serie_antena ?? '' }}">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Marca Router</label>
        <input type="text" name="equipo[marca_router]" class="form-control border" value="{{ $cliente->equipos->first()->marca_router ?? '' }}">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Modelo Router</label>
        <input type="text" name="equipo[modelo_router]" class="form-control border" value="{{ $cliente->equipos->first()->modelo_router ?? '' }}">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Número de Serie Router</label>
        <input type="text" name="equipo[numero_serie_router]" class="form-control border" value="{{ $cliente->equipos->first()->numero_serie_router ?? '' }}">
      </div>
    </div>
  </div>
</details>

        </div>

        <!-- PIE DE MODAL -->
        <div class="modal-footer border-0">
          <button type="submit" class="btn btn-warning">
            <i class="material-icons align-middle">save</i> Actualizar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
