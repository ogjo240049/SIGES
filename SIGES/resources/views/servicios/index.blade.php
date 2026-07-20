@extends('layouts.app')

@section('title', 'Servicios - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    <a href="{{ route('servicios.create') }}" class="button-secondary">Nuevo servicio</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Servicios</p>
            <h1>Registro de servicios</h1>
            <p class="hero-copy">Registra y administra los servicios particulares realizados por la radio taxi.</p>
        </div>
    </section>

    <section class="table-card">
        @if($servicios->isEmpty())
            <div class="empty-state">
                <h2>No hay servicios registrados aún</h2>
                <p>Agrega el primer servicio para comenzar a llevar el control.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Chofer</th>
                        <th>Vehículo</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->fecha_pedido->format('d/m/Y') }}</td>
                            <td>{{ $servicio->chofer->usuario?->name ?? 'N/D' }}</td>
                            {{-- Muestra Nombre/Modelo y matrícula en un formato secundario discreto --}}
                            <td>
                                @if($servicio->chofer->vehiculo)
                                    {{ $servicio->chofer->vehiculo->nombre }} 
                                    <span style="font-size: 0.85em; color: #6b7280;">({{ $servicio->chofer->vehiculo->matricula }})</span>
                                @else
                                    Sin vehículo
                                @endif
                            </td>
                            <td>{{ $servicio->origen_viaje }}</td>
                            <td>{{ $servicio->destino_viaje }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('servicios.show', $servicio) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('servicios.edit', $servicio) }}" class="button-secondary">Editar</a>
                                    <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" onsubmit="return confirm('¿Eliminar este servicio?');">
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