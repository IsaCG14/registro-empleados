@extends('layouts.nav')
@section('content')
@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-danger my-5" role="alert">
    {{ $error }}
</div>
@endforeach
@endif
<!-- <div class="progreso my-5">
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
        </div> -->
<form class="needs-validation" action="/guardar-persona" method="POST" novalidate>
    <div class="contenedor">
        <h4 class="mb-5">Datos personales</h4>
        @csrf
        <div class="mb-3 row">
            <!-- <div class="col-lg-6 mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Cédula<span>*</span>:</label>
                        <input type="text" class="form-control" value="{{ old('cedula') }}" maxlength="9"
                            pattern="[0-9]+" name="cedula" required>
                        <div class="invalid-feedback">
                            Escribe tu número de cédula.
                        </div>
                    </div> -->

            <div class="mb-3 col-lg-6">
                <label for="cedula" class="form-label" aria-label="Recipient’s username"
                    aria-describedby="button-addon2">Cédula<span>*</span>:</label>
                <div class="col-lg-6 mb-3 input-group">
                    <input type="text" class="form-control" maxlength="8" value="{{ old('cedula') }}" pattern="[0-9]+"
                        name="cedula" id="cedula" required>
                    <div class="invalid-feedback">
                        Escribe tu número de cédula.
                    </div>
                    <button class="btn btn-outline-secondary" type="button" id="button-search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </button>
                </div>
                <span id="messaje-cedula"></span>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nombre
                    completo<span>*</span>:</label>
                <input type="text" class="form-control" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú ]+" value="{{ old('nombre') }}"
                    name="nombre" id="nombre" required>
                <div class="invalid-feedback">
                    Escribe tu nombre completo.
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Fecha de
                    nacimiento<span>*</span>:</label>
                <input type="date" class="form-control" value="{{ old('fecha_nacimiento') }}" name="fecha_nacimiento"
                    rows="3" id="fecha_nacimiento" required>
                <div class="invalid-feedback">
                    Escribe tu fecha de nacimiento.
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="exampleFormControlInput1" class="form-label">Correo<span>*</span>:</label>
                <input type="text" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú0-9._\-]+@[a-zA-ZÑñÁáÉéÍíÓóÚú0-9.\-]+\.[a-zA-Z]{2,}$"
                    class="form-control" value="{{ old('correo') }}" name="correo" id="correo" required>
                <div class="invalid-feedback">
                    Escribe una dirección de correo electrónico válido.
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="exampleFormControlInput1" class="form-label">Teléfono<span>*</span>:</label>
                <input type="text" pattern="[0-9]{11}" minlength="11" maxlength="11" class="form-control"
                    value="{{ old('telefono') }}" name="telefono" id="telefono" required>
                <div class="invalid-feedback">
                    Escribe un número de teléfono válido.
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <label for="exampleFormControlInput1" class="form-label">Sexo<span>*</span>:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="sexo-m" type="radio" name="sexo" checked value="1">
                    <label class="form-check-label" for="inlineRadio1">Masculino</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="sexo-f" type="radio" name="sexo" value="0">
                    <label class="form-check-label" for="inlineRadio2">Femenino</label>
                </div>
            </div>
            <hr>
            <div class="mt-3">
                <h4 class="mb-5">Datos de consulta</h4>
                <div class="mb-3 row">
                    <div class="col-lg-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Parroquia de la que
                            proviene:<span>*</span>:</label>
                        <select class="form-select mb-3" name="estado" id="estado" required>
                            @foreach($estados as $estado)
                            <option value="{!!$estado->id_estado!!}">{!!$estado->estado!!}</option>
                            @endforeach
                        </select>
                        <select class="form-select mb-3" name="municipio" id="municipio" required>
                            <option value="">Municipio</option>
                        </select>
                        <select class="form-select mb-3" name="parroquia" id="parroquia" required>
                            <option value="">Parroquia</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecciona una ubicación válida.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de
                            atención<span>*</span>:</label>
                        <input type="date" class="form-control" value="{{ old('fecha_cita') }}" name="fecha_cita"
                            rows="3" required>
                        <div class="invalid-feedback">
                            Ingrese la fecha en que se atendió a la persona.
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <div class="col-lg-6">
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">¿Su comunidad pertenece a un
                                consejo
                                comunal?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="consejo" value="1">
                                <label class="form-check-label" for="consejo">
                                    Si
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="0" name="consejo" checked>
                                <label class="form-check-label" for="consejo">
                                    No
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">Nombre del consejo
                                comunal:</label>
                            <input type="text" class="form-control" value="{{ old('nombre_consejo') }}"
                                name="nombre_consejo" id="nombre_consejo" disabled>
                            <div class="invalid-feedback">
                                Escribe el nombre del consejo comunal.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">¿Su comunidad pertenece a una
                                Comuna?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="comuna" value="1">
                                <label class="form-check-label" for="comuna">
                                    Si
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="comuna" checked value="0">
                                <label class="form-check-label" for="comuna">
                                    No
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">Nombre de la
                                Comuna:</label>
                            <input type="text" class="form-control" value="{{ old('nombre_comuna') }}"
                                name="nombre_comuna" id="nombre_comuna" disabled>
                            <div class="invalid-feedback">
                                Escribe el nombre de la comuna.
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <div class="col-lg-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Descripción:</label>
                        <textarea class="form-control" value="{{ old('detalles') }}" name="detalles"
                            rows="9"></textarea>
                        <div class="invalid-feedback">
                            Especifique los detalles de la visita.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Asunto Patria<span>*</span>:</label>
                        @foreach($asuntos as $asunto)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{!!$asunto->id!!}" id="checkDefault"
                                name="patria[]">
                            <label class="form-check-label" for="patria">
                                {!!$asunto->opciones!!}
                            </label>
                        </div>
                        @endforeach
                        <div id="errorFeedback" class="invalid-feedback" style="display: none;">
                            Debes seleccionar al menos un asunto de patria.
                        </div>
                        <!-- <select class="form-select mb-3" name="patria">
                            @foreach($asuntos as $asunto)
                            <option value="{!!$asunto->id!!}">{!!$asunto->opciones!!}</option>
                            @endforeach
                        </select> -->
                    </div>
                </div>
                <p><span>*</span> Campos obligatorios</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <!-- <button type="button" class="btn btn-primary back-button"><img src="/img/left.png"
                            alt="next" width="15"> Anterior</button> -->
                    <input type="reset" class="btn btn-secondary" value="Limpiar">
                    <input type="submit" class="btn btn-primary" value="Enviar">
                </div>
            </div>
        </div>
        <!-- <p><span>*</span> Campos obligatorios</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary next-button" style="pointer-events: auto;"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Debe llenar todos los campos para poder avanzar.">Siguiente <img src="/img/right.png"
                            alt="next" width="15"></button>
                </div> -->
    </div>
</form>
@endsection