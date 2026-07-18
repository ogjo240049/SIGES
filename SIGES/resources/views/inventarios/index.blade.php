@extends('layouts.app')

@section('title', 'Inventario - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    <a href="{{ route('inventarios.create') }}" class="button-secondary">Nueva pieza</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Inventario</p>
            <h1>Gestión de inventario</h1>
            <p class="hero-copy">Registra, consulta y administra las piezas de refacción y su stock disponible.</p>
        </div>
    </section>

    <section class="table-card">
        <!-- BLOQUE DE FILTRADO AÑADIDO PARA CUMPLIR FN.12 -->
        <div class="filter-container" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eaeaea;">
            <form action="{{ route('inventarios.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input 
                    type="text" 
                    name="buscar_pieza" 
                    placeholder="Buscar pieza por nombre..." 
                    value="{{ request('buscar_pieza') }}" 
                    class="form-input"
                    style="flex: 1; max-width: 300px;"
                >
                <button type="submit" class="button-secondary">Buscar</button>
                
                @if(request('buscar_pieza'))
                    <a href="{{ route('inventarios.index') }}" class="button-ghost">Limpiar filtro</a>
                @endif
            </form>
        </div>

        @if($inventarios->isEmpty())
            <div class="empty-state">
                <h2>No hay piezas registradas aún o no coinciden con la búsqueda</h2>
                <p>Agrega la primera pieza para comenzar a llevar el control de existencias.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventarios as $item)
                        <tr>
                            <td>{{ $item->nombre_pieza }}</td>
                            <td>{{ $item->tipo_pieza }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('inventarios.show', $item) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('inventarios.edit', $item) }}" class="button-secondary">Editar</a>
                                    <form action="{{ route('inventarios.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">
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