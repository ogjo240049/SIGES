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
        @if($inventarios->isEmpty())
            <div class="empty-state">
                <h2>No hay piezas registradas aún</h2>
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
