@extends('layouts.nav')
@section('content')
    <div class="modal fade" id="info-hijos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Información de hijo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form-hijos">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nombre completo:</label>
                            <input type="text" class="form-control" pattern="^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$" name="nombre_hijo" id="nombre_hijo" required>
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
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="estudiante_hijo" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Estudiante
                                    </label>
                                  </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_empleado" value="{{$empleado->id_empleado}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary registrar-hijo">Añadir</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="contenedor">
            <h3>Actualizar empleado</h3>
            <img src="img/header.png" class="mb-4" width="90%" alt="">
            <form class="needs-validation" action="{{route('update', ['id_empleado' => $empleado->id_empleado])}}" method="POST" novalidate>
                @csrf
                @method("PUT")
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Cédula:</label>
                        <input type="text" class="form-control" name="cedula" maxlength="9" pattern="[0-9]+" value="{{$empleado->cedula}}" required>
                        <div class="invalid-feedback">
                            Escribe tu número de cédula.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Nombre completo:</label>
                        <input type="text" class="form-control" pattern="^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$" value="{{$empleado->nombre}}" name="nombre" required>
                        <div class="invalid-feedback">
                            Escribe tu nombre completo.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Dirección de domicilio:</label>
                        <input type="text" class="form-control" name="direccion" value="{{$empleado->direccion}}" rows="3" required>
                        <div class="invalid-feedback">
                            Escribe tu dirección de domicilio.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" value="{{$empleado->fecha_nacimiento}}" rows="3" required>
                        <div class="invalid-feedback">
                            Escribe tu fecha de nacimiento.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Sexo:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" 
                            @if ($empleado->sexo == "Masculino") checked @endif value="Masculino">
                            <label class="form-check-label" for="inlineRadio1">Masculino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" 
                            @if ($empleado->sexo == "Femenino") checked @endif  value="Femenino">
                            <label class="form-check-label" for="inlineRadio2">Femenino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" 
                            @if ($empleado->sexo == "Otro") checked @endif  value="Otro">
                            <label class="form-check-label" for="inlineRadio2">Otro</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Correo:</label>
                        <input type="text" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú0-9._\-]+@[a-zA-ZÑñÁáÉéÍíÓóÚú0-9.\-]+\.[a-zA-Z]{2,}$" class="form-control" value="{{$empleado->correo}}" name="correo" required>
                        <div class="invalid-feedback">
                            Escribe tu dirección de correo electrónico.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Teléfono:</label>
                        <input type="text" pattern="[0-9]{11}" minlength="11" maxlength="11" value="{{$empleado->telefono}}" class="form-control" name="telefono" required>
                        <div class="invalid-feedback">
                            Escribe tu número de teléfono.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">¿Tiene hijos?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hijos" id="hijos_si" 
                            @if ($empleado->nro_hijos != 0) checked @endif
                                value="option1">
                            <label class="form-check-label" for="inlineRadio1">Si</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hijos" id="hijos_no" 
                            @if ($empleado->nro_hijos == 0) checked @endif
                                value="option2">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <div class="container_hijos">
                    <div class="mb-3 row">
                        <div class="col">
                            <input type="number" placeholder="Nro. de hijos" pattern="[0-9]+" class="form-control" value="{{$empleado->nro_hijos}}" name="nro_hijos" placeholder="Nro. de hijos"
                                required>
                                <div class="invalid-feedback">
                                    La cantidad de hijos debe coincidir con los hijos registrados.
                                </div>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#info-hijos">Añadir información</button>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Fecha de nacimiento</th>
                                    <th scope="col">Sexo</th>
                                    <th class="col">Estudiante</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hijos as $hijo)
                                    <tr class="{{$hijo->id_persona}}">
                                        <td>{!!$hijo->nombre!!}</td>
                                        <td>{!!$hijo->fecha_nacimiento!!}</td>
                                        <td>{!!$hijo->sexo!!}</td>
                                        <td>{!!($hijo->estudiante == 1)?"Si":"No"!!}</td>
                                        <td>
                                            <button type='buttom' class='funcion_eliminar_hijo btn btn-sm btn-danger' id="{{$hijo->id_persona}}"><img src='/img/trash.png' width='20px'></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Peso:</label>
                        <input type="number" class="form-control" value="{{$empleado->peso}}" name="peso" required>
                        <div class="invalid-feedback">
                            Escribe tu peso. Solo números.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Talla camisa:</label>
                        <select class="form-select" id="floatingSelect" id="validationCustom08" name="talla_camisa" required> 
                            <option @if ($empleado->talla_camisa == "XS") selected @endif value="XS">XS</option>
                            <option @if ($empleado->talla_camisa == "S") selected @endif value="S">S</option>
                            <option @if ($empleado->talla_camisa == "M") selected @endif value="M">M</option>
                            <option @if ($empleado->talla_camisa == "X") selected @endif value="X">X</option>
                            <option @if ($empleado->talla_camisa == "L") selected @endif value="L">L</option>
                            <option @if ($empleado->talla_camisa == "XL") selected @endif value="XL">XL</option>
                            <option @if ($empleado->talla_camisa == "XXL") selected @endif value="XXL">XXL</option>
                        </select>
                        <div class="invalid-feedback">
                            Escribe tu talla de camisa.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Talla pantalón:</label>
                        <input type="text" pattern="[0-9]+" class="form-control" value="{{$empleado->talla_pantalon}}" name="talla_pantalon" required>
                        <div class="invalid-feedback">
                            Escribe tu talla de pantalón.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Talla de zapato:</label>
                        <input type="text" pattern="[0-9]+" class="form-control" value="{{$empleado->talla_zapato}}" name="talla_zapato" required>
                        <div class="invalid-feedback">
                            Escribe tu talla de zapatos.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">¿Tiene carnet de la patria?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="carnet" id="carnet_si" 
                            @if ($carnet != null) checked @endif
                                value="option1">
                            <label class="form-check-label" for="inlineRadio1">Si</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="carnet" id="carnet_no" 
                            @if ($carnet == null) checked @endif
                                value="option2">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <div class="container_carnet">
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="exampleFormControlInput1" class="form-label">Código:</label>
                            <input type="text" pattern="[0-9]{10}" value="{{($carnet!=null)?$carnet->codigo:""}}" class="form-control" name="codigo" minlength="10" maxlength="10" required>
                            <div class="invalid-feedback">
                                Escribe un código válido.
                            </div>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1" class="form-label">Serial:</label>
                            <input type="text" pattern="[0-9]{10}" value="{{($carnet!=null)?$carnet->serial:""}}" minlength="10" maxlength="10" class="form-control" name="serial" required>
                            <div class="invalid-feedback">
                                Escribe un serial válido.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">¿Tiene alguna patologia
                            médica?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="patologia" id="patologia_si"
                                @if ($empleado->patologia != null) checked @endif value="option1">
                            <label class="form-check-label" for="inlineRadio1">Si</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="patologia" id="patologia_no"
                                @if ($empleado->patologia == null) checked @endif value="option2">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <div class="patologia_container">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Especifique:</label>
                        <input type="text" class="form-control" value="{{$empleado->patologia}}" rows="3" name="patologia" required>
                        <div class="invalid-feedback">
                            Especifique la patologia que tiene.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Oficina donde labora:</label>
                        <select class="select-oficina form-select mb-3" name="area">
                            @foreach ($areas as $area)
                                <option @if ($area->id == $empleado->area)
                                    selected
                                @endif value="{{$area->id}}">{!!$area->oficina!!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">Centro de votación:</label>
                        <select class="select-centro form-select mb-3" name="centro_electoral">
                            @foreach ($centros as $centro)
                                <option @if ($centro->id == $empleado->id_centro)
                                    selected 
                                    @endif value="{{$centro->id}}">{!!$centro->nombre_centro!!}</option>
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
                        <input type="date" class="form-control" value="{{$empleado->fecha_ingreso}}" name="fecha_ingreso" rows="3" required>
                        <div class="invalid-feedback">
                            Ingrese la fecha en que empezó a trabajar.
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlTextarea1" class="form-label">Cargo:</label>
                        <input type="text" class="form-control" value="{{$empleado->cargo}}" name="cargo" rows="3" required>
                        <div class="invalid-feedback">
                            Especifique su cargo.
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input @if ($empleado->estudiante == 1) checked @endif class="form-check-input" type="checkbox" value="1" name="estudiante" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Estudiante
                            </label>
                          </div>
                          <div class="form-check">
                            <input @if ($empleado->tipo == 1) checked @endif class="form-check-input" value="1" type="radio" name="tipo" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Trabajador fijo
                            </label>
                          </div>
                          <div class="form-check">
                            <input @if ($empleado->tipo == 0) checked @endif class="form-check-input" value="0" type="radio" name="tipo" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                              Contratado
                            </label>
                          </div>
                          <div class="form-check">
                            <input @if ($empleado->tipo == 2) checked @endif class="form-check-input" value="2" type="radio" name="tipo" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Pasante
                            </label>
                          </div>
                          <div class="form-check">
                            <input @if ($empleado->tipo == 3) checked @endif class="form-check-input" value="3" type="radio" name="tipo" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Jubilado
                            </label>
                          </div>
                    </div>
                </div>
                <input type="hidden" value="{{$empleado->id_persona}}" name="id_persona">
                <input type="submit" class="btn btn-primary" value="Enviar">
                <input type="reset" class="btn btn-secondary" value="Limpiar">
            </form>
            @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger my-5" role="alert">
                            {{$error}}
                        </div>  
                        @endforeach 
                    @endif
        </div>
    </div>
@endsection
