<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\choferes;
use App\Models\compras;
use App\Models\inventario;
use App\Models\pagos;
use App\Models\vehiculos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    private function buildReportData(Request $request): array
    {
        $choferes = choferes::with('usuario', 'vehiculo')
            ->orderBy('id_chofer')
            ->get();

        $vehiculos = vehiculos::orderBy('matricula')
            ->get();

        $reporteTipo = $request->string('reporte')->toString();

        $reporteChofer = null;
        $reporteUnidad = null;
        $reporteRango = null;
        $reporteSemanal = null;
        $reporteInventarioCompras = null;

        if ($reporteTipo === 'chofer' && $request->filled('id_chofer')) {
            $request->validate([
                'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            ]);

            $choferSeleccionado = choferes::with('usuario', 'vehiculo')
                ->findOrFail($request->integer('id_chofer'));

            $pagosChofer = pagos::with('chofer.usuario', 'chofer.vehiculo')
                ->where('id_chofer', $choferSeleccionado->id_chofer)
                ->orderByDesc('fecha_pago')
                ->get();

            $reporteChofer = [
                'chofer' => $choferSeleccionado,
                'pagos' => $pagosChofer,
                'total_pagos' => $pagosChofer->count(),
                'total_ingresos' => $pagosChofer->sum('monto_pago'),
            ];
        }

        if ($reporteTipo === 'unidad' && $request->filled('matricula')) {
            $request->validate([
                'matricula' => ['required', 'string', 'exists:vehiculos,matricula'],
            ]);

            $vehiculoSeleccionado = vehiculos::findOrFail($request->string('matricula'));

            $pagosUnidad = pagos::with('chofer.usuario', 'chofer.vehiculo')
                ->whereHas('chofer', function ($query) use ($vehiculoSeleccionado) {
                    $query->where('unidad_asignada', $vehiculoSeleccionado->matricula);
                })
                ->orderByDesc('fecha_pago')
                ->get();

            $reporteUnidad = [
                'vehiculo' => $vehiculoSeleccionado,
                'pagos' => $pagosUnidad,
                'total_pagos' => $pagosUnidad->count(),
                'total_ingresos' => $pagosUnidad->sum('monto_pago'),
            ];
        }

        if ($reporteTipo === 'fechas' && ($request->filled('fecha_inicio') || $request->filled('fecha_fin'))) {
            $request->validate([
                'fecha_inicio' => ['required', 'date'],
                'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            ]);

            $fechaInicio = $request->date('fecha_inicio')->startOfDay();
            $fechaFin = $request->date('fecha_fin')->endOfDay();

            $pagosRango = pagos::with('chofer.usuario', 'chofer.vehiculo')
                ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                ->orderByDesc('fecha_pago')
                ->get();

            $reporteRango = [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'pagos' => $pagosRango,
                'total_pagos' => $pagosRango->count(),
                'total_ingresos' => $pagosRango->sum('monto_pago'),
            ];
        }

        if ($reporteTipo === 'semanal') {
            $pagos = pagos::orderBy('fecha_pago')->get();

            $reporteSemanal = $pagos
                ->groupBy(function ($pago) {
                    return $pago->fecha_pago->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
                })
                ->map(function ($grupo, $inicioSemana) {
                    $inicio = Carbon::parse($inicioSemana);

                    return [
                        'inicio_semana' => $inicio,
                        'fin_semana' => $inicio->copy()->endOfWeek(Carbon::SUNDAY),
                        'total_pagos' => $grupo->count(),
                        'total_ingresos' => $grupo->sum('monto_pago'),
                    ];
                })
                ->values();
        }

        if ($reporteTipo === 'inventario_compras') {
            $inventariosConCompras = inventario::with(['compras' => function ($query) {
                $query->orderByDesc('fecha');
            }])
                ->orderBy('nombre_pieza')
                ->get();

            $historialCompras = compras::with('inventario')
                ->orderByDesc('fecha')
                ->get();

            $reporteInventarioCompras = [
                'inventarios' => $inventariosConCompras,
                'compras' => $historialCompras,
                'total_piezas' => $inventariosConCompras->count(),
                'existencias_totales' => $inventariosConCompras->sum('cantidad'),
                'total_compras' => $historialCompras->count(),
                'costo_total_compras' => $historialCompras->sum(fn ($compra) => (float) $compra->precio_unitario * (int) $compra->cantidad_compra),
            ];
        }

        return compact(
            'choferes',
            'vehiculos',
            'reporteTipo',
            'reporteChofer',
            'reporteUnidad',
            'reporteRango',
            'reporteSemanal',
            'reporteInventarioCompras'
        );
    }

    private function reportTitle(?string $reporteTipo): string
    {
        return match ($reporteTipo) {
            'chofer' => 'Reporte de pagos por chofer',
            'unidad' => 'Reporte de pagos por unidad de taxi',
            'fechas' => 'Reporte de pagos por rango de fechas',
            'semanal' => 'Reporte semanal del total de ingresos registrados',
            'inventario_compras' => 'Reporte de inventario y compras',
            default => 'Reportes de pagos e ingresos',
        };
    }

    public function index(Request $request)
    {
        return view('reportes.index', $this->buildReportData($request));
    }

    public function downloadPdf(Request $request)
    {
        $data = $this->buildReportData($request);

        abort_if(blank($data['reporteTipo']), 422, 'Debes seleccionar un tipo de reporte.');

        $filename = str()->slug($this->reportTitle($data['reporteTipo'])) . '.pdf';

        return Pdf::loadView('reportes.pdf', [
            ...$data,
            'reportTitle' => $this->reportTitle($data['reporteTipo']),
        ])->download($filename);
    }
}