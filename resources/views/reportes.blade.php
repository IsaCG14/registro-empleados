@extends('layouts.nav')
@section('content')
  <div class="contenedor-grid">
    <div class="container">
        <h3 class="mb-4">Reportes de empleados</h3>
        <div class="col">
            <a href="/pdf" class="btn btn-primary mt-3" target="_blank">Generar PDF general</a>
        </div>
        <div class="row my-4">
            <div class="col">
                <form action="/pdf" method="get" target="_blank">
                    <label class="form-label">Empleados por centro de votación:</label>
                    <select class="form-select" name="centro">
                    @foreach ($centros as $centro)
                        <option value="{{$centro->id}}">{!!$centro->nombre_centro!!}</option>
                    @endforeach
                    </select>
                    <input type="hidden" name="tipo" value="1">
                    <input type="submit" class="btn btn-primary mt-3" value="Generar PDF">
                </form>
            </div>
            <div class="col">
                <form action="/pdf" method="get" target="_blank">
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
                <form action="/pdf" method="get" target="_blank">
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
                <form action="/pdf" method="get" target="_blank">
                    <label class="form-label">Empleados por fecha de ingreso:</label>
                    <input type="date" name="fecha_ingreso" id="" class="form-control">
                    <input type="hidden" name="tipo" value="4">
                    <input type="submit" class="btn btn-primary mt-3" value="Generar PDF">
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection