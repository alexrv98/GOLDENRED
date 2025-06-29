<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ticket</title>
  <style>
    @media print {
  @page { size: 48mm auto; margin: 0; }
  body {
    width: 48mm;
    margin: 0;
    font-family: monospace;
    font-size: 10px;
  }
}


    body { padding: 10px; color: #333; }

    .center { text-align: center; }
    .bold { font-weight: bold; }
    .section { margin-bottom: 10px; }
    .line { border-top: 1px dashed #999; margin: 8px 0; }

    table { width: 100%; font-size: 12px; }
    td { padding: 2px 0; }
    .total { font-size: 14px; font-weight: bold; text-align: right; }
  </style>
</head>
<body onload="window.print();">

  <div class="center section">
    <div class="bold" style="font-size: 15px;">GOLDENRED</div>
    <div>Calle Morolos 63<br>Av. Reforma 34</div>
  </div>

  <div class="section">
    <div class="bold">Datos de Soporte</div>
    <div>
      227-1-16-36-24<br>
      222-496-63-68<br>
      227-115-7b-02<br>
      Horario: 10:00 a.m - 10:00 p.m
    </div>
  </div>

  <div class="line"></div>

  <div class="section">
    <div class="bold">Datos del Ticket</div>
    <table>
      <tr><td>Vendedor:</td><td>{{ $venta->usuario->name ?? '---' }}</td></tr>
      <tr><td>ID Ticket:</td><td>GOLDEN-Internet2025-{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
      <tr><td>Fecha:</td><td>{{ $venta->fecha_venta->format('Y-m-d H:i') }}</td></tr>
      <tr><td>Vencimiento:</td><td>{{ $venta->periodo_fin->format('Y-m-d') }}</td></tr>
      <tr><td>Método de pago:</td><td>{{ $venta->tipo_pago }}</td></tr>
    </table>
  </div>

  <div class="line"></div>

  <div class="section">
    <div class="bold">Datos del Cliente</div>
    <table>
      <tr><td>Nombre:</td><td>{{ $venta->cliente->nombre }}</td></tr>
      <tr><td>Paquete:</td><td>{{ $venta->cliente->paquete->nombre ?? 'Sin paquete' }}</td></tr>
    </table>
  </div>

  <div class="line"></div>

  <div class="section">
    <div class="bold">Detalle de Cobros</div>
    <table>
      <tr><td>Subtotal:</td><td>${{ number_format($venta->subtotal, 2) }}</td></tr>
      <tr><td>Recargo:</td><td>${{ number_format($venta->recargo_falta_pago ?? 0, 2) }}</td></tr>
      <tr><td>Cobro a Domicilio:</td><td>${{ number_format($venta->recargo_domicilio ?? 0, 2) }}</td></tr>
      <tr><td>Descuento:</td><td>-${{ number_format($venta->descuento ?? 0, 2) }}</td></tr>
    </table>
  </div>

  <div class="section total">
    Total a pagar: ${{ number_format($venta->total, 2) }}
  </div>

  <div class="line"></div>

  <div class="center" style="font-size: 11px;">
    ¡Gracias por tu preferencia!<br>
    Este ticket no es fiscal · GOLDENRED © 2025
  </div>
</body>
</html>
