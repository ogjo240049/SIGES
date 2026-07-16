@extends('layouts.app')

@section('title', 'Usuarios - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    <a href="{{ route('usuarios.create') }}" class="button-secondary">Nuevo usuario</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Usuarios</p>
            <h1>Gestión de usuarios</h1>
            <p class="hero-copy">Administra las cuentas de acceso, sus roles y la información de contacto de cada usuario del sistema.</p>
        </div>
    </section>

    <section class="table-card">
        @if($usuarios->isEmpty())
            <div class="empty-state">
                <h2>No hay usuarios registrados aún</h2>
                <p>Agrega la primera cuenta para comenzar a administrar el acceso al sistema.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $user)
                        <tr>
                            <td>{{ $user->name }} {{ $user->apellido_pat }} {{ $user->apellido_mat }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->telefono }}</td>
                            <td>{{ $user->rol_label }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('usuarios.show', $user) }}" class="button-ghost">Ver</a>
                                    <a href="{{ route('usuarios.edit', $user) }}" class="button-secondary">Editar</a>
                                    <form action="{{ route('usuarios.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?');">
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