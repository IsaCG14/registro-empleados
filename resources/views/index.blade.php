@extends('layouts.nav')
@section('content')
    <div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-header-background" data-bs-theme="dark">
                    <h3 class="modal-title text-center w-100" id="exampleModalLabel">Información Completa</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="informacion-personal col"></div>
                    <div class="informacion-cita col"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="contenedor">
        <div class="container-personas">
            <h3 class="my-3">Lista de personas</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Asunto</th>
                        <th scope="col">Fecha de cita</th>
                        <th scope="col">Registrado por</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas as $asunto)
                        <tr>
                            <th scope="row">{!! $asunto->personas->cedula !!}</th>
                            <td>{!! $asunto->personas->nombre !!}</td>
                            <td>{!! $asunto->personas->telefono !!}</td>
                            <td>{!! $asunto->patria->opciones !!}</td>
                            <td>{!! date('d/m/Y', strtotime($asunto->fecha_cita)) !!}</td>
                            <td>{!! $asunto->usuarios->name !!}</td>
                            <td>
                                <button class="btn btn-sm btn-info ver-persona" id="{{ $asunto->id }}"
                                    data-bs-toggle="modal" data-bs-target="#visualizar"><img src="/img/eye.png"
                                        width="20" alt="ver"></button>
                                    <a href="/editar-persona/{{ $asunto->id }}"
                                        class="btn btn-sm btn-primary"><img src="/img/pencil.png" width="20"
                                            alt="editar"></a>
                                    <a href="/eliminar-persona/{{ $asunto->id }}"
                                        class="btn btn-sm btn-danger eliminar-persona"><img src="/img/trash.png"
                                            width="20" alt="eliminar"></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
