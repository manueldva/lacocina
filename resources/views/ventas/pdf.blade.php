<!DOCTYPE html>
<html>
<head>
    <style>
        /* Estilos CSS para el PDF */
        /* ... (agrega tus estilos personalizados para el PDF) */
    </style>
</head>
<body>
    <!-- Contenido del PDF -->
    <h1>Ventas de {{ $cliente->persona->apellido }} {{ $cliente->persona->nombre }}</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo Pago</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Pagado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->fecha }}</td>
                    <td>{{ $venta->tipoPago ? $venta->tipoPago->descripcion : 'Sin tipo de pago' }}</td>
                    <td>{{ $venta->cantidadviandas }}</td>
                    <td>{{ $venta->total }}</td>
                    <td>{{ $venta->totalpagado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>