@extends('layouts.app')

@section('title', 'Reportes - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    @if(request('reporte'))
        <a href="{{ route('reportes.pdf', request()->query()) }}" class="button-secondary">Descargar PDF</a>
    @endif
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Reportes</p>
            <h1>Reportes de pagos e ingresos</h1>
            <p class="hero-copy">Genera reportes por chofer, por unidad de taxi, por rango de fechas y un resumen semanal de los ingresos registrados.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h2>Selecciona el tipo de reporte</h2>
                <p>Elige una opción y se mostrarán únicamente los campos necesarios para ese reporte.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="GET" action="{{ route('reportes.index') }}" id="reportes-form">
            <div class="field-grid">
                <div class="field-card" style="grid-column: 1 / -1;">
                    <label class="field-label">Tipo de reporte</label>
                    <select name="reporte" id="reporte-select" required>
                        <option value="">Selecciona una opción</option>
                        <option value="chofer" @selected(request('reporte') === 'chofer')>Reporte de pagos por chofer</option>
                        <option value="unidad" @selected(request('reporte') === 'unidad')>Reporte de pagos por unidad de taxi</option>
                        <option value="fechas" @selected(request('reporte') === 'fechas')>Reporte de pagos por rango de fechas</option>
                        <option value="semanal" @selected(request('reporte') === 'semanal')>Reporte semanal del total de ingresos registrados</option>
                        <option value="inventario_compras" @selected(request('reporte') === 'inventario_compras')>Reporte de inventario y compras</option>
                    </select>
                </div>
            </div>

            <div id="report-fields-chofer" class="report-fields" data-report-fields="chofer">
                <div class="field-grid">
                    <div class="field-card" style="grid-column: 1 / -1;">
                        <label class="field-label">Chofer</label>
                        <select name="id_chofer">
                            <option value="">Selecciona un chofer</option>
                            @foreach($choferes as $chofer)
                                <option value="{{ $chofer->id_chofer }}" {{ (string) request('id_chofer') === (string) $chofer->id_chofer ? 'selected' : '' }}>
                                    {{ $chofer->usuario?->name ?? 'Chofer' }} - {{ $chofer->identificacion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="report-fields-unidad" class="report-fields" data-report-fields="unidad">
                <div class="field-grid">
                    <div class="field-card" style="grid-column: 1 / -1;">
                        <label class="field-label">Unidad</label>
                        <select name="matricula">
                            <option value="">Selecciona una unidad</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->matricula }}" {{ (string) request('matricula') === (string) $vehiculo->matricula ? 'selected' : '' }}>
                                    {{ $vehiculo->placa ?? 'Unidad' }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="report-fields-fechas" class="report-fields" data-report-fields="fechas">
                <div class="field-grid">
                    <div class="field-card">
                        <label class="field-label">Fecha inicial</label>
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="field-card">
                        <label class="field-label">Fecha final</label>
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}">
                    </div>
                </div>
            </div>

            <div id="report-fields-semanal" class="report-fields" data-report-fields="semanal">
                <div class="field-card" style="grid-column: 1 / -1;">
                    <p class="section-copy" style="margin-top: 0;">Este reporte no requiere filtros. Solo genera el resumen semanal de los ingresos registrados.</p>
                </div>
            </div>

            <div id="report-fields-inventario-compras" class="report-fields" data-report-fields="inventario_compras">
                <div class="field-card" style="grid-column: 1 / -1;">
                    <p class="section-copy" style="margin-top: 0;">Este reporte no requiere filtros. Genera existencias actuales y el historial completo de compras.</p>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" class="button-primary" id="report-submit">Generar reporte</button>
            </div>
        </form>
    </section>

    @if($reporteChofer)
        <section class="panel" style="margin-top: 24px;">
            <div class="panel-header">
                <div class="panel-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h2>Reporte de pagos por chofer</h2>
                    <p>Resultados para {{ $reporteChofer['chofer']->usuario?->name }}.</p>
                </div>
            </div>

            <div class="panel-separator"></div>
            <div class="field-grid">
                <div class="field-card"><span class="field-label">Chofer</span><p>{{ $reporteChofer['chofer']->usuario?->name }}</p></div>
                <div class="field-card"><span class="field-label">Vehículo</span><p>{{ $reporteChofer['chofer']->vehiculo?->placa ?? 'Sin unidad' }}</p></div>
                <div class="field-card"><span class="field-label">Pagos</span><p>{{ $reporteChofer['total_pagos'] }}</p></div>
                <div class="field-card"><span class="field-label">Total ingresos</span><p>${{ number_format((float) $reporteChofer['total_ingresos'], 2, ',', '.') }}</p></div>
            </div>

            <div class="panel-separator"></div>
            <table>
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
        </section>
    @endif

    @if($reporteUnidad)
        <section class="panel" style="margin-top: 24px;">
            <div class="panel-header">
                <div class="panel-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 13L4 8C4.279 6.605 5.47 5.588 6.888 5.588H17.112C18.53 5.588 19.721 6.605 20 8L21 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 16H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="7" cy="17" r="2" stroke="currentColor" stroke-width="2"/>
                        <circle cx="17" cy="17" r="2" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h2>Reporte de pagos por unidad de taxi</h2>
                    <p>Resultados para {{ $reporteUnidad['vehiculo']->placa ?? $reporteUnidad['vehiculo']->matricula }}.</p>
                </div>
            </div>

            <div class="panel-separator"></div>
            <div class="field-grid">
                <div class="field-card"><span class="field-label">Unidad</span><p>{{ $reporteUnidad['vehiculo']->placa ?? $reporteUnidad['vehiculo']->matricula }}</p></div>
                <div class="field-card"><span class="field-label">Vehículo</span><p>{{ $reporteUnidad['vehiculo']->marca }} {{ $reporteUnidad['vehiculo']->modelo }}</p></div>
                <div class="field-card"><span class="field-label">Pagos</span><p>{{ $reporteUnidad['total_pagos'] }}</p></div>
                <div class="field-card"><span class="field-label">Total ingresos</span><p>${{ number_format((float) $reporteUnidad['total_ingresos'], 2, ',', '.') }}</p></div>
            </div>

            <div class="panel-separator"></div>
            <table>
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
        </section>
    @endif

    @if($reporteRango)
        <section class="panel" style="margin-top: 24px;">
            <div class="panel-header">
                <div class="panel-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="17" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h2>Reporte de pagos por rango de fechas</h2>
                    <p>Resultados del periodo {{ $reporteRango['fecha_inicio']->format('d/m/Y') }} - {{ $reporteRango['fecha_fin']->format('d/m/Y') }}.</p>
                </div>
            </div>

            <div class="panel-separator"></div>
            <div class="field-grid">
                <div class="field-card"><span class="field-label">Periodo</span><p>{{ $reporteRango['fecha_inicio']->format('d/m/Y') }} - {{ $reporteRango['fecha_fin']->format('d/m/Y') }}</p></div>
                <div class="field-card"><span class="field-label">Pagos</span><p>{{ $reporteRango['total_pagos'] }}</p></div>
                <div class="field-card"><span class="field-label">Total ingresos</span><p>${{ number_format((float) $reporteRango['total_ingresos'], 2, ',', '.') }}</p></div>
            </div>

            <div class="panel-separator"></div>
            <table>
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
        </section>
    @endif

    @if($reporteSemanal)
        <section class="panel" style="margin-top: 24px;">
            <div class="panel-header">
                <div class="panel-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 19V5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 19H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M7 16V11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M11 16V8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M15 16V12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M19 16V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h2>Reporte semanal del total de ingresos registrados</h2>
                    <p>Resumen agrupado por semana.</p>
                </div>
            </div>

            <div class="panel-separator"></div>
            <div class="field-grid">
                <div class="field-card">
                    <span class="field-label">Semanas registradas</span>
                    <p>{{ $reporteSemanal->count() }}</p>
                </div>
                <div class="field-card">
                    <span class="field-label">Total acumulado</span>
                    <p>${{ number_format($reporteSemanal->sum('total_ingresos'), 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="panel-separator"></div>
            <table>
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
        </section>
    @endif

    @if($reporteInventarioCompras)
        <section class="panel" style="margin-top: 24px;">
            <div class="panel-header">
                <div class="panel-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M7 21V10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M17 21V10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h2>Reporte de inventario y compras</h2>
                    <p>Consulta existencias actuales y el historial de compras de refacciones.</p>
                </div>
            </div>

            <div class="panel-separator"></div>
            <div class="field-grid">
                <div class="field-card"><span class="field-label">Piezas registradas</span><p>{{ $reporteInventarioCompras['total_piezas'] }}</p></div>
                <div class="field-card"><span class="field-label">Existencias totales</span><p>{{ $reporteInventarioCompras['existencias_totales'] }}</p></div>
                <div class="field-card"><span class="field-label">Compras registradas</span><p>{{ $reporteInventarioCompras['total_compras'] }}</p></div>
                <div class="field-card"><span class="field-label">Costo total compras</span><p>${{ number_format((float) $reporteInventarioCompras['costo_total_compras'], 2, ',', '.') }}</p></div>
            </div>

            <div class="panel-separator"></div>
            <h3 style="margin: 0 0 12px 0;">Existencias actuales</h3>
            <table>
                <thead>
                    <tr>
                        <th>Pieza</th>
                        <th>Tipo</th>
                        <th>Cantidad disponible</th>
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

            <div class="panel-separator"></div>
            <h3 style="margin: 0 0 12px 0;">Historial de compras</h3>
            <table>
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
        </section>
    @endif

    <style>
        .report-fields {
            display: none;
            margin-top: 20px;
        }

        .report-fields.is-visible {
            display: block;
        }

        .report-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }
    </style>

    <script>
        (function () {
            const select = document.getElementById('reporte-select');
            const sections = Array.from(document.querySelectorAll('.report-fields'));
            const submit = document.getElementById('report-submit');

            function syncState() {
                const selected = select.value;

                sections.forEach((section) => {
                    const isVisible = section.dataset.reportFields === selected;
                    section.classList.toggle('is-visible', isVisible);

                    section.querySelectorAll('input, select, textarea').forEach((field) => {
                        if (field.name === 'reporte') {
                            return;
                        }

                        if (isVisible) {
                            field.disabled = false;
                            if (field.hasAttribute('data-required')) {
                                field.required = true;
                            }
                        } else {
                            field.disabled = true;
                            field.required = false;
                        }
                    });
                });

                submit.disabled = !selected;
            }

            sections.forEach((section) => {
                section.querySelectorAll('input, select, textarea').forEach((field) => {
                    if (field.required) {
                        field.setAttribute('data-required', 'true');
                    }
                });
            });

            select.addEventListener('change', syncState);
            syncState();
        })();
    </script>
@endsection