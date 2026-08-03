@extends('layouts.nav')
@section('content')
    <div class="modal fade" id="visualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header modal-header-background" data-bs-theme="dark">
                    <h3 class="modal-title text-center w-100" id="exampleModalLabel">Información Completa</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="informacion-personal col-md-6"></div>
                    <div class="informacion-atendido col-md-6"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="contenedor">
        <div class="container-personas">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h4 class="my-0">Lista de asuntos</h4>
                <span class="text-muted small">{{ $atendidos->total() }} registro(s) encontrados</span>
            </div>

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <form method="GET" action="{{ route('index') }}" class="d-flex flex-grow-1" style="max-width: 400px;">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por cédula o nombre..."
                            value="{{ $busqueda ?? '' }}">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                        @if (!empty($busqueda))
                            <a href="{{ route('index') }}" class="btn btn-outline-secondary">Limpiar</a>
                        @endif
                    </div>
                </form>

                <div class="small text-muted d-flex flex-wrap gap-2 align-items-center">
                    <span class="fw-semibold">Acciones:</span>
                    <span class="badge bg-info text-dark"><i class="bi bi-eye"></i> Ver</span>
                    <span class="badge bg-primary"><i class="bi bi-pencil"></i> Editar</span>
                    <span class="badge bg-warning text-dark"><i class="bi bi-calendar4-week"></i> Agendar Cita</span>
                    @if (auth()->user()->rol)
                        <span class="badge bg-danger"><i class="bi bi-trash3"></i> Eliminar</span>
                    @endif
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark bg-secondary">
                        <tr>
                            <th scope="col">Cédula</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Asunto</th>
                            <th scope="col">Fecha de atención</th>
                            <th scope="col">Registrado por</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($atendidos as $atendido)
                            <tr>
                                <td class="fw-semibold">{{ $atendido->personas->cedula }}</td>
                                <td>{{ $atendido->personas->nombre }}</td>
                                <td>{{ $atendido->personas->telefono }}</td>
                                <td>
                                    @forelse ($atendido->asuntos as $asunto)
                                        <span class="badge bg-danger me-1 mb-1">{{ $asunto->patria->opciones }}</span>
                                    @empty
                                        <span class="text-muted small">N/A</span>
                                    @endforelse
                                </td>
                                <td>{{ date('d/m/Y', strtotime($atendido->fecha_atencion)) }}</td>
                                <td>{{ $atendido->usuarios->name }}</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="btn btn-sm btn-info ver-persona" id="{{ $atendido->id }}"
                                            data-bs-toggle="modal" data-bs-target="#visualizar" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="/editar-persona/{{ $atendido->id }}" class="btn btn-sm btn-primary"
                                            title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="/agendar-cita/{{ $atendido->id }}" class="btn btn-sm btn-warning"
                                            title="Agendar cita">
                                            <i class="bi bi-calendar4-week"></i>
                                        </a>
                                        @if (auth()->user()->rol)
                                            <a href="/eliminar-persona/{{ $atendido->id }}"
                                                class="btn btn-sm btn-danger eliminar-persona" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No se encontraron registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $atendidos->links() }}
            </div>
        </div>
    </div>
@endsection