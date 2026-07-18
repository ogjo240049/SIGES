@extends('layouts.app')

@section('title', 'Gestión de taxis - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    <a href="{{ route('vehiculos.create') }}" class="button-secondary">Nuevo taxi</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Gestión de taxis</p>
            <h1>Flotilla de vehículos</h1>
            <p class="hero-copy">Registra, consulta y administra las unidades de taxi con todos los datos requeridos para su operación.</p>
        </div>
    </section>

    <section class="table-card">
        <!-- BLOQUE DE FILTRADO PARA VEHÍCULOS -->
        <div class="filter-container" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eaeaea;">
            <form action="{{ route('vehiculos.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input 
                    type="text" 
                    name="buscar_vehiculo" 
                    placeholder="Buscar por nombre o placa..." 
                    value="{{ request('buscar_vehiculo') }}" 
                    class="form-input"
                    style="flex: 1; max-width: 300px;"
                >
                <button type="submit" class="button-secondary">Buscar</button>
                
                @if(request('buscar_vehiculo'))
                    <a href="{{ route('vehiculos.index') }}" class="button-ghost">Limpiar filtro</a>
                @endif
            </form>
        </div>

        @if($vehiculos->isEmpty())
            <div class="empty-state">
                <h2>No hay taxis registrados aún o no coinciden con la búsqueda</h2>
                <p>Agrega la primera unidad para comenzar a llevar un control detallado de tu flotilla.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Placa</th>
                        <th>Marca / Modelo</th>
                        <th>Chofer</th>
                        <th>Concesionario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehiculos as $vehiculo)
                        <tr>
                            <td>{{ $vehiculo->nombre }}</td>
                            <td>{{ $vehiculo->placa }}</td>
                            <td>{{ $vehiculo->marca }} / {{ $vehiculo->modelo }}</td>
                            <td>{{ $vehiculo->chofer->usuario?->name ?? 'Sin chofer' }}</td>
                            <td>{{ $vehiculo->concesionario }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('vehiculos.show', $vehiculo) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="button-primary" style="padding: 10px 16px; width: auto; min-width: 92px; justify-content: center;">Editar</a>
                                    <form action="{{ route('vehiculos.destroy', $vehiculo) }}" method="POST" onsubmit="return confirm('¿Eliminar este taxi?');">
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