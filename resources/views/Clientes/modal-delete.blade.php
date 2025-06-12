<!-- Modal Eliminar Cliente -->
<div class="modal fade" id="modalEliminarCliente{{ $cliente->id }}" tabindex="-1" aria-labelledby="modalEliminarClienteLabel{{ $cliente->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <!-- ENCABEZADO -->
        <div class="modal-header bg-gradient-dark border-bottom border-danger">
          <h5 class="modal-title fw-bold text-white" id="modalEliminarClienteLabel{{ $cliente->id }}">
            <i class="material-icons me-2 text-white">delete</i> Confirmar Eliminación
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
        </div>

        <!-- CUERPO -->
        <div class="modal-body text-start">
          ¿Estás segura de que deseas eliminar al cliente <strong>{{ $cliente->nombre }}</strong>?
        </div>

        <!-- PIE DE MODAL -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">
            <i class="material-icons align-middle">delete_forever</i> Eliminar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
