@extends('layouts.app')

@section('title', 'Detalle de compra - SIGES')

@section('topbar-actions')
    <a href="{{ route('compras.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a compras
    </a>
    <a href="{{ route('compras.edit', $compra) }}" class="button-secondary">Editar compra</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle de compra</p>
            <h1>Compra registrada</h1>
            <p class="hero-copy">Revisa los detalles de la compra y el ajuste en inventario.</p>
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
                <h2>Detalles</h2>
                <p>Información completa de la compra.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Pieza</span>
                <p>{{ $compra->inventario?->nombre_pieza ?? 'N/D' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Precio unitario</span>
                <p>${{ number_format($compra->precio_unitario, 2, ',', '.') }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Cantidad</span>
                <p>{{ $compra->cantidad_compra }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Fecha</span>
                <p>{{ $compra->fecha->format('d/m/Y') }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Lugar</span>
                <p>{{ $compra->lugar_compra }}</p>
            </div>
        </div>
    </section>
@endsection
