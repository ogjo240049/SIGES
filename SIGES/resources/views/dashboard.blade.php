@extends('layouts.app')

@section('title', 'Dashboard - SIGES')

@section('content')
    <section class="hero">
        <div>
            <p class="eyebrow">Bienvenido</p>
            <h1>Bienvenido, {{ $user?->name }}.</h1>
            <p class="hero-copy">Controla pagos, choferes y actividad desde un panel minimalista con dise�o premium.</p>
        </div>
    </section>

    <section class="grid">

        <article class="grid-card">
            <h2>Perfil de acceso</h2>
            <p>{{ $user?->email }}</p>
        </article>

        
        <article class="grid-card">
            <h2>Gestión de usuarios</h2>
            <p>Administra cuentas, roles y credenciales de acceso del sistema desde un solo lugar.</p>
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                <a href="{{ route('usuarios.index') }}" class="button-secondary w-auto inline-flex items-center justify-center px-4 py-2 text-sm">
                    Abrir usuarios
                </a>
            </div>
        </article>

        

        <article class="grid-card">
    <h2>Gestion de pagos</h2>
    <p>Manten actualizados los pagos realizados por los choferes y accede rapidamente al modulo con un solo clic.</p>
    
    <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
        <a href="{{ route('pagos.index') }}" class="button-secondary w-auto inline-flex items-center justify-center px-4 py-2 text-sm">
            Abrir pagos
        </a>
    </div>
</article>

        <article class="grid-card">
            <h2>Gestión de taxis</h2>
            <p>Registra, edita y administra las unidades de taxi, con placa, modelo, motor, serie, concesionario y chofer asignado.</p>
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                <a href="{{ route('vehiculos.index') }}" class="button-secondary w-auto inline-flex items-center justify-center px-4 py-2 text-sm">
                    Abrir gestión de taxis
                </a>
            </div>
        </article>

        <article class="grid-card">
            <h2>Gestión de inventario</h2>
            <p>Controla las existencias de piezas: nombre, tipo y cantidad disponible.</p>
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                <a href="{{ route('inventarios.index') }}" class="button-secondary w-auto inline-flex items-center justify-center px-4 py-2 text-sm">
                    Abrir inventario
                </a>
            </div>
        </article>

        <article class="grid-card">
            <h2>Gestión de compras</h2>
            <p>Registra las adquisiciones de piezas y mantén actualizado el inventario automáticamente.</p>
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                <a href="{{ route('compras.index') }}" class="button-secondary w-auto inline-flex items-center justify-center px-4 py-2 text-sm">
                    Abrir compras
                </a>
            </div>
        </article>

        <article class="grid-card">
            <h2>Gestión de servicios</h2>
            <p>Registra viajes particulares indicando origen, destino, chofer y vehículo.</p>
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                <a href="{{ route('servicios.index') }}" class="button-secondary w-auto inline-flex items-center justify-center px-4 py-2 text-sm">
                    Abrir servicios
                </a>
            </div>
        </article>

    </section>
@endsection