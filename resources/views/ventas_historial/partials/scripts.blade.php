<script>
    let ventaIdActual = null;

    // Evento al hacer clic en los botones de ver venta
    document.querySelectorAll('.btn-ver-venta').forEach(btn => {
        btn.addEventListener('click', function () {
            ventaIdActual = this.dataset.id;

            fetch(`/api/ventas/${ventaIdActual}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error de red');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('detalle_cliente').textContent = data.cliente ?? '—';
                    document.getElementById('detalle_paquete').textContent = data.paquete ?? '—';
                    document.getElementById('detalle_meses').textContent = data.meses ?? '—';
                    document.getElementById('detalle_descuento').textContent = `$${data.descuento ?? '0.00'}`;
                    document.getElementById('detalle_recargo_domicilio').textContent = `$${data.recargo_domicilio ?? '0.00'}`;
                    document.getElementById('detalle_recargo_falta_pago').textContent = `$${data.recargo_falta_pago ?? '0.00'}`;
                    document.getElementById('detalle_total').textContent = `$${data.total ?? '0.00'}`;

                    const modal = new bootstrap.Modal(document.getElementById('modalDetalleVenta'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error al cargar la venta:', error);
                    alert('Hubo un problema al cargar los datos.');
                });
        });
    });

    // Evento para el botón de reimprimir ticket
    document.getElementById('btnReimprimirTicket').addEventListener('click', function () {
        if (ventaIdActual) {
            // Elimina si ya hay un iframe anterior
            document.querySelectorAll('.iframe-impresion-ticket').forEach(el => el.remove());

            // Crea uno nuevo
            const iframe = document.createElement('iframe');
            iframe.src = `/ventas/${ventaIdActual}/ticket`;
            iframe.className = 'iframe-impresion-ticket';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = '0';
            iframe.style.visibility = 'hidden';

            document.body.appendChild(iframe);

        } else {
            alert('Primero selecciona una venta válida.');
        }
    });

    // Limpieza de fondo al cerrar modal
    document.getElementById('modalDetalleVenta').addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        document.body.style = '';
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(b => b.remove());
    });
</script>

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