@extends('layouts.app')

@section('title', 'Detalle del usuario - SIGES')

@section('topbar-actions')
    <a href="{{ route('usuarios.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a usuarios
    </a>
    <a href="{{ route('usuarios.edit', $user) }}" class="button-secondary">Editar usuario</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle del usuario</p>
            <h1>{{ $user->name }} {{ $user->apellido_pat }} {{ $user->apellido_mat }}</h1>
            <p class="hero-copy">Consulta la información de contacto, el rol asignado y la dirección de correo de la cuenta.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <div>
                <h2>Información del usuario</h2>
                <p>Revisa el perfil completo de la cuenta registrada en el sistema.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Nombre completo</span>
                <p>{{ $user->name }} {{ $user->apellido_pat }} {{ $user->apellido_mat }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Correo</span>
                <p>{{ $user->email }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Teléfono</span>
                <p>{{ $user->telefono }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Rol</span>
                <p>{{ $user->rol_label }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Contraseña</span>
                <p>{{ $user->password }}</p>
            </div>
        </div>
    </section>
@endsection