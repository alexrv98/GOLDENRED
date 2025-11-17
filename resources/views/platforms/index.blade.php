<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='platforms' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Plataformas" />
        <!-- End Navbar -->
        <div class="card m-4">
            <div class="d-flex platform-grid">
                @foreach($platforms as $platform)
                    <div class="platform-card position-relative">
                        <button type="button" class="delete-platform-btn material-icons" title="Eliminar plataforma"
                            data-bs-toggle="modal" data-bs-target="#modalEliminarPlatform{{ $platform->id }}">
                            delete_forever
                        </button>

                        <a href="{{ route('platforms.accounts', $platform) }}" class="card-link">
                            <div class="card-body text-center d-flex align-items-center justify-content-center flex-column">
                                <i class="material-icons text-lg mb-2">laptop_mac</i>
                                <h5 class="mb-0">{{ $platform->name }}</h5>
                                <small>{{ $platform->accounts_count }} cuentas</small>
                            </div>
                        </a>
                    </div>
                    @include('platforms.partials.modal-delete', ['platform' => $platform])
                @endforeach

                <a href="#" class="platform-card card-link add-new" id="openAddPlatformModal">
                    <div class="card-body text-center d-flex align-items-center justify-content-center flex-column">
                        <i class="material-icons text-lg mb-2">add</i>
                        <h5 class="mb-0">Agregar plataforma</h5>
                    </div>
                </a>
            </div>
            <div id="addPlatformModal" class="modal-elegant-overlay">
                <div class="modal-elegant-content">

                    <button type="button" class="close-button-elegant material-icons" id="closeModalButton">
                        close
                    </button>
                    <div class="modal-elegant-body">
                        <form action="{{ route('platforms.store') }}" method="POST">
                            @csrf
                            <div class="form-group-elegant">
                                <label for="platformName" class="form-label-elegant">Nombre</label>
                                <input type="text" class="form-control-elegant" id="platformName" name="name"
                                    placeholder="Nombre de la plataforma" required>
                            </div>
                            <button type="submit"
                                class="btn btn-success btn-block mt-4 elegant-submit-button">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('platforms.partials.style')
        @include('platforms.partials.scripts')
        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Perfiles Ocupados</h5>
                </div>

                <table id="tabla-perfiles" class="table align-items-center mb-0 w-100">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Plataforma</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Cuenta</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Perfil</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Cliente</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Teléfono</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Asignado desde
                            </th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Pin</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($profiles as $profile)
                            <tr>
                                <td class="text-center">{{ $profile->account->platform->name }}</td>
                                <td class="text-center">{{ $profile->account->email }}</td>
                                <td class="text-center">{{ $profile->name }}</td>
                                <td class="text-center">{{ $profile->current_holder }}</td>
                                <td class="text-center">{{ $profile->telefono ?? '-' }}</td>

                                <td class="text-center">
                                    {{ $profile->assigned_since ? $profile->assigned_since->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="text-center">{{ $profile->notes ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" onclick="reimprimirPerfil({{ $profile->id }})"
                                        class="btn btn-link text-info p-0 mx-1" title="Reimprimir ticket">
                                        <span class="material-icons">print</span>
                                    </a>


                                    <!-- Botón para desocupar -->
                                    <form action="{{ route('account-profiles.unassign', $profile->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link text-warning p-0 mx-1"
                                            title="Desocupar perfil"
                                            onclick="return confirm('¿Seguro que deseas desocupar este perfil?')">
                                            <span class="material-icons">logout</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-xs">No hay perfiles ocupados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div id="iframeReimpresionContainer" style="display:none;"></div>
        



    </main>
</x-layout>