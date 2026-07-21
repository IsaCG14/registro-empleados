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
        <div class="card-section">
            <h4>Datos personales</h4>
            @csrf
            <div class="mb-3 row">
                <div class="mb-3 col-lg-6">
                    <label for="cedula" class="form-label">Cédula<span>*</span>:</label>
                    <div class="input-group">
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
                    <label for="nombre" class="form-label">Nombre completo<span>*</span>:</label>
                    <input type="text" class="form-control" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú ]+" value="{{ old('nombre') }}"
                        name="nombre" id="nombre" required>
                    <div class="invalid-feedback">
                        Escribe tu nombre completo.
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento<span>*</span>:</label>
                    <input type="date" class="form-control" value="{{ old('fecha_nacimiento') }}" name="fecha_nacimiento"
                        id="fecha_nacimiento" required>
                    <div class="invalid-feedback">
                        Escribe tu fecha de nacimiento.
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="correo" class="form-label">Correo<span>*</span>:</label>
                    <input type="text" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú0-9._\-]+@[a-zA-ZÑñÁáÉéÍíÓóÚú0-9.\-]+\.[a-zA-Z]{2,}$"
                        class="form-control" value="{{ old('correo') }}" name="correo" id="correo" required>
                    <div class="invalid-feedback">
                        Escribe una dirección de correo electrónico válido.
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="telefono" class="form-label">Teléfono<span>*</span>:</label>
                    <input type="text" pattern="[0-9]{11}" minlength="11" maxlength="11" class="form-control"
                        value="{{ old('telefono') }}" name="telefono" id="telefono" required>
                    <div class="invalid-feedback">
                        Escribe un número de teléfono válido.
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label for="sexo-m" class="form-label">Sexo<span>*</span>:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="sexo-m" type="radio" name="sexo" checked value="1">
                        <label class="form-check-label" for="sexo-m">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="sexo-f" type="radio" name="sexo" value="0">
                        <label class="form-check-label" for="sexo-f">Femenino</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-section">
            <h4>Ubicación y fecha de atención</h4>
            <div class="mb-3 row">
                <div class="col-lg-6">
                    <label for="estado" class="form-label">Estado<span>*</span>:</label>
                    <select class="form-select mb-3" name="estado" id="estado" required>
                        @foreach($estados as $estado)
                        <option value="{!!$estado->id_estado!!}">{!!$estado->estado!!}</option>
                        @endforeach
                    </select>
                    <label for="municipio" class="form-label">Municipio<span>*</span>:</label>
                    <select class="form-select mb-3" name="municipio" id="municipio" required>
                        <option value="">Municipio</option>
                    </select>
                    <label for="parroquia" class="form-label">Parroquia<span>*</span>:</label>
                    <select class="form-select mb-3" name="parroquia" id="parroquia" required>
                        <option value="">Parroquia</option>
                    </select>
                    <div class="invalid-feedback">
                        Selecciona una ubicación válida.
                    </div>
                </div>
                <div class="col-lg-6">
                    <label for="fecha_cita" class="form-label">Fecha de atención<span>*</span>:</label>
                    <input type="date" class="form-control" value="{{ old('fecha_cita') }}" name="fecha_cita"
                        id="fecha_cita" required>
                    <div class="invalid-feedback">
                        Ingrese la fecha en que se atendió a la persona.
                    </div>
                </div>
            </div>
        </div>

        <div class="card-section">
            <h4>Circuito Comunal o Comuna</h4>
            <div class="mb-3 row">
                <div class="col-lg-6">
                    <label class="form-label">¿Su comunidad pertenece a un Circuito Comunal o Comuna?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="consejo" value="1">
                        <label class="form-check-label" for="consejo">
                            Comuna
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="consejo" checked>
                        <label class="form-check-label" for="consejo">
                            Circuito Comunal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="3" name="consejo" checked>
                        <label class="form-check-label" for="consejo">
                            No sabe
                        </label>
                    </div>
                    <div id="nombre_consejo" class="hidden mt-3">
                        <label for="nombre_consejo_input" class="form-label">Nombre del Circuito Comunal:</label>
                        <input type="text" class="form-control" value="{{ old('nombre_consejo') }}"
                            name="nombre_consejo" id="nombre_consejo_input">
                        <div class="invalid-feedback">
                            Escribe el nombre del circuito comunal.
                        </div>
                    </div>
                    <div id="nombre_comuna" class="hidden mt-3">
                        <label for="nombre_comuna_input" class="form-label">Nombre de la Comuna:</label>
                        <input type="text" class="form-control" value="{{ old('nombre_comuna') }}"
                            name="nombre_comuna" id="nombre_comuna_input">
                        <div class="invalid-feedback">
                            Escribe el nombre de la comuna.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-section">
            <h4>Detalles de la visita</h4>
            <div class="mb-3 row">
                <div class="col-lg-6">
                    <label for="detalles" class="form-label">Descripción:</label>
                    <textarea class="form-control" value="{{ old('detalles') }}" name="detalles" id="detalles"
                        rows="9"></textarea>
                    <div class="invalid-feedback">
                        Especifique los detalles de la visita.
                    </div>
                </div>
                <div class="col-lg-6">
                    <label class="form-label">Asunto Patria<span>*</span>:</label>
                    @foreach($asuntos as $asunto)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{!!$asunto->id!!}" id="patria-{!!$asunto->id!!}"
                            name="patria[]">
                        <label class="form-check-label" for="patria-{!!$asunto->id!!}">
                            {!!$asunto->opciones!!}
                        </label>
                    </div>
                    @endforeach
                    <div id="errorFeedback" class="invalid-feedback" style="display: none;">
                        Debes seleccionar al menos un asunto de patria.
                    </div>
                </div>
            </div>
        </div>

        <p><span>*</span> Campos obligatorios</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="reset" class="btn btn-secondary" value="Limpiar">
            <input type="submit" class="btn btn-primary" value="Enviar">
        </div>
    </div>
</form>
@endsection