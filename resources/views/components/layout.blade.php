@props(['bodyClass'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Golden Red</title>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- DataTables + Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
</head>

<body class="{{ $bodyClass }}">

    {{ $slot }}

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    @stack('js')
    <script>
        if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
        }
    </script>
    <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.0') }}"></script>

    <!-- jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function () {
            // Actividades
            $('#tabla-actividades').DataTable({
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

            // Usuarios
            $('#tabla-usuarios').DataTable({
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                },
                columnDefs: [
                    { orderable: false, targets: 3 }
                ],
                initComplete: function () {
                    $('#tabla-usuarios').css('visibility', 'visible');
                }
            });

            // Roles
            $('#tabla-roles').DataTable({
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                },
                columnDefs: [
                    { orderable: false, targets: 2 }
                ],
                order: [],
                initComplete: function () {
                    $('#tabla-roles').css('visibility', 'visible');
                }
            });

            // Clientes
            $('#tabla-clientes').DataTable({
                processing: false,
                serverSide: true,
                deferRender: true,
                ajax: '{{ route("clientes.data") }}',
                columns: [
                    { data: 'nombre', name: 'nombre' },
                    { data: 'telefono1', name: 'telefono1' },
                    { data: 'telefono2', name: 'telefono2' },
                    { data: 'dia_cobro', name: 'dia_cobro' },
                    { data: 'referencias', name: 'referencias' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ]
            });

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
