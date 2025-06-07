<!-- Modal Crear Usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        {{-- ENCABEZADO --}}
        <div class="modal-header bg-gradient-dark border-bottom border-primary">
          <h5 class="modal-title fw-bold d-flex align-items-center text-white" id="modalCrearUsuarioLabel">
            <i class="material-icons me-2 text-white">person_add</i> Crear Nuevo Usuario
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"
            style="filter: invert(1);"></button>
        </div>

        {{-- CUERPO --}}
        <div class="modal-body">
          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Nombre</label>
            <div class="input-group border rounded">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">badge</i></span>
              <input type="text" name="name" class="form-control border-0" placeholder="Ej. Juan Pérez" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Correo electrónico</label>
            <div class="input-group border rounded">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">email</i></span>
              <input type="email" name="email" class="form-control border-0" placeholder="Ej. juan@example.com" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Contraseña</label>
            <div class="input-group border rounded">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">lock</i></span>
              <input type="password" name="password" class="form-control border-0" placeholder="Mínimo 8 caracteres" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Confirmar Contraseña</label>
            <div class="input-group border rounded">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">lock</i></span>
              <input type="password" name="password_confirmation" class="form-control border-0" placeholder="Repite la contraseña" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold text-dark">Asignar Rol</label>
            <div class="row">
              @foreach ($roles as $role)
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}" id="role{{ $role->id }}" required>
                    <label class="form-check-label" for="role{{ $role->id }}">
                      {{ $role->name }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        {{-- PIE DE MODAL --}}
        <div class="modal-footer border-0">
          <button type="submit" class="btn btn-success">
            <i class="material-icons align-middle">save</i> Guardar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
