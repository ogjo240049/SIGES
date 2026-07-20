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
                    <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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