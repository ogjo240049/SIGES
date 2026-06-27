<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel SIGES</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />
    <style>
        :root {
            --bg: #09111f;
            --panel: rgba(12, 20, 38, 0.78);
            --border: rgba(255, 255, 255, 0.12);
            --text: #eef3ff;
            --muted: #9aa9c2;
            --accent: #ff8a3d;
            --accent-2: #7dd3fc;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top right, rgba(255, 138, 61, 0.18), transparent 25%),
                radial-gradient(circle at top left, rgba(125, 211, 252, 0.16), transparent 28%),
                linear-gradient(160deg, #06101c, var(--bg));
            padding: 28px;
        }

        .shell {
            width: min(1180px, 100%);
            margin: 0 auto;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 26px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--accent), #ffb36a);
        }

        .logout {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(7, 14, 27, 0.5);
            color: var(--text);
            border-radius: 14px;
            padding: 12px 16px;
            font: 600 0.95rem 'Manrope', sans-serif;
            cursor: pointer;
        }

        .hero,
        .grid-card {
            border: 1px solid var(--border);
            background: var(--panel);
            backdrop-filter: blur(18px);
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.35);
            border-radius: 28px;
        }

        .hero {
            padding: 32px;
            margin-bottom: 22px;
        }

        .hero h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .hero p {
            margin: 14px 0 0;
            color: var(--muted);
            max-width: 70ch;
            line-height: 1.7;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .grid-card {
            padding: 24px;
            min-height: 180px;
        }

        .grid-card h2 {
            margin: 0 0 10px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.2rem;
        }

        .grid-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.65;
        }

        .chip {
            display: inline-flex;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 0.88rem;
            background: rgba(125, 211, 252, 0.12);
            color: #dff4ff;
        }

        @media (max-width: 960px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 16px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
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
                Tu sesión está activa y protegida con Sanctum. Desde aquí puedes operar el sistema
                con un diseño claro, rápido y consistente.
            </p>
        </section>

        <section class="grid">
            <article class="grid-card">
                <h2>Perfil de acceso</h2>
                <p>{{ $user?->email }}</p>
                <span class="chip">Autenticado con Sanctum</span>
            </article>

            <article class="grid-card">
                <h2>Estado de la sesión</h2>
                <p>La sesión web se mantiene activa y el panel queda listo para navegar entre módulos.</p>
                <span class="chip">Sesión segura</span>
            </article>

            <article class="grid-card">
                <h2>Siguiente paso</h2>
                <p>Puedes conectar el frontend con la API `/api/me` usando un token personal de Sanctum.</p>
                <span class="chip">API disponible</span>
            </article>
        </section>
    </div>
</body>
</html>