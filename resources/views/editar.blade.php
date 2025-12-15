@extends('layouts.nav')
@section('content')
<div class="container">
    <div class="contenedor">
        <h3>Actualizar Asunto</h3>
        <img src="img/header.png" class="mb-4" width="90%" alt="">
        <form class="needs-validation" action="{{route('update', ['id' => $cita->id])}}" method="POST" novalidate>
            @csrf
            @method("PUT")
            <div class="mb-3 row">
                <div class="col">
                    <label for="exampleFormControlInput1" class="form-label">Cédula:</label>
                    <input type="text" class="form-control" name="cedula" maxlength="9" pattern="[0-9]+"
                        value="{{$cita->personas->cedula}}" required>
                    <div class="invalid-feedback">
                        Escribe tu número de cédula.
                    </div>
                </div>
                <div class="col">
                    <label for="exampleFormControlInput1" class="form-label">Nombre completo:</label>
                    <input type="text" class="form-control" pattern="^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$"
                        value="{{$cita->personas->nombre}}" name="nombre" required>
                    <div class="invalid-feedback">
                        Escribe tu nombre completo.
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label for="exampleFormControlTextarea1" class="form-label">Fecha de nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_nacimiento"
                        value="{{$cita->personas->fecha_nacimiento}}" rows="3" required>
                    <div class="invalid-feedback">
                        Escribe tu fecha de nacimiento.
                    </div>
                </div>
                <div class="col">
                    <label for="exampleFormControlInput1" class="form-label">Teléfono:</label>
                    <input type="text" pattern="[0-9]{11}" minlength="11" maxlength="11"
                        value="{{$cita->personas->telefono}}" class="form-control" name="telefono" required>
                    <div class="invalid-feedback">
                        Escribe tu número de teléfono.
                    </div>
                </div>
                <div class="col">
                    <label for="exampleFormControlInput1" class="form-label">Correo:</label>
                    <input type="text" pattern="[a-zA-ZÑñÁáÉéÍíÓóÚú0-9._\-]+@[a-zA-ZÑñÁáÉéÍíÓóÚú0-9.\-]+\.[a-zA-Z]{2,}$"
                        class="form-control" value="{{$cita->personas->correo}}" name="correo" required>
                    <div class="invalid-feedback">
                        Escribe tu dirección de correo electrónico.
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label for="exampleFormControlInput1" class="form-label">Sexo:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" @if ($cita->personas->sexo == 1)
                        checked @endif value="1">
                        <label class="form-check-label" for="inlineRadio1">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" @if ($cita->personas->sexo == 0)
                        checked @endif value="0">
                        <label class="form-check-label" for="inlineRadio2">Femenino</label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-lg-6">
                    <label class="form-label">Asunto Patria<span>*</span>:</label>
                    @foreach($asuntos_patria as $patria)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{!!$patria->id!!}" id="checkDefault"
                            name="patria[]"
                            {{ in_array($patria->id, $cita->asuntos->pluck('patria_id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="patria">
                            {!!$patria->opciones!!}
                        </label>
                    </div>
                    @endforeach
                    <div id="errorFeedback" class="invalid-feedback" style="display: none;">
                        Debes seleccionar al menos un asunto de patria.
                    </div>
                </div>
                <div class="col">
                    <label for="exampleFormControlTextarea1" class="form-label">Proveniencia:</label>
                    <div class="col-lg-6">
                        <select class="form-select mb-3" name="estado" id="estado">
                            @foreach($estados as $estado)
                            <option value="{{ $estado->id_estado }}"
                                {{ $proveniencia->municipio->estado->id_estado == $estado->id_estado ? 'selected' : '' }}>
                                {{ $estado->estado }}
                            </option>
                            @endforeach
                        </select>
                        <select class="form-select mb-3" name="municipio" id="municipio">
                            @foreach($municipios as $municipio)
                            <option value="{{ $municipio->id_municipio }}"
                                {{ $proveniencia->municipio->id_municipio == $municipio->id_municipio ? 'selected' : '' }}>
                                {{ $municipio->municipio }}
                            </option>
                            @endforeach
                        </select>
                        <select class="form-select mb-3" name="parroquia" id="parroquia">
                            @foreach($parroquias as $parroquia)
                            <option value="{{ $parroquia->id_parroquia }}"
                                {{ $proveniencia->id_parroquia == $parroquia->id_parroquia ? 'selected' : '' }}>
                                {{ $parroquia->parroquia }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="invalid-feedback">
                        Escribe tu proveniencia.
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-lg-6">
                    <!-- <div>
                        <label for="exampleFormControlTextarea1" class="form-label">¿Su comunidad pertenece a un
                            consejo
                            comunal?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="consejo" value="1">
                            <label class="form-check-label" for="consejo" {{ $cita->consejo_comunal ? 'checked' : '' }}>
                                Si
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="0" name="consejo">
                            <label class="form-check-label" for="consejo">
                                No
                            </label>
                        </div>
                    </div> -->
                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Nombre del consejo
                            comunal:</label>
                        <input type="text" class="form-control" value="{{$cita->consejo_comunal}}"
                            name="nombre_consejo" id="nombre_consejo">
                        <div class="invalid-feedback">
                            Escribe el nombre del consejo comunal.
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- <div>
                        <label for="exampleFormControlTextarea1" class="form-label">¿Su comunidad pertenece a una
                            Comuna?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comuna" value="1">
                            <label class="form-check-label" for="comuna" {{ $cita->comuna ? 'checked' : '' }}>
                                Si
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comuna" value="0">
                            <label class="form-check-label" for="comuna">
                                No
                            </label>
                        </div>
                    </div> -->
                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Nombre de la
                            Comuna:</label>
                        <input type="text" class="form-control" value="{{$cita->comuna}}" name="nombre_comuna"
                            id="nombre_comuna">
                        <div class="invalid-feedback">
                            Escribe el nombre de la comuna.
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label for="exampleFormControlTextarea1" class="form-label">Fecha de atención:</label>
                    <input type="date" class="form-control" value="{{$cita->fecha_atencion}}" name="fecha_atencion" rows="3"
                        required>
                    <div class="invalid-feedback">
                        Ingrese la fecha de atención.
                    </div>
                </div>
                <div class="col">
                    <label for="exampleFormControlTextarea1" class="form-label">Detalles:</label>
                    <textarea class="form-control" name="detalles" rows="5">{{$cita->detalles}}</textarea>
                    <div class="invalid-feedback">
                        Especifique los detalles de la cita.
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{$cita->id}}" name="id">
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