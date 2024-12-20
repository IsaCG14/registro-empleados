@extends('layouts.nav')
@section('content')
    <div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-header-background" data-bs-theme="dark">
                    <h3 class="modal-title text-center w-100" id="exampleModalLabel">Información empleado</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="informacion-personal col"></div>
                    <div class="col">
                        <div class="informacion-laboral my-3"></div>
                        <div class="informacion-carnet"></div>
                    </div>
                    <div class="informacion-hijos col">
                        <h5>Hijos</h5>
                        <table class="table">
                            <thead>
                                <th>Nombre</th>
                                <th>Fecha de nacimiento</th>
                                <th>Sexo</th>
                            </thead>
                            <tbody id="mostrar-hijos"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="contenedor-grid">
        <div class="container">
            <h3 class="my-3">Lista de empleados</h3>
            <table class="table table-striped list">
                <thead>
                    <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <!--<th scope="col" class="d-none">Nro. Hijos</th>-->
                        <th scope="col">Teléfono</th>
                        <!--<th scope="col" class="d-none">Dirección</th>-->
                        <th scope="col">Cargo</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            <th scope="row">{!! $empleado->cedula !!}</th>
                            <td>{!! $empleado->nombre !!}</td>
                            <td>{!! $empleado->correo !!}</td>
                            <!--<td class="d-none">{!! $empleado->nro_hijos !!}</td>-->
                            <td>{!! $empleado->telefono !!}</td>
                            <!--<td class="d-none">{!! $empleado->direccion !!}</td>-->
                            <td>{!! $empleado->cargo !!}</td>
                            <td>{!! date('d/m/Y', strtotime($empleado->fecha_ingreso)) !!}</td>
                            <td>
                                <button class="btn btn-sm btn-info ver-empleado" id="{!! $empleado->id_empleado !!}"
                                    data-bs-toggle="modal" data-bs-target="#visualizar"><img src="/img/eye.png"
                                        width="20" alt="ver"></button>
                                @if (session('rol') == true)
                                    <a href="/editar-empleado/{{ $empleado->id_empleado }}"
                                        class="btn btn-sm btn-primary"><img src="/img/pencil.png" width="20"
                                            alt="editar"></a>
                                    <a href="/eliminar-empleado/{{ $empleado->id_empleado }}"
                                        class="btn btn-sm btn-danger eliminar-empleado"><img src="/img/trash.png"
                                            width="20" alt="eliminar"></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
