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
    <h2>Gestion de pagos</h2>
    <p>Manten actualizados los pagos realizados por los choferes y accede rapidamente al modulo con un solo clic.</p>
    
    <div style="display: flex; justify-content: center; width: 100%; margin-top: 1rem;">
        <a href="{{ route('pagos.index') }}" class="button-secondary w-auto inline-flex items-center justify-center px-4 py-2 text-sm">
            Abrir pagos
        </a>
    </div>
</article>

    </section>
@endsection