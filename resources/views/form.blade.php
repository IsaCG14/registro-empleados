<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario de registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="img/icono.png"/>
</head>

<body>
    <div class="modal fade" id="info-hijos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Información de hijo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="GET" id="form-hijos">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nombre completo:</label>
                            <input type="text" class="form-control" pattern="^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$" id="nombre_hijo" name="nombre_hijo" required>
                            <span id="error_nombre"></span>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Fecha de nacimiento:</label>
                            <input type="date" class="form-control" name="fecha_nacimiento_hijo" id="fecha_nacimiento_hijo" required>
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
                                <input class="form-check-input" type="checkbox" value="1" name="estudiante_hijo" id="flexCheckDefault">
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
            <img src="img/icono.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            CORPOCENTRO
          </a>
          <a href="/login" class="btn btn-outline-light">Iniciar sesión</a>
        </div>
      </nav>
      @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger my-5" role="alert">
                {{$error}}
            </div>  
        @endforeach 
        @endif
    <div class="container">
        <div class="contenedor">
            <img src="img/header.png" class="mb-4" width="90%" alt="">
            <h3 class="mb-5">Registro de empleados</h3>
            <form class="needs-validation" action="/guardar-empleado" method="POST" novalidate>
                @csrf
                <hr class="my-4 border border-secondary border-2 opacity-25">
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Cédula:</label>
                        <input type="text" class="form-control" value="{{ old('cedula') }}" maxlength="9" pattern="[0-9]+" name="cedula" required>
                        <div class="invalid-feedback">
                            Escribe tu número de cédula.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Nombre completo:</label>
                        <input type="text" class="form-control" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú ]+" value="{{ old('nombre') }}" name="nombre" required>
                        <div class="invalid-feedback">
                            Escribe tu nombre completo.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Dirección de domicilio:</label>
                        <input type="text" class="form-control" value="{{ old('direccion') }}" name="direccion" rows="3" required>
                        <div class="invalid-feedback">
                            Escribe tu dirección de domicilio.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" value="{{ old('fecha_nacimiento') }}" name="fecha_nacimiento" rows="3" required>
                        <div class="invalid-feedback">
                            Escribe tu fecha de nacimiento.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Sexo:</label>
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
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Correo:</label>
                        <input type="text" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú0-9._\-]+@[a-zA-ZÑñÁáÉéÍíÓóÚú0-9.\-]+\.[a-zA-Z]{2,}$" class="form-control" value="{{ old('correo') }}" name="correo" required>
                        <div class="invalid-feedback">
                            Escribe tu dirección de correo electrónico.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Teléfono:</label>
                        <input type="text" pattern="[0-9]{11}" minlength="11" maxlength="11"  class="form-control" value="{{ old('telefono') }}" name="telefono" required>
                        <div class="invalid-feedback">
                            Escribe tu número de teléfono.
                        </div>
                    </div>
                </div>
                <hr class="my-4 border border-secondary border-2 opacity-25">
                <div class="mb-3 row">
                    <div class="col">
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
                </div>
                <div class="container_hijos">
                    <div class="mb-3 row">
                        <div class="col">
                            <input type="number" pattern="[0-9]+" class="form-control" value="0" name="nro_hijos" value="{{ old('nro_hijos') }}" placeholder="Nro. de hijos"
                                required>
                                <div class="invalid-feedback">
                                    La cantidad de hijos debe coincidir con los hijos registrados.
                                </div>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary" id="añadirHijo">Añadir información</button>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <table class="table">
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
                <hr class="my-4 border border-secondary border-2 opacity-25">
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Peso en kg:</label>
                        <input type="text" value="{{ old('peso') }}" pattern="[0-9]+" class="form-control" name="peso" required>
                        <div class="invalid-feedback">
                            Escribe tu peso. Solo números.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Talla camisa:</label>
                        <select class="form-select" id="floatingSelect" id="validationCustom08" name="talla_camisa" required> 
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
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Talla pantalón:</label>
                        <input type="text" pattern="[0-9]+" class="form-control" value="{{ old('talla_pantalon') }}" name="talla_pantalon" required>
                        <div class="invalid-feedback">
                            Escribe tu talla de pantalón.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Talla de zapato:</label>
                        <input type="text" pattern="[0-9]+" class="form-control" value="{{ old('talla_zapato') }}" name="talla_zapato" required>
                        <div class="invalid-feedback">
                            Escribe tu talla de zapatos.
                        </div>
                    </div>
                </div>
                <hr class="my-4 border border-secondary border-2 opacity-25">
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">¿Tiene carnet de la patria?</label>
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
                        <div class="col">
                            <label for="exampleFormControlInput1" class="form-label">Código:</label>
                            <input type="text" pattern="[0-9]{10}" class="form-control" value="{{ old('codigo') }}" name="codigo" minlength="10" maxlength="10" required>
                            <div class="invalid-feedback">
                                Escribe un código válido.
                            </div>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1" class="form-label">Serial:</label>
                            <input type="text" pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control" value="{{ old('serial') }}" name="serial" required>
                            <div class="invalid-feedback">
                                Escribe un serial válido.
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4 border border-secondary border-2 opacity-25">
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
                <div class="patologia_container">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Especifique:</label>
                        <input type="text" class="form-control" rows="3" value="{{ old('patologia') }}" name="patologia" required>
                        <div class="invalid-feedback">
                            Especifique la patologia que tiene.
                        </div>
                    </div>
                </div>
                <hr class="my-4 border border-secondary border-2 opacity-25">
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Oficina donde labora:</label>
                        <select class="select-oficina form-select mb-3" name="area">
                            @foreach ($areas as $area)
                                <option value="{{$area->id}}">{!!$area->oficina!!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">Centro de votación:</label>
                        <select class="select-centro form-select mb-3" name="centro_electoral">
                            @foreach ($centros as $centro)
                                <option value="{{$centro->id}}">{!!$centro->nombre_centro!!}</option>
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
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de ingreso:</label>
                        <input type="date" class="form-control" value="{{ old('fecha_ingreso') }}" name="fecha_ingreso" rows="3" required>
                        <div class="invalid-feedback">
                            Ingrese la fecha en que empezó a trabajar.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Cargo:</label>
                        <input type="text" class="form-control" value="{{ old('cargo') }}" name="cargo" rows="3" required>
                        <div class="invalid-feedback">
                            Especifique su cargo.
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="estudiante" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Estudiante
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" value="1" type="radio" name="tipo" id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                              Trabajador fijo
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" value="0" type="radio" name="tipo" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                              Contratado
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" value="2" type="radio" name="tipo" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Pasante
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" value="3" type="radio" name="tipo" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Jubilado
                            </label>
                          </div>
                    </div>
                    <hr class="my-4 border border-secondary border-2 opacity-25">
                </div>
                <input type="submit" class="btn btn-primary" value="Enviar">
                <input type="reset" class="btn btn-secondary" value="Limpiar">
            </form>
        </div>
    </div>
    <!--<button class="eliminar-hijo btn btn-danger">eliminar</button>-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>
    <script src="{{ asset("js/sweetalert2@11.js") }}"></script>
    <script src="{{ asset('js/banner.js') }}"></script>
</body>

</html>
