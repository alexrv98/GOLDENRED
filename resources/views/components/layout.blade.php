@props(['bodyClass'])
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Golden Red</title>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- DataTables + Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Estilos personalizados -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
</head>

<body class="{{ $bodyClass }}">
    {{ $slot }}

    <!-- jQuery (necesario para Bootstrap y DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" defer></script>

    <!-- Core JS -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.0') }}" defer></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" defer></script>

    @stack('js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Scrollbar lateral para Windows
            if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
            }

            // Actividades (serverSide)
            const tablaActividades = $('#tabla-actividades');
            if (tablaActividades.length) {
                tablaActividades.DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: '{{ route("actividades.data") }}',
                    deferRender: true,
                    pageLength: 10,
                    columns: [
                        { data: 'usuario', name: 'users.name' },
                        { data: 'ip', name: 'actividades.ip' },
                        { data: 'dispositivo', name: 'actividades.dispositivo' },
                        { data: 'fecha', name: 'actividades.fecha' },
                        { data: 'hora_entrada', name: 'actividades.hora_entrada' },
                        { data: 'hora_salida', name: 'actividades.hora_salida' }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                    }
                });
            }

            // Usuarios
            const tablaUsuarios = $('#tabla-usuarios');
            if (tablaUsuarios.length) {
                tablaUsuarios.DataTable({
                    pageLength: 10,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                    },
                    columnDefs: [
                        { orderable: false, targets: 3 }
                    ],
                    initComplete: function () {
                        tablaUsuarios.removeClass('d-none');
                    }
                });
            }

            // Roles
            const tablaRoles = $('#tabla-roles');
            if (tablaRoles.length) {
                tablaRoles.DataTable({
                    pageLength: 10,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                    },
                    columnDefs: [
                        { orderable: false, targets: 2 }
                    ],
                    order: [],
                    initComplete: function () {
                        tablaRoles.removeClass('d-none');
                    }
                });
            }

            // Clientes
            const tablaClientes = $('#tabla-clientes');
            if (tablaClientes.length) {
                tablaClientes.DataTable({
                    pageLength: 10,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                    },
                    columnDefs: [
                        { orderable: false, targets: 5 }
                    ],
                    order: [],
                    initComplete: function () {
                        $('#loader-clientes').remove();
                        tablaClientes.removeClass('d-none');
                    }
                });
            }

            // Modales dinámicos
            $(document).on('click', '.btn-modal', function () {
                const url = $(this).data('url');
                $('#contenido-modal').html('<div class="text-center p-4">Cargando...</div>');

                $.get(url, function (html) {
                    $('#contenido-modal').html(html);
                    const dialog = $('#modal-dialog-dinamico');

                    if (url.includes('delete')) {
                        dialog.removeClass('modal-lg').addClass('modal-dialog-centered').css('max-width', '500px');
                    } else {
                        dialog.removeClass('modal-dialog-centered').addClass('modal-lg').css('max-width', '');
                    }

                    $('#modalDinamico').modal('show');
                });
            });
        });
    </script>
</body>

</html>