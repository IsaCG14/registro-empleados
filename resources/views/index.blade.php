@extends('layouts.nav')
@section('content')
<div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
        <div class="row mb-4 w-75">
            <form action="/pdf" target="_blank" class="row g-3 align-items-center reporteForm">
                <div class="col-auto">
                    <label for="inicio">Inicio:</label>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="date" name="inicio" required>
                </div>
                <div class="col-auto">
                    <label for="fin">Fin:</label>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="date" name="fin" required>
                </div>
                <input type="submit" class="btn btn-primary mt-3 col" value="Generar PDF general">
            </form>
        </div>
        <div class="row my-3 w-50">
            <form method="GET" action="{{ route('index') }}" class="d-flex my-3">
                <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar por cédula o nombre..."
                    value="{{ $busqueda ?? '' }}">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
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
                @foreach ($citas as $cita)
                <tr>
                    <th scope="row">{!! $cita->personas->cedula !!}</th>
                    <td>{!! $cita->personas->nombre !!}</td>
                    <td>{!! $cita->personas->telefono !!}</td>
                    <td>
                        @forelse ($cita->asuntos as $asunto)
                        <span class="badge bg-danger">{{ $asunto->patria->opciones }}</span>
                        @if (!$loop->last)
                        ,
                        @endif
                        @empty
                        <span>N/A</span>
                        @endforelse
                    </td>
                    <td>{!! date('d/m/Y', strtotime($cita->fecha_cita)) !!}</td>
                    <td>{!! $cita->usuarios->name !!}</td>
                    <td>
                        <button class="btn btn-sm btn-info ver-persona" id="{{ $cita->id }}" data-bs-toggle="modal"
                            data-bs-target="#visualizar"><img src="/img/eye.png" width="20" alt="ver"></button>
                        <a href="/editar-persona/{{ $cita->id }}" class="btn btn-sm btn-primary"><img
                                src="/img/pencil.png" width="20" alt="editar"></a>
                        @if (auth()->user()->rol)
                        <a href="/eliminar-persona/{{ $cita->id }}" class="btn btn-sm btn-danger eliminar-persona"><img
                                src="/img/trash.png" width="20" alt="eliminar"></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $citas->links() }}
        </div>
    </div>
</div>
@endsection