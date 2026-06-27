<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel SIGES</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div class="shell">
        <header class="topbar">
            <div class="brand">
                <span class="brand-mark"></span>
                <span>SIGES</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Cerrar sesión</button>
            </form>
        </header>

        <section class="hero">
            <h1>Bienvenido, {{ $user?->name }}.</h1>
            <p>
            </p>
        </section>

        <section class="grid">
            <article class="grid-card">
                <h2>Perfil de acceso</h2>
                <p>{{ $user?->email }}</p>
                
            </article>

            <article class="grid-card">
               
            </article>

            <article class="grid-card">
                
            </article>
        </section>
    </div>
</body>
</html>