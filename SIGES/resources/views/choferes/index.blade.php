@extends('layouts.app')

@section('title', 'Choferes - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    <a href="{{ route('choferes.create') }}" class="button-secondary">Nuevo chofer</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Choferes</p>
            <h1>Gestión de choferes</h1>
            <p class="hero-copy">Administra los choferes del sistema, su usuario asociado, su identificación y la unidad asignada.</p>
        </div>
    </section>

    <section class="table-card">
        @if($choferes->isEmpty())
            <div class="empty-state">
                <h2>No hay choferes registrados aún</h2>
                <p>Agrega el primer chofer para comenzar a administrar la operación.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Chofer</th>
                        <th>Identificación</th>
                        <th>Unidad</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($choferes as $chofer)
                        <tr>
                            <td>#{{ $chofer->id_chofer }}</td>
                            <td>{{ $chofer->identificacion }}</td>
                            <td>{{ $chofer->vehiculo?->matricula ?? 'Sin unidad' }}</td>
                            <td>{{ $chofer->usuario?->name ?? 'N/D' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('choferes.show', $chofer) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('choferes.edit', $chofer) }}" class="button-secondary">Editar</a>
                                    <form action="{{ route('choferes.destroy', $chofer) }}" method="POST" onsubmit="return confirm('¿Eliminar este chofer?');">
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