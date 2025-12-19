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
                <!-- <a href="" id="cita-completa" class="btn btn-success">Marcar como resuelto</a> -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="contenedor">
    <h3 class="my-3">Control de citas</h3>
    <div class="row w-auto my-3">
        <div class="col-6 d-flex align-items-center">
            <label for="inicio" class="me-2 text-nowrap">Desde:</label>
            <input type="date" name="inicio_cita" id="inicio_cita" class="form-select"
                value="{{ $inicio ? $inicio : date('Y-m-d')  }}">
        </div>

        <div class="col-6 d-flex align-items-center">
            <label for="fin" class="me-2 text-nowrap">Hasta:</label>
            <input type="date" name="fin_cita" id="fin_cita" class="form-select"
                value="{{ $fin ? $fin : date('Y-m-d')  }}">
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Cédula</th>
                <th scope="col">Nombre</th>
                <th scope="col">Asunto</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Status</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla-citas">
            @foreach ($citas as $cita)
            <tr>
                <td>{{$cita->atendidos->personas->cedula}}</td>
                <td>{{$cita->atendidos->personas->nombre}}</td>
                <td>
                    <ul>
                        @foreach ($cita->atendidos->asuntos as $asunto)
                        <li>{{$asunto->patria->opciones}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{$cita->fecha_cita}}</td>
                <td>{{$cita->hora_cita}}</td>
                <td>
                    @if ($cita->status == 'Pendiente')
                    <span class="badge bg-secondary">{{$cita->status}}</span>
                    @elseif ($cita->status == 'Reagendada')
                    <span class="badge bg-warning text-dark">{{$cita->status}}</span>
                    @elseif ($cita->status == 'Atendida')
                    <span class="badge bg-success">{{$cita->status}}</span>
                    @elseif ($cita->status == 'Retrasada')
                    <span class="badge bg-danger">{{$cita->status}}</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-info ver-persona mb-1" id="{{ $cita->atendidos->id }}"
                        data-bs-toggle="modal" data-bs-target="#visualizar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye" viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg></button>
                    @if($cita->status != 'Atendida')
                    <a href="/agendar-cita/{{$cita->id_atencion}}" class="btn btn-warning btn-sm mb-1"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-clock-history" viewBox="0 0 16 16">
                            <path
                                d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                            <path
                                d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                        </svg> Reagendar</a>
                    <a href="/terminar-cita/{{$cita->id}}" class="btn btn-success btn-sm mb-1"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-clipboard-check" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                            <path
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                            <path
                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
                        </svg> Atendida</a>
                    <a href="/cancelar-cita/{{$cita->id}}" class="btn btn-danger btn-sm eliminar-cita mb-1"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-clipboard2-x" viewBox="0 0 16 16">
                            <path
                                d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z" />
                            <path
                                d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                            <path
                                d="M8 8.293 6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708z" />
                        </svg> Cancelar</a>
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