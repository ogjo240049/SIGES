@extends('layouts.app')

@section('title', 'Detalle de bitácora - SIGES')

@section('topbar-actions')
    <a href="{{ route('bitacoras.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a bitácora
    </a>
    <a href="{{ route('bitacoras.edit', $bitacora) }}" class="button-secondary">Editar registro</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle de bitácora</p>
            <h1>Registro del {{ $bitacora->fecha_hora->format('d/m/Y H:i') }}</h1>
            <p class="hero-copy">Consulta la actividad registrada con el chofer, su vehículo y la locación asociada.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h2>Información del registro</h2>
                <p>Revisa todos los datos almacenados en la bitácora.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Chofer</span>
                <p>{{ $bitacora->chofer->usuario?->name ?? 'N/D' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Vehículo asignado</span>
                {{-- CAMBIO REALIZADO: Muestra Nombre y Matrícula separados limpiamente --}}
                <p>
                    @if($bitacora->chofer->vehiculo)
                        {{ $bitacora->chofer->vehiculo->nombre }} 
                        <span style="display: block; font-size: 0.9em; color: #6b7280;">Placas: {{ $bitacora->chofer->vehiculo->matricula }}</span>
                    @else
                        Sin vehículo
                    @endif
                </p>
            </div>
            <div class="field-card">
                <span class="field-label">Fecha y hora</span>
                <p>{{ $bitacora->fecha_hora->format('d/m/Y H:i') }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Locación</span>
                <p>{{ $bitacora->locacion }}</p>
            </div>
        </div>
    </section>
@endsection