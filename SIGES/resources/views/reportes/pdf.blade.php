<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1, h2, h3 {
            margin: 0 0 8px 0;
        }

        .muted {
            color: #6B7280;
        }

        .header {
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #D1D5DB;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin: 14px 0 18px 0;
        }

        .summary td {
            border: 1px solid #E5E7EB;
            padding: 8px;
        }

        .summary td:first-child {
            background: #F9FAFB;
            font-weight: bold;
            width: 35%;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #D1D5DB;
            padding: 8px;
            text-align: left;
        }

        table.data th {
            background: #111827;
            color: #fff;
        }

        .section {
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $reportTitle }}</h1>
        <div class="muted">SIGES - Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    @if($reporteChofer)
        <div class="section">
            <h2>Chofer</h2>
            <table class="summary">
                <tr><td>Nombre</td><td>{{ $reporteChofer['chofer']->usuario?->name }}</td></tr>
                <tr><td>Vehículo</td><td>{{ $reporteChofer['chofer']->vehiculo?->placa ?? 'Sin unidad' }}</td></tr>
                <tr><td>Pagos</td><td>{{ $reporteChofer['total_pagos'] }}</td></tr>
                <tr><td>Total ingresos</td><td>${{ number_format((float) $reporteChofer['total_ingresos'], 2, ',', '.') }}</td></tr>
            </table>

            <table class="data">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteChofer['pagos'] as $pago)
                        <tr>
                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td>${{ number_format((float) $pago->monto_pago, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($reporteUnidad)
        <div class="section">
            <h2>Unidad de taxi</h2>
            <table class="summary">
                <tr><td>Unidad</td><td>{{ $reporteUnidad['vehiculo']->placa ?? $reporteUnidad['vehiculo']->matricula }}</td></tr>
                <tr><td>Vehículo</td><td>{{ $reporteUnidad['vehiculo']->marca }} {{ $reporteUnidad['vehiculo']->modelo }}</td></tr>
                <tr><td>Pagos</td><td>{{ $reporteUnidad['total_pagos'] }}</td></tr>
                <tr><td>Total ingresos</td><td>${{ number_format((float) $reporteUnidad['total_ingresos'], 2, ',', '.') }}</td></tr>
            </table>

            <table class="data">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Chofer</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteUnidad['pagos'] as $pago)
                        <tr>
                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td>{{ $pago->chofer->usuario?->name ?? 'Chofer no disponible' }}</td>
                            <td>${{ number_format((float) $pago->monto_pago, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($reporteRango)
        <div class="section">
            <h2>Rango de fechas</h2>
            <table class="summary">
                <tr><td>Periodo</td><td>{{ $reporteRango['fecha_inicio']->format('d/m/Y') }} - {{ $reporteRango['fecha_fin']->format('d/m/Y') }}</td></tr>
                <tr><td>Pagos</td><td>{{ $reporteRango['total_pagos'] }}</td></tr>
                <tr><td>Total ingresos</td><td>${{ number_format((float) $reporteRango['total_ingresos'], 2, ',', '.') }}</td></tr>
            </table>

            <table class="data">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Chofer</th>
                        <th>Unidad</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteRango['pagos'] as $pago)
                        <tr>
                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td>{{ $pago->chofer->usuario?->name ?? 'Chofer no disponible' }}</td>
                            <td>{{ $pago->chofer->vehiculo?->placa ?? 'Sin unidad' }}</td>
                            <td>${{ number_format((float) $pago->monto_pago, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($reporteSemanal)
        <div class="section">
            <h2>Resumen semanal</h2>
            <table class="summary">
                <tr><td>Semanas registradas</td><td>{{ $reporteSemanal->count() }}</td></tr>
                <tr><td>Total acumulado</td><td>${{ number_format($reporteSemanal->sum('total_ingresos'), 2, ',', '.') }}</td></tr>
            </table>

            <table class="data">
                <thead>
                    <tr>
                        <th>Semana</th>
                        <th>Pagos</th>
                        <th>Total ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteSemanal as $fila)
                        <tr>
                            <td>{{ $fila['inicio_semana']->format('d/m/Y') }} - {{ $fila['fin_semana']->format('d/m/Y') }}</td>
                            <td>{{ $fila['total_pagos'] }}</td>
                            <td>${{ number_format((float) $fila['total_ingresos'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($reporteInventarioCompras)
        <div class="section">
            <h2>Inventario y compras</h2>
            <table class="summary">
                <tr><td>Piezas registradas</td><td>{{ $reporteInventarioCompras['total_piezas'] }}</td></tr>
                <tr><td>Existencias totales</td><td>{{ $reporteInventarioCompras['existencias_totales'] }}</td></tr>
                <tr><td>Compras registradas</td><td>{{ $reporteInventarioCompras['total_compras'] }}</td></tr>
                <tr><td>Costo total compras</td><td>${{ number_format((float) $reporteInventarioCompras['costo_total_compras'], 2, ',', '.') }}</td></tr>
            </table>

            <h3>Existencias actuales</h3>
            <table class="data">
                <thead>
                    <tr>
                        <th>Pieza</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteInventarioCompras['inventarios'] as $item)
                        <tr>
                            <td>{{ $item->nombre_pieza }}</td>
                            <td>{{ $item->tipo_pieza }}</td>
                            <td>{{ $item->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Historial de compras</h3>
            <table class="data">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Pieza</th>
                        <th>Cantidad</th>
                        <th>Costo unitario</th>
                        <th>Costo total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteInventarioCompras['compras'] as $compra)
                        <tr>
                            <td>{{ $compra->fecha->format('d/m/Y') }}</td>
                            <td>{{ $compra->inventario?->nombre_pieza ?? 'Pieza eliminada' }}</td>
                            <td>{{ $compra->cantidad_compra }}</td>
                            <td>${{ number_format((float) $compra->precio_unitario, 2, ',', '.') }}</td>
                            <td>${{ number_format((float) $compra->precio_unitario * (int) $compra->cantidad_compra, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</body>
</html>