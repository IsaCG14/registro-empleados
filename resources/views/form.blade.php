<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario de registro</title>
    <link href="{{ asset('librerias/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('librerias/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('librerias/bootstrap-icons.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="img/icono.png" />
</head>

<body>
    <div class="modal fade" id="info-hijos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Información de hijo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="GET" id="form-hijos">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nombre completo:</label>
                            <input type="text" class="form-control" pattern="^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$"
                                id="nombre_hijo" name="nombre_hijo" required>
                            <span id="error_nombre"></span>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Fecha de nacimiento:</label>
                            <input type="date" class="form-control" name="fecha_nacimiento_hijo"
                                id="fecha_nacimiento_hijo" required>
                            <span id="error_fecha"></span>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1" class="form-label">Sexo</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sexo_hijo" id="inlineRadio1"
                                    checked value="Masculino">
                                <label class="form-check-label" for="inlineRadio1">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sexo_hijo"
                                    id="inlineRadio2"value="Femenino">
                                <label class="form-check-label" for="inlineRadio2">Femenino</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="estudiante_hijo"
                                    id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Estudiante
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="agregar-hijo">Añadir</button>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar fixed-top bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/icono.png" alt="Logo" width="30" height="24"
                    class="d-inline-block align-text-top">
                CORPOCENTRO
            </a>
            <h3 class="text-white">Registro de empleados</h3>
            <a href="/login" class="btn btn-outline-light">Iniciar sesión</a>
        </div>
    </nav>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger my-5" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <div class="container">
        <div class="progreso my-5">
            <div class="paso-1">
                <i class="bi bi-1-square-fill imhere"></i>
                <p>-------</p>
            </div>
            <div class="paso-2">
                <i class="bi bi-2-square-fill"></i>
                <p>-------</p>
            </div>
            <div class="paso-3">
                <i class="bi bi-3-square-fill"></i>
                <p>-------</p>
            </div>
            <div class="paso-4">
                <i class="bi bi-4-square-fill"></i>
                <p>-------</p>
            </div>
            <div class="paso-5">
                <i class="bi bi-5-square-fill"></i>
            </div>
        </div>
        <form class="needs-validation" action="/guardar-empleado" method="POST" novalidate>
            <div class="contenedor">
                <h4 class="mb-5">Datos personales</h4>
                @csrf
                <div class="mb-3 row">
                    <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Cédula<span>*</span>:</label>
                        <input type="text" class="form-control" value="{{ old('cedula') }}" maxlength="9"
                            pattern="[0-9]+" name="cedula" required>
                        <div class="invalid-feedback">
                            Escribe tu número de cédula.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nombre
                            completo<span>*</span>:</label>
                        <input type="text" class="form-control" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú ]+"
                            value="{{ old('nombre') }}" name="nombre" required>
                        <div class="invalid-feedback">
                            Escribe tu nombre completo.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Dirección de
                            domicilio<span>*</span>:</label>
                        <input type="text" class="form-control" value="{{ old('direccion') }}" name="direccion"
                            rows="3" required>
                        <div class="invalid-feedback">
                            Escribe tu dirección de domicilio.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de
                            nacimiento<span>*</span>:</label>
                        <input type="date" class="form-control" value="{{ old('fecha_nacimiento') }}"
                            name="fecha_nacimiento" rows="3" required>
                        <div class="invalid-feedback">
                            Escribe tu fecha de nacimiento.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Correo<span>*</span>:</label>
                        <input type="text"
                            pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú0-9._\-]+@[a-zA-ZÑñÁáÉéÍíÓóÚú0-9.\-]+\.[a-zA-Z]{2,}$"
                            class="form-control" value="{{ old('correo') }}" name="correo" required>
                        <div class="invalid-feedback">
                            Escribe una dirección de correo electrónico válido.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Teléfono<span>*</span>:</label>
                        <input type="text" pattern="[0-9]{11}" minlength="11" maxlength="11"
                            class="form-control" value="{{ old('telefono') }}" name="telefono" required>
                        <div class="invalid-feedback">
                            Escribe un número de teléfono válido.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Sexo<span>*</span>:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" checked value="Masculino">
                            <label class="form-check-label" for="inlineRadio1">Masculino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" value="Femenino">
                            <label class="form-check-label" for="inlineRadio2">Femenino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" value="Otro">
                            <label class="form-check-label" for="inlineRadio2">Otro</label>
                        </div>
                    </div>
                </div>
                <p><span>*</span> Campos obligatorios</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary next-button" style="pointer-events: auto;"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Debe llenar todos los campos para poder avanzar.">Siguiente <img src="/img/right.png"
                            alt="next" width="15"></button>
                </div>
            </div>
            <div class="contenedor contenedor-hide">
                <h4 class="mb-5">Datos de hijos</h4>
                <div class="col-lg-6">
                    <label for="exampleFormControlInput1" class="form-label">¿Tiene hijos?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="hijos" id="hijos_si" checked
                            value="option1">
                        <label class="form-check-label" for="inlineRadio1">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="hijos" id="hijos_no"
                            value="option2">
                        <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
                <div class="container_hijos">
                    <div class="mb-3 row">
                        <div class="col-lg-6">
                            <label for="nro_hijos" class="form-label">Cantidad de hijos<span>*</span>:</label>
                            <input type="number" pattern="[1-9]+" class="form-control mb-3" name="nro_hijos"
                                value="0" placeholder="Nro. de hijos" required>
                            <div class="invalid-feedback">
                                La cantidad de hijos debe ser mayor a 0 y coincidir con los hijos registrados.
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <button type="button" class="btn btn-primary mt-4" id="añadirHijo">Añadir
                                información</button>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <table class="table table-hijos">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Fecha de nacimiento</th>
                                    <th scope="col">Sexo</th>
                                    <th scope="col">Estudiante</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="valores-hijos">
                </div>
                <p><span>*</span> Campos obligatorios</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end align-items-md-end">
                    <button type="button" class="btn btn-primary back-button"><img src="/img/left.png"
                            alt="next" width="15"> Anterior</button>
                    <button type="button" class="btn btn-primary next-button" style="pointer-events: auto;"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Debe llenar todos los campos para poder avanzar.">Siguiente <img src="/img/right.png"
                            alt="next" width="15"></button>
                </div>
            </div>
            <div class="contenedor contenedor-hide">
                <h4 class="mb-5">Datos antropológicos</h4>
                <div class="mb-3 row">
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Peso en kg<span>*</span>:</label>
                        <input type="text" value="{{ old('peso') }}" minlength="1" maxlength="3"
                            pattern="[0-9]+" class="form-control" name="peso" required>
                        <div class="invalid-feedback">
                            Escribe tu peso. Solo números.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Talla camisa<span>*</span>:</label>
                        <select class="form-select" id="floatingSelect" id="validationCustom08" name="talla_camisa"
                            required>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="X">X</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                        <div class="invalid-feedback">
                            Escribe tu talla de camisa.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Talla pantalón<span>*</span>:</label>
                        <input type="text" pattern="[0-9]+" minlength="1" maxlength="3" class="form-control"
                            value="{{ old('talla_pantalon') }}" name="talla_pantalon" required>
                        <div class="invalid-feedback">
                            Escribe tu talla de pantalón.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlInput1" class="form-label">Talla de
                            zapato<span>*</span>:</label>
                        <input type="text" pattern="[0-9]+" minlength="1" maxlength="2" class="form-control"
                            value="{{ old('talla_zapato') }}" name="talla_zapato" required>
                        <div class="invalid-feedback">
                            Escribe tu talla de zapatos.
                        </div>
                    </div>
                </div>
                <p><span>*</span> Campos obligatorios</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary back-button"><img src="/img/left.png"
                            alt="next" width="15"> Anterior</button>
                    <button type="button" class="btn btn-primary next-button" style="pointer-events: auto;"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Debe llenar todos los campos para poder avanzar.">Siguiente <img src="/img/right.png"
                            alt="next" width="15"></button>
                </div>
            </div>
            <div class="contenedor contenedor-hide">
                <h4 class="mb-5">Datos de carnet</h4>
                <div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="exampleFormControlInput1" class="form-label">¿Tiene carnet de la
                                patria?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="carnet" id="carnet_si" checked
                                    value="option1">
                                <label class="form-check-label" for="inlineRadio1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="carnet" id="carnet_no"
                                    value="option2">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="container_carnet">
                        <div class="mb-3 row">
                            <div class="col-lg-6">
                                <label for="exampleFormControlInput1" class="form-label">Código<span>*</span>:</label>
                                <input type="text" pattern="[0-9]{10}" class="form-control"
                                    value="{{ old('codigo') }}" name="codigo" minlength="10" maxlength="10"
                                    required>
                                <div class="invalid-feedback">
                                    Escribe un código válido.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="exampleFormControlInput1" class="form-label">Serial<span>*</span>:</label>
                                <input type="text" pattern="[0-9]{10}" minlength="10" maxlength="10"
                                    class="form-control" value="{{ old('serial') }}" name="serial" required>
                                <div class="invalid-feedback">
                                    Escribe un serial válido.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="mb-5">Datos médicos</h4>
                <div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="exampleFormControlInput1" class="form-label">¿Tiene alguna patologia
                                médica?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="patologia" id="patologia_si"
                                    checked value="option1">
                                <label class="form-check-label" for="inlineRadio1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="patologia" id="patologia_no"
                                    value="option2">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="container_patologia">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1"
                                class="form-label">Especifique<span>*</span>:</label>
                            <input type="text" class="form-control" rows="3"
                                value="{{ old('patologia') }}" name="patologia" required>
                            <div class="invalid-feedback">
                                Especifique la patologia que tiene.
                            </div>
                        </div>
                    </div>
                </div>
                <p><span>*</span> Campos obligatorios</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary back-button"><img src="/img/left.png"
                            alt="next" width="15"> Anterior</button>
                    <button type="button" class="btn btn-primary next-button" style="pointer-events: auto;"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Debe llenar todos los campos para poder avanzar.">Siguiente <img src="/img/right.png"
                            alt="next" width="15"></button>
                </div>
            </div>
            <div class="contenedor contenedor-hide">
                <h4 class="mb-5">Datos laborales y electorales</h4>
                <div class="mb-3 row">
                    <div class="col-lg-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Oficina donde
                            labora<span>*</span>:</label>
                        <select class="select-oficina form-select mb-3" name="area">
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{!! $area->oficina !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Centro de votación<span>*</span>:</label>
                        <select class="select-centro form-select mb-3" name="centro_electoral">
                            @foreach ($centros as $centro)
                                <option value="{{ $centro->id }}">{!! $centro->nombre_centro !!}</option>
                            @endforeach
                        </select>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="new_centro">
                            <label class="form-check-label" for="flexCheckDefault">
                                Otro centro
                            </label>
                        </div>
                        <div id="otro_centro"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-lg-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de
                            ingreso<span>*</span>:</label>
                        <input type="date" class="form-control" value="{{ old('fecha_ingreso') }}"
                            name="fecha_ingreso" rows="3" required>
                        <div class="invalid-feedback">
                            Ingrese la fecha en que empezó a trabajar.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Cargo<span>*</span>:</label>
                        <input type="text" class="form-control" value="{{ old('cargo') }}" name="cargo"
                            rows="3" required>
                        <div class="invalid-feedback">
                            Especifique su cargo.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="estudiante"
                                id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Estudiante
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="1" type="radio" name="tipo"
                                id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Trabajador fijo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="0" type="radio" name="tipo"
                                id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Contratado
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="2" type="radio" name="tipo"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Pasante
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="3" type="radio" name="tipo"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Jubilado
                            </label>
                        </div>
                    </div>
                </div>
                <p><span>*</span> Campos obligatorios</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary back-button"><img src="/img/left.png"
                            alt="next" width="15"> Anterior</button>
                    <input type="reset" class="btn btn-secondary" value="Limpiar">
                    <input type="submit" class="btn btn-primary" value="Enviar">
                </div>
            </div>
        </form>
    </div>
    <!--<button class="eliminar-hijo btn btn-danger">eliminar</button>-->
    <script src="{{ asset('librerias/jquery-3.7.1.min.js.js') }}"></script>
    <script src="{{ asset('librerias/bootstrap.bundle.min.js.js') }}"></script>
    <script src="{{ asset('librerias/select2.min.js.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/banner.js') }}"></script>
    <script src="{{ asset('js/multi-step.js') }}"></script>
</body>

</html>
