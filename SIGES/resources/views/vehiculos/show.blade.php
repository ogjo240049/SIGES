@extends('layouts.app')

@section('title', 'Detalle del taxi - SIGES')

@section('topbar-actions')
    <a href="{{ route('vehiculos.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a taxis
    </a>
    <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="button-secondary">Editar taxi</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle del taxi</p>
            <h1>Unidad: {{ $vehiculo->nombre }}</h1>
            <p class="hero-copy">Revisa toda la información del vehículo y su chofer asignado para llevar un control preciso.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 17V7C4 5.89543 4.89543 5 6 5H18C19.1046 5 20 5.89543 20 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 13H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M7 17V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M17 17V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h2>Información del taxi</h2>
                <p>Consulta los detalles clave del vehículo junto con el chofer responsable.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Nombre</span>
                <p>{{ $vehiculo->nombre }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Placa</span>
                <p>{{ $vehiculo->placa }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Marca</span>
                <p>{{ $vehiculo->marca }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Modelo</span>
                <p>{{ $vehiculo->modelo }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Motor</span>
                <p>{{ $vehiculo->motor }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Serie</span>
                <p>{{ $vehiculo->serie }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Concesionario</span>
                <p>{{ $vehiculo->concesionario }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Chofer asignado</span>
                <p>{{ $vehiculo->chofer->usuario?->name ?? 'Sin chofer asignado' }}</p>
            </div>
        </div>
    </section>
@endsection
