<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control de empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.7/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("css/styles.css")}}">
    <link rel="stylesheet" href="{{asset("css/jquery.dataTables.min.css")}}">
    <link rel="shortcut icon" href="img/icono.png"/>
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
                    <a class="nav-link" aria-current="page" href="/lista-empleados">Inicio</a>
                    <a class="nav-link" href="/grafica">Estadísticas</a>
                    <a class="nav-link" target="_blank" href="/formulario">Registrar</a>
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
                    <a class="nav-link {{(strpos(url()->current(), 'empleados'))?'active':''}}" aria-current="page" href="/lista-empleados">Inicio</a>
                    <a class="nav-link {{(strpos(url()->current(), 'grafica'))?'active':''}}" href="/grafica">Estadísticas</a>
                    <a class="nav-link" target="_blank" href="/formulario">Registrar</a>
                    @if (session("usuario") == "Master")
                        <a class="nav-link {{(strpos(url()->current(), 'usuarios'))?'active':''}}" href="/usuarios">Usuarios</a>
                    @endif
                </div>
            </div>
            <div>
                <form action="/logout" method="get">
                    <a href="#" onclick="this.closest('form').submit()" class="btn btn-outline-light">Cerrar sesión</a>
                </form>
            </div>
        </div>
    </nav>
    @yield("content")
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="{{asset("js/dataTables.bootstrap5.min.js")}}"></script>
    <script src="{{asset("js/bootstrap.js")}}"></script>
    <script src="{{asset("js/app.js")}}"></script>
    <script src="{{asset("js/validation.js")}}"></script>
    <script src="{{asset("js/datatable.js")}}"></script>
    <script src="{{asset("js/ajax-modal.js")}}"></script>
    <script src="{{asset("js/ajax-hijo.js")}}"></script>
    <script src="{{asset("js/sweetalert2@11.js")}}"></script>
    <script src="{{asset("js/alerts.js")}}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
    </body>
</html>
