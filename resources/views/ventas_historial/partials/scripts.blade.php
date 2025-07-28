<script>
    document.querySelectorAll('.btn-ver-venta').forEach(btn => {
        btn.addEventListener('click', function () {
            const ventaId = this.dataset.id;

            fetch(`/api/ventas/${ventaId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detalle_cliente').textContent = data.cliente;
                    document.getElementById('detalle_paquete').textContent = data.paquete;
                    document.getElementById('detalle_meses').textContent = data.meses;
                    document.getElementById('detalle_descuento').textContent = `$${data.descuento}`;
                    document.getElementById('detalle_recargo_domicilio').textContent = `$${data.recargo_domicilio}`;
                    document.getElementById('detalle_recargo_falta_pago').textContent = `$${data.recargo_falta_pago}`;
                    document.getElementById('detalle_total').textContent = `$${data.total}`;
                })
                .catch(error => {
                    console.error('Error al obtener datos de la venta:', error);
                });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Botones que abren la modal
        document.querySelectorAll('.btn-modal-eliminar').forEach(btn => {
            btn.addEventListener('click', function () {
                const ventaId = this.getAttribute('data-id');
                const cliente = this.getAttribute('data-cliente');

                // Mostrar nombre del cliente en el mensaje
                document.getElementById('nombreClienteEliminar').textContent = cliente;

                // Actualizar la acción del formulario
                const form = document.getElementById('formEliminarVenta');
                form.setAttribute('action', `/ventas/${ventaId}`);

                // Mostrar la modal
                const modal = new bootstrap.Modal(document.getElementById('modalEliminarVenta'));
                modal.show();
            });
        });
    });

    @push('scripts')
            <script>
                const tablaVentas = $('#tabla-ventas');
                if (tablaVentas.length) {
                    tablaVentas.DataTable({
                        pageLength: 10,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                        },
                        columnDefs: [
                            { orderable: false, targets: 4 }
                        ],
                        initComplete: function () {
                            tablaVentas.removeClass('d-none');
                        }
                    });
            }
        </script>
    @endpush


</script>