@can('Editar clientes')
<button class="btn btn-link text-secondary p-0 mx-1 btn-modal"
        title="Editar" data-url="{{ route('clientes.edit-modal', $cliente->id) }}">
    <span class="material-icons">edit</span>
</button>

@endcan

@can('Eliminar clientes')
<button class="btn btn-link text-danger p-0 mx-1 btn-modal"
        title="Eliminar" data-url="{{ route('clientes.delete-modal', $cliente->id) }}">
    <span class="material-icons">delete_forever</span>
</button>

@endcan
