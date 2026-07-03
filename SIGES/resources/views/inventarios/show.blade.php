@extends('layouts.app')

@section('title', 'Detalle de pieza - SIGES')

@section('topbar-actions')
    <a href="{{ route('inventarios.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al inventario
    </a>
    <a href="{{ route('inventarios.edit', $inventario) }}" class="button-secondary">Editar pieza</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle de la pieza</p>
            <h1>{{ $inventario->nombre_pieza }}</h1>
            <p class="hero-copy">Revisa los detalles de la pieza y su stock disponible.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L20 7V17L12 22L4 17V7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h2>Información de la pieza</h2>
                <p>Detalles y cantidad disponible en inventario.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Nombre</span>
                <p>{{ $inventario->nombre_pieza }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Tipo</span>
                <p>{{ $inventario->tipo_pieza }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Cantidad</span>
                <p>{{ $inventario->cantidad }}</p>
            </div>
        </div>
    </section>
@endsection
