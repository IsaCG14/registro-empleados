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
                    <a class="nav-link" href="/formulario">Registrar visita</a>
                    <a class="nav-link {{ strpos(url()->current(), 'personas') ? 'active' : '' }}" aria-current="page"
                        href="/lista-personas">Ver listado</a>
                    <a class="nav-link {{ strpos(url()->current(), 'grafica') ? 'active' : '' }}"
                        href="/grafica">Estadísticas</a>
                    <!-- <a class="nav-link {{ strpos(url()->current(), 'reportes') ? 'active' : '' }}"
                        href="/reportes">Reportes</a> -->
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
                <!-- <a href="" class="btn btn-outline-light">Cerrar sesión</a> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
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
                    <a class="nav-link {{ strpos(url()->current(), 'formulario') ? 'active' : '' }}"
                        href="/formulario">Registrar visita</a>
                    <a class="nav-link {{ strpos(url()->current(), 'personas') ? 'active' : '' }}" aria-current="page"
                        href="/lista-personas">Ver listado</a>
                    <a class="nav-link {{ strpos(url()->current(), 'grafica') ? 'active' : '' }}"
                        href="/grafica">Estadísticas</a>
                    <!-- <a class="nav-link {{ strpos(url()->current(), 'reportes') ? 'active' : '' }}"
                        href="/reportes">Reportes</a> -->
                    <a class="nav-link {{ strpos(url()->current(), 'citas') ? 'active' : '' }}"
                        href="/citas">Control de citas</a>
                    @if (auth()->user()->id == 1)
                    <a class="nav-link {{ strpos(url()->current(), 'usuarios') ? 'active' : '' }}"
                        href="/usuarios">Usuarios</a>
                    @endif
                </div>
            </div>
            <li class="nav-item dropdown me-5">
                <a class="nav-link dropdown-toggle text-white me-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg> {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <form action="/logout" method="get">
                            <a href="#" class="dropdown-item" onclick="this.closest('form').submit()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                </svg> Cerrar sesión</a>
                        </form>
                    </li>
                </ul>
            </li>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <footer>
        <div class="text-center p-3 bg-dark text-white mt-4">
            Corpocentro ® <span id="year"></span>. RIF: J-20008343-3. Copyleft. Desarollado por la Oficina de Tecnología de Información y
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
    <script src="{{ asset('js/citas.js') }}"></script>
    <!--<script src="{{ asset('js/banner.js') }}"></script>-->
    <script src="{{ asset('js/multi-step.js') }}"></script>
    @if(session('success_alert'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Operación Exitosa!',
            text: @json(session('success_alert')),
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif

    @if(session('error_alert'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Operación Fallida!',
            text: @json(session('error_alert')),
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif

    @if(session('citas_alert'))
    <script>
        //Obtener dia actual
        const diaActual = new Date().toISOString().split('T')[0];

        Swal.fire({
            title: @json(session('citas_alert')),
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Ver citas pendientes",
            cancelButtonText: "Ver luego",
        }).then((result) => {
            if (result.isConfirmed) {
                $(location).attr('href', "/citas?inicio=" + diaActual + "&fin=" + diaActual);
            }
        })
    </script>
    @endif
    <script>
        // Obtener el año actual y establecerlo en el elemento con id "year"
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>

</html>