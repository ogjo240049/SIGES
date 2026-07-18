@extends('layouts.app')

@section('title', 'Bitácora - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    <a href="{{ route('bitacoras.create') }}" class="button-secondary">Nuevo registro</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Bitácora</p>
            <h1>Registro de actividad</h1>
            <p class="hero-copy">Consulta y administra los movimientos registrados para cada chofer con fecha, hora y locación.</p>
        </div>
    </section>

    <section class="table-card">
        @if($bitacoras->isEmpty())
            <div class="empty-state">
                <h2>No hay registros de bitácora aún</h2>
                <p>Agrega el primer registro para comenzar a llevar el control de actividades.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Fecha y hora</th>
                        <th>Chofer</th>
                        <th>Vehículo</th>
                        <th>Locación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bitacoras as $bitacora)
                        <tr>
                            <td>{{ $bitacora->fecha_hora->format('d/m/Y H:i') }}</td>
                            <td>{{ $bitacora->chofer->usuario?->name ?? 'N/D' }}</td>
                            <td>{{ $bitacora->chofer->vehiculo?->matricula ?? 'Sin vehículo' }}</td>
                            <td>{{ $bitacora->locacion }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('bitacoras.show', $bitacora) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('bitacoras.edit', $bitacora) }}" class="button-secondary">Editar</a>
                                    <form action="{{ route('bitacoras.destroy', $bitacora) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro de bitácora?');">
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