<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="theme-color" content="#ffffff">
    <link rel="apple-touch-icon" sizes="180x180" href="./images/icons/icon-192x192.png">
    <link rel="manifest" href="./manifest.json" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar sesión</title>
    <link href="{{ asset('librerias/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="shortcut icon" href="img/icono.png" />
    @laravelPWA
</head>

<body>
    <div class="container">
        <form action="" method="post">
            @csrf
            <img class="m-3" src="/img/user.png" alt="user" width="110" height="110">
            <h2>Iniciar sesión</h2>
            <div>
                <div class="mb-3 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" autofocus value="{{ old('user') }}" name="user"
                        required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="password" required>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="remember">
                        <label class="form-check-label" for="flexCheckDefault">
                            Recordar sesión
                        </label>
                    </div>
                    <a href="/formulario">Registrarse como empleado.</a>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Iniciar sesión">
                </div>
            </div>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        </form>
    </div>
    <script src="{{ asset('librerias/jquery-3.7.1.min.js.js') }}"></script>
    <script src="{{ asset('librerias/bootstrap.bundle.min.js.js') }}"></script>
</body>

</html>
