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
        @if($vehiculos->isEmpty())
            <div class="empty-state">
                <h2>No hay taxis registrados aún</h2>
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
                                    <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="button-secondary">Editar</a>
                                    <form action="{{ route('vehiculos.destroy', $vehiculo) }}" method="POST" onsubmit="return confirm('¿Eliminar este taxi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-ghost">Eliminar</button>
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
