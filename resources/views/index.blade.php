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
                <div class="informacion-atendido col"></div>
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
                    <th scope="col">Fecha de atención</th>
                    <th scope="col">Registrado por</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atendidos as $atendido)
                <tr>
                    <th scope="row">{!! $atendido->personas->cedula !!}</th>
                    <td>{!! $atendido->personas->nombre !!}</td>
                    <td>{!! $atendido->personas->telefono !!}</td>
                    <td>
                        @forelse ($atendido->asuntos as $asunto)
                        <span class="badge bg-danger">{{ $asunto->patria->opciones }}</span>
                        @if (!$loop->last)
                        ,
                        @endif
                        @empty
                        <span>N/A</span>
                        @endforelse
                    </td>
                    <td>{!! date('d/m/Y', strtotime($atendido->fecha_atencion)) !!}</td>
                    <td>{!! $atendido->usuarios->name !!}</td>
                    <td>
                        <button class="btn btn-sm btn-info ver-persona" id="{{ $atendido->id }}" data-bs-toggle="modal"
                            data-bs-target="#visualizar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-eye" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                            </svg></button>
                        <a href="/editar-persona/{{ $atendido->id }}" class="btn btn-sm btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                            </svg>
                        </a>
                        <a href="/agendar-cita/{{ $atendido->id }}" class="btn btn-sm btn-warning"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z" />
                                <path
                                    d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                            </svg></a>
                        @if (auth()->user()->rol)
                        <a href="/eliminar-persona/{{ $atendido->id }}" class="btn btn-sm btn-danger eliminar-persona">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash3" viewBox="0 0 16 16">
                                <path
                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $atendidos->links() }}
        </div>
    </div>
</div>
@endsection