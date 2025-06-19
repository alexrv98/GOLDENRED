<script>
document.addEventListener('DOMContentLoaded', () => {
    const busquedaInput = document.getElementById('busqueda_cliente');
    const resultadosUl = document.getElementById('resultados_cliente');
    const clienteIdInput = document.getElementById('cliente_id');
    const datosClienteDiv = document.getElementById('datosCliente');

    let timeout = null;

    busquedaInput.addEventListener('input', () => {
        const query = busquedaInput.value.trim();
        resultadosUl.innerHTML = '';
        if (query.length < 2) return;

        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fetch(`/ventas/buscar-clientes?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    resultadosUl.innerHTML = '';
                    (data.results || []).forEach(cliente => {
                        const li = document.createElement('li');
                        li.textContent = cliente.text;
                        li.classList.add('list-group-item', 'list-group-item-action');
                        li.dataset.id = cliente.id;
                        li.dataset.nombre = cliente.text;
                        li.dataset.paqueteNombre = cliente.paquete.nombre;
                        li.dataset.paquetePrecio = cliente.paquete.precio;
                        resultadosUl.appendChild(li);
                    });
                });
        }, 300); // Espera 300ms
    });

    resultadosUl.addEventListener('click', e => {
        if (!e.target.matches('li')) return;

        const li = e.target;
        busquedaInput.value = li.dataset.nombre;
        clienteIdInput.value = li.dataset.id;
        resultadosUl.innerHTML = '';

        // Mostrar y llenar datos
        datosClienteDiv.classList.remove('d-none');
        document.getElementById('nombre_cliente').value = li.dataset.nombre;
        document.getElementById('nombre_paquete').value = li.dataset.paqueteNombre;
        document.getElementById('precio_paquete').value = li.dataset.paquetePrecio;

        document.getElementById('meses').value = 1;
        document.getElementById('descuento').value = 0;
        document.getElementById('recargo_domicilio').value = 0;
        document.getElementById('recargo_falta_pago').value = 0;
        document.getElementById('info_falta_pago').textContent = '';

        obtenerRecargoReal(li.dataset.id);
        calcularTotal();
    });

    ['meses', 'descuento', 'recargo_domicilio', 'recargo_falta_pago'].forEach(id => {
        document.getElementById(id).addEventListener('input', calcularTotal);
    });

    function calcularTotal() {
        const precio = parseFloat(document.getElementById('precio_paquete').value || 0);
        const meses = parseInt(document.getElementById('meses').value || 1);
        const descuento = parseFloat(document.getElementById('descuento').value || 0);
        const domicilio = parseFloat(document.getElementById('recargo_domicilio').value || 0);
        const falta = parseFloat(document.getElementById('recargo_falta_pago').value || 0);

        const subtotal = precio * meses;
        document.getElementById('subtotal').value = subtotal.toFixed(2);
        const total = subtotal - descuento + domicilio + falta;
        document.getElementById('total').value = total.toFixed(2);
    }

    function obtenerRecargoReal(clienteId) {
        fetch(`/ventas/recargo/${clienteId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('recargo_falta_pago').value = data.recargo.toFixed(2);
                document.getElementById('info_falta_pago').textContent =
                    data.dias_atraso > 0 ? `Días de atraso: ${data.dias_atraso}` : 'Sin atraso';
                calcularTotal();
            });
    }
});
</script>
