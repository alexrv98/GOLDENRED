@props(['activePage'])


<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main" translate="no">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('alt-dashboard') }} ">
            <img src="{{ asset('assets') }}/img/golden.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">GOLDEN RED</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Páginas</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'alt-dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('alt-dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Inicio</span>
                </a>
            </li>

            @can('Ver usuarios')
                <li class="nav-item">
                    <a class="nav-link text-white {{ in_array($activePage, ['usuarios', 'actividades', 'Roles']) ? 'active bg-gradient-primary' : '' }}"
                        data-bs-toggle="collapse" href="#usuariosSubmenu" role="button" aria-expanded="false"
                        aria-controls="usuariosSubmenu">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                    <div class="collapse {{ in_array($activePage, ['usuarios', 'actividades', 'Roles']) ? 'show' : '' }}"
                        id="usuariosSubmenu">
                        <ul class="nav ms-4 flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'usuarios' ? 'active' : '' }}"
                                    href="{{ route('usuarios.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons opacity-10 me-2">person</i>
                                        <span class="nav-link-text">Ver usuarios</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'Roles' ? 'active' : '' }}"
                                    href="{{ route('roles.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons opacity-10 me-2">admin_panel_settings</i>
                                        <span class="nav-link-text">Ver Roles</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'actividades' ? 'active' : '' }}"
                                    href="{{ route('actividades.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons opacity-10 me-2">history</i>
                                        <span class="nav-link-text">Ver accesos</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan



            @can('Ver clientes')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'clientes' ? ' active bg-gradient-primary' : '' }}"
                        href="{{ route('clientes.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Clientes</span>
                    </a>
                </li>
            @endcan

            @can('Ver paquetes')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'paquetes' ? ' active bg-gradient-primary' : '' }}"
                        href="{{ route('paquetes.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">view_in_ar</i>
                        </div>
                        <span class="nav-link-text ms-1">Paquetes</span>
                    </a>
                </li>
            @endcan

            @can('Ver ventas')
                <li class="nav-item">
                    <a class="nav-link text-white ">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                        </div>
                        <span class="nav-link-text ms-1">Ventas</span>
                    </a>
                </li>
            @endcan

        </ul>
    </div>

</aside>