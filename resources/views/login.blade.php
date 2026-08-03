<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#ffffff">
    <title>Iniciar sesión</title>

    <link rel="apple-touch-icon" sizes="180x180" href="./images/icons/icon-192x192.png">
    <link rel="manifest" href="./manifest.json" />
    <link rel="shortcut icon" href="img/icono.png" />

    <!-- Estilos principales -->
    <link href="{{ asset('librerias/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
    <main class="login-wrapper">
        <div class="login-card">

            <div class="text-center mb-4">
                <img src="/img/logocorpo.png" alt="Logo Corporation" class="login-logo mb-3">
                <h2 class="fw-bold fs-4 text-dark mb-1">¡Bienvenido!</h2>
                <p class="text-muted small">Ingresa tus credenciales para acceder</p>
            </div>

            <!-- Manejo de Errores -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="" method="POST" autocomplete="off">
                @csrf

                <div class="mb-3">
                    <label for="userInput" class="form-label fw-semibold">Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent text-secondary border-end-0">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" id="userInput" class="form-control border-start-0 ps-3" name="user"
                            value="{{ old('user') }}" placeholder="Tu usuario" autofocus required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="passwordInput" class="form-label fw-semibold">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent text-secondary border-end-0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" id="passwordInput" class="form-control border-start-0 ps-3"
                            name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                    Iniciar sesión
                </button>
            </form>

        </div>
    </main>

    <script src="{{ asset('librerias/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('librerias/bootstrap.bundle.min.js') }}"></script>
</body>

</html>