@extends('layouts.app')

@section('title', 'Compras - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    <a href="{{ route('compras.create') }}" class="button-secondary">Nueva compra</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Compras</p>
            <h1>Registro de compras</h1>
            <p class="hero-copy">Registra y administra las compras de refacciones realizadas por la empresa.</p>
        </div>
    </section>

    <section class="table-card">
        <!-- BLOQUE DE FILTRADO AÑADIDO PARA CUMPLIR FN.12 -->
        <div class="filter-container" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eaeaea;">
            <form action="{{ route('compras.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input 
                    type="text" 
                    name="buscar_pieza" 
                    placeholder="Filtrar historial por pieza..." 
                    value="{{ request('buscar_pieza') }}" 
                    class="form-input"
                    style="flex: 1; max-width: 300px;"
                >
                <button type="submit" class="button-secondary">Buscar</button>
                
                @if(request('buscar_pieza'))
                    <a href="{{ route('compras.index') }}" class="button-ghost">Limpiar filtro</a>
                @endif
            </form>
        </div>

        @if($compras->isEmpty())
            <div class="empty-state">
                <h2>No hay compras registradas aún o no coinciden con la búsqueda</h2>
                <p>Agrega el primer registro para llevar control de adquisiciones.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Pieza</th>
                        <th>Precio unitario</th>
                        <th>Cantidad</th>
                        <th>Lugar</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                        <tr>
                            <td>{{ $compra->fecha->format('d/m/Y') }}</td>
                            <td>{{ $compra->inventario?->nombre_pieza ?? 'N/D' }}</td>
                            <td>${{ number_format($compra->precio_unitario, 2, ',', '.') }}</td>
                            <td>{{ $compra->cantidad_compra }}</td>
                            <td>{{ $compra->lugar_compra }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('compras.show', $compra) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('compras.edit', $compra) }}" class="button-secondary">Editar</a>
                                    <form action="{{ route('compras.destroy', $compra) }}" method="POST" onsubmit="return confirm('¿Eliminar esta compra?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-ghost" style="border: 1px solid rgba(239, 68, 68, 0.2); color: #dc2626;">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection