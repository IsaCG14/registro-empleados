<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control de empleados</title>
    <link href="{{ asset('librerias/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('librerias/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('librerias/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="shortcut icon" href="img/icono.png" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark position-fixed w-100" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/img/icono.png" width="30" height="30" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link {{ strpos(url()->current(), 'empleados') ? 'active' : '' }}" aria-current="page"
                        href="/lista-empleados">Inicio</a>
                    <a class="nav-link {{ strpos(url()->current(), 'grafica') ? 'active' : '' }}"
                        href="/grafica">Estadísticas</a>
                    <a class="nav-link {{ strpos(url()->current(), 'reportes') ? 'active' : '' }}"
                        href="/reportes">Reportes</a>
                    <a class="nav-link" target="_blank" href="/formulario">Registrar</a>
                    @if (session('rol') == true)
                        <a class="nav-link {{ strpos(url()->current(), 'usuarios') ? 'active' : '' }}"
                            href="/usuarios">Usuarios</a>
                    @endif
                </div>
            </div>
            <div>
                <a href="" class="btn btn-outline-light">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg bg-dark position-fixed w-100" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/img/icono.png" width="30" height="30" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link {{ strpos(url()->current(), 'empleados') ? 'active' : '' }}" aria-current="page"
                        href="/lista-empleados">Inicio</a>
                    <a class="nav-link {{ strpos(url()->current(), 'grafica') ? 'active' : '' }}"
                        href="/grafica">Estadísticas</a>
                    <a class="nav-link {{ strpos(url()->current(), 'reportes') ? 'active' : '' }}"
                        href="/reportes">Reportes</a>
                    <a class="nav-link" target="_blank" href="/formulario">Registrar</a>
                    @if (session('rol') == true)
                        <a class="nav-link {{ strpos(url()->current(), 'usuarios') ? 'active' : '' }}"
                            href="/usuarios">Usuarios</a>
                    @endif
                </div>
            </div>
            <div>
                <form action="/logout" method="get">
                    <a href="#" onclick="this.closest('form').submit()" class="btn btn-outline-light">Cerrar
                        sesión</a>
                </form>
            </div>
        </div>
    </nav>
    @yield('content')
    <script src="{{ asset('librerias/jquery-3.7.1.min.js.js') }}"></script>
    <script src="{{ asset('librerias/bootstrap.bundle.min.js.js') }}"></script>
    <script src="{{ asset('librerias/select2.min.js.js') }}"></script>
    <script src="{{ asset('librerias/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/ajax-modal.js') }}"></script>
    <script src="{{ asset('js/ajax-hijo.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
    <script src="{{ asset('js/reporte.js') }}"></script>
</body>

</html>
