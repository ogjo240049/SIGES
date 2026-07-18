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
        <!-- BUSCADOR AGREGADO PARA CUMPLIR LA FN.12 -->
        <div class="filter-container" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eaeaea;">
            <form action="{{ route('choferes.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input 
                    type="text" 
                    name="buscar_chofer" 
                    placeholder="Buscar chofer por nombre..." 
                    value="{{ request('buscar_chofer') }}" 
                    class="form-input"
                    style="flex: 1; max-width: 300px;"
                >
                <button type="submit" class="button-secondary">Buscar</button>
                
                @if(request('buscar_chofer'))
                    <a href="{{ route('choferes.index') }}" class="button-ghost">Limpiar filtro</a>
                @endif
            </form>
        </div>

        @if($choferes->isEmpty())
            <div class="empty-state">
                <h2>No hay choferes registrados aún o no coinciden con la búsqueda</h2>
                <p>Agrega el primer chofer para comenzar a administrar la operación.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Chofer</th>
                        <th>Identificación</th>
                        <th>Unidad</th>
                        <th>Usuario (ID)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($choferes as $chofer)
                        <tr>
                            <!-- Muestra el NOMBRE completo del chofer desde la relación usuario -->
                            <td>{{ $chofer->usuario?->name ?? 'Sin nombre asignado' }}</td>
                            
                            <td>{{ $chofer->identificacion }}</td>
                            
                            <!-- Muestra el NOMBRE comercial del vehículo (ej: M-15) -->
                            <td>{{ $chofer->vehiculo?->nombre ?? 'Sin unidad' }}</td>
                            
                            <!-- Muestra únicamente el ID numérico del usuario en el sistema -->
                            <td>#{{ $chofer->usuario?->id ?? 'N/D' }}</td>
                            
                            <td>
                                <div class="actions">
                                    <a href="{{ route('choferes.show', $chofer) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('choferes.edit', $chofer) }}" class="button-primary" style="padding: 10px 16px; width: auto; min-width: 92px; justify-content: center;">Editar</a>
                                    <form action="{{ route('choferes.destroy', $chofer) }}" method="POST" onsubmit="return confirm('¿Eliminar este chofer?');">
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