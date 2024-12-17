@extends('layouts.nav')
@section('content')
    <div class="contenedor-grid">
        <div class="container">
            <h3 class="mb-4">Reportes de empleados</h3>
            <div class="selects-attribute my-4">
                <div class="row">
                    <h6 class="my-3">Atributos que saldrán en el reporte (max. 8):</h6>
                    <div class="col col-lg-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"checked value="nombre">
                            <label class="form-check-label" for="inlineCheckbox1">Nombre</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" checked value="cedula">
                            <label class="form-check-label" for="inlineCheckbox2">Cédula</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="fecha_nacimiento">
                            <label class="form-check-label" for="inlineCheckbox1">Fecha de nacimiento</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="sexo">
                            <label class="form-check-label" for="inlineCheckbox2">Sexo</label>
                        </div>
                    </div>
                    <div class="col col-lg-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="correo">
                            <label class="form-check-label" for="inlineCheckbox1">Correo</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="telefono">
                            <label class="form-check-label" for="inlineCheckbox2">Télefono</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="direccion">
                            <label class="form-check-label" for="inlineCheckbox1">Dirección</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="peso">
                            <label class="form-check-label" for="inlineCheckbox2">Peso</label>
                        </div>
                    </div>
                    <div class="col col-lg-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="talla_camisa">
                            <label class="form-check-label" for="inlineCheckbox1">Talla de camisa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="talla_pantalon">
                            <label class="form-check-label" for="inlineCheckbox2">Talla de pantalón</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="talla_zapato">
                            <label class="form-check-label" for="inlineCheckbox1">Talla de zapato</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="estudiante">
                            <label class="form-check-label" for="inlineCheckbox2">Estudiante</label>
                        </div>
                    </div>
                    <div class="col col-lg-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="patologia">
                            <label class="form-check-label" for="inlineCheckbox1">Patologia</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="centro_electoral">
                            <label class="form-check-label" for="inlineCheckbox2">Centro electoral</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="tipo">
                            <label class="form-check-label" for="inlineCheckbox1">Tipo de contrato</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="cargo">
                            <label class="form-check-label" for="inlineCheckbox2">Cargo</label>
                        </div>
                    </div>
                    <div class="col col-lg-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="fecha_ingreso">
                            <label class="form-check-label" for="inlineCheckbox2">Fecha de ingreso</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="area">
                            <label class="form-check-label" for="inlineCheckbox2">Área</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="codigo">
                            <label class="form-check-label" for="inlineCheckbox2">Código de carnet de la patria</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="serial">
                            <label class="form-check-label" for="inlineCheckbox2">Serial de carnet de la patria</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <form action="/pdf" target="_blank" class="reporteForm">
                    <input type="hidden" name="tipo" value="0">
                    <input type="submit" class="btn btn-primary mt-3" value="Generar PDF general">
                </form>
            </div>
            <div class="row my-4">
                <div class="col">
                    <form action="/pdf" target="_blank" class="reporteForm">
                        <label class="form-label">Empleados por centro de votación:</label>
                        <select class="form-select" name="centro">
                            @foreach ($centros as $centro)
                                <option value="{{ $centro->id }}">{!! $centro->nombre_centro !!}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="tipo" value="1">
                        <input type="submit" class="btn btn-primary mt-3" value="Generar PDF">
                    </form>
                </div>
                <div class="col">
                    <form action="/pdf" target="_blank" class="reporteForm">
                        <label class="form-label">Empleados por sexo:</label>
                        <select class="form-select" name="sexo">
                            <option value="Femenino">Femenino</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <input type="hidden" name="tipo" value="2">
                        <input type="submit" class="btn btn-primary mt-3" value="Generar PDF">
                    </form>
                </div>
            </div>
            <div class="row my-4">
                <div class="col">
                    <form action="/pdf" target="_blank" class="reporteForm">
                        <label class="form-label">Empleados por contrato:</label>
                        <select class="form-select" name="tipo_empleado">
                            <option value="1">Trabajador fijo</option>
                            <option value="0">Contratado</option>
                            <option value="2">Pasante</option>
                            <option value="3">Jubilado</option>
                        </select>
                        <input type="hidden" name="tipo" value="3">
                        <input type="submit" class="btn btn-primary mt-3" value="Generar PDF">
                    </form>
                </div>
                <div class="col">
                    <form action="/pdf" target="_blank" class="reporteForm">
                        <label class="form-label">Empleados por fecha de ingreso:</label>
                        <input type="date" name="fecha_ingreso" id="" class="form-control" required>
                        <input type="hidden" name="tipo" value="4">
                        <input type="submit" class="btn btn-primary mt-3" value="Generar PDF">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
