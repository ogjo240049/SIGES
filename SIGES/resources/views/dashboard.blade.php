@extends('layouts.app')

@section('title', 'Dashboard - SIGES')

@section('content')
    <section class="hero">
        <div>
            <p class="eyebrow" style="color: #2563EB; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em;">Bienvenido</p>
            <h1>Bienvenido, {{ $user?->name }}.</h1>
            <p class="hero-copy">Controla pagos, choferes, servicios y reportes desde un panel limpio, claro y orientado a decisiones rápidas.</p>
        </div>
    </section>

    <section class="grid">
        <article class="grid-card">
            <h2>Perfil de acceso</h2>
            <p>{{ $user?->email }}</p>
            <p class="section-copy">Rol actual: <strong>{{ $user?->rol_label }}</strong></p>
        </article>

        @if($user?->isAdmin())
            <article class="grid-card">
                <h2>Reportes financieros</h2>
                <p>Consulta pagos por chofer, por unidad, por fechas y el resumen semanal de ingresos registrados.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('reportes.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir reportes
                    </a>
                </div>
            </article>
        @endif

        @if($user?->canManageOperations())
            <article class="grid-card">
                <h2>Gestión de choferes</h2>
                <p>Da de alta choferes, enlaza su usuario y asigna una unidad disponible cuando corresponda.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('choferes.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir choferes
                    </a>
                </div>
            </article>

            <article class="grid-card">
                <h2>Bitácora de choferes</h2>
                <p>Registra ubicaciones y horarios para llevar un control puntual de la actividad de cada chofer.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('bitacoras.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir bitácora
                    </a>
                </div>
            </article>

            <article class="grid-card">
                <h2>Gestión de servicios</h2>
                <p>Registra viajes particulares indicando origen, destino, chofer y vehículo.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('servicios.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir servicios
                    </a>
                </div>
            </article>
        @endif

        <article class="grid-card">
            <h2>Gestión de pagos</h2>
            <p>Manten actualizados los pagos realizados por los choferes y accede rapidamente al módulo con un solo clic.</p>
            <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                <a href="{{ route('pagos.index') }}" 
                   style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                   class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                   onmouseover="this.style.backgroundColor='#1d4ed8'" 
                   onmouseout="this.style.backgroundColor='#2563EB'">
                    Abrir pagos
                </a>
            </div>
        </article>

        @if($user?->isAdmin())
            <article class="grid-card">
                <h2>Gestión de usuarios</h2>
                <p>Administra cuentas, roles y credenciales de acceso del sistema desde un solo lugar.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('usuarios.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir usuarios
                    </a>
                </div>
            </article>

            <article class="grid-card">
                <h2>Gestión de taxis</h2>
                <p>Registra, edita y administra las unidades de taxi, con placa, modelo, motor, serie, concesionario y chofer asignado.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('vehiculos.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir gestión de taxis
                    </a>
                </div>
            </article>

            <article class="grid-card">
                <h2>Gestión de inventario</h2>
                <p>Controla las existencias de piezas: nombre, tipo y cantidad disponible.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('inventarios.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir inventario
                    </a>
                </div>
            </article>

            <article class="grid-card">
                <h2>Gestión de compras</h2>
                <p>Registra las adquisiciones de piezas y mantén actualizado el inventario automáticamente.</p>
                <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
                    <a href="{{ route('compras.index') }}" 
                       style="background-color: #2563EB; color: #FFFFFF; border-radius: 0.5rem; font-weight: 500; transition: background-color 0.2s ease; border: none; text-decoration: none;"
                       class="w-auto inline-flex items-center justify-center px-5 py-2.5 text-sm hover:bg-[#1d4ed8]"
                       onmouseover="this.style.backgroundColor='#1d4ed8'" 
                       onmouseout="this.style.backgroundColor='#2563EB'">
                        Abrir compras
                    </a>
                </div>
            </article>
        @endif
    </section>
@endsection