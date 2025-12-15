<!DOCTYPE html>
<html lang="en">
<!-- data-bs-theme="dark" -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema atención al ciudadano</title>
    <link href="{{ asset('librerias/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('librerias/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
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
                    <a class="nav-link {{ strpos(url()->current(), 'personas') ? 'active' : '' }}" aria-current="page"
                        href="/lista-personas">Ver listado</a>
                    <a class="nav-link {{ strpos(url()->current(), 'grafica') ? 'active' : '' }}"
                        href="/grafica">Estadísticas</a>
                    <!-- <a class="nav-link {{ strpos(url()->current(), 'reportes') ? 'active' : '' }}"
                        href="/reportes">Reportes</a> -->
                    <a class="nav-link" href="/formulario">Registrar visita</a>
                    <a class="nav-link {{ strpos(url()->current(), 'citas') ? 'active' : '' }}"
                        href="/citas">Control de citas</a>
                    <!--Permitir acceso solo al usuario 'Master'-->
                    @if (auth()->user()->id == 1)
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
                    <a class="nav-link {{ strpos(url()->current(), 'personas') ? 'active' : '' }}" aria-current="page"
                        href="/lista-personas">Ver listado</a>
                    <a class="nav-link {{ strpos(url()->current(), 'grafica') ? 'active' : '' }}"
                        href="/grafica">Estadísticas</a>
                    <!-- <a class="nav-link {{ strpos(url()->current(), 'reportes') ? 'active' : '' }}"
                        href="/reportes">Reportes</a> -->
                    <a class="nav-link {{ strpos(url()->current(), 'formulario') ? 'active' : '' }}"
                        href="/formulario">Registrar visita</a>
                    <a class="nav-link {{ strpos(url()->current(), 'citas') ? 'active' : '' }}"
                        href="/citas">Control de citas</a>
                    @if (auth()->user()->id == 1)
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
    <div class="container">
        @yield('content')
    </div>
    <footer>
        <div class="text-center p-3 bg-dark text-white mt-4">
            Corpocentro ® 2025. RIF: J-20008343-3. Copyleft. Desarollado por la Oficina de Tecnología de Información y
            Comunicación.
        </div>
    </footer>
    <script src="{{ asset('librerias/jquery-3.7.1.min.js.js') }}"></script>
    <script src="{{ asset('librerias/bootstrap.bundle.min.js.js') }}"></script>
    <script src="{{ asset('librerias/select2.min.js.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
    <script src="{{ asset('js/ajax-modal.js') }}"></script>
    <script src="{{ asset('js/ajax-form.js') }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
    <script src="{{ asset('js/reporte.js') }}"></script>
    <!--<script src="{{ asset('js/banner.js') }}"></script>-->
    <script src="{{ asset('js/multi-step.js') }}"></script>
    @if(session('success_alert'))
    <script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación Exitosa!',
        theme: 'dark',
        text: @json(session('success_alert')),
        showConfirmButton: false,
        timer: 3000
    });
    </script>
    @endif
</body>

</html>