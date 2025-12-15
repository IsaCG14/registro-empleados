@extends('layouts.nav')
@section('content')
<div class="contenedor">
    <h3 class="my-3">Control de citas</h3>
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
                    @elseif ($cita->status == 'Cancelada')
                    <span class="badge bg-danger">{{$cita->status}}</span>
                    @endif
                </td>
                <td>
                    <a href="/agendar-cita/{{$cita->id_atencion}}" class="btn btn-warning btn-sm">Reagendar</a>
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