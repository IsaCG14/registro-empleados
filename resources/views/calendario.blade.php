@extends('layouts.nav')
@section('content')
<div class="row">
    <div class="wrapper m-3 col">
        <header>
            <p class="current-date"></p>
            <div class="icons">
                <span id="prev" class="material-symbols-rounded">
                    <</span>
                <span id="next" class="material-symbols-rounded">></span>
            </div>
        </header>
        <div class="calendar">
            <ul class="weeks">
                <li>Dom</li>
                <li>Lun</li>
                <li>Mar</li>
                <li>Mie</li>
                <li>Jue</li>
                <li>Vie</li>
                <li>Sab</li>
            </ul>
            <ul class="days"></ul>
        </div>
    </div>
    <div class="col contenedor m-3">
        <h4>Agendar cita</h4>
        <div class="guide row mt-4">
            <div class="guide-1 col">
                <span class="symbol-rounded-celeste"></span>
                <p>Día actual</p>
            </div>
            <div class="guide-2 col">
                <span class="symbol-rounded-azul"></span>
                <p>Seleccionado</p>
            </div>
            <div class="guide-4 col">
                <span class="symbol-rounded-rojo"></span>
                <p>No disponibles</p>
            </div>
        </div>
        <div class="mt-4">
            <form action="/guardar-cita" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col">
                        <p><b>Cédula: </b>{{$asunto->personas->cedula}}</p>
                        <p><b>Nombre: </b>{{$asunto->personas->nombre}}</p>
                        <!-- <p id="fecha-seleccionada"></p> -->
                        <label for="fecha"><b>Fecha seleccionada:</b><input id="fecha-seleccionada" name="fecha_cita" type="date" readonly class="form-control mb-3" required></label>
                        <br><label for="hora"><b>Hora:</b><input id="hora-seleccionada" type="time" class="form-control" name="hora_cita" required></label>
                        <br><span class="error-hora"></span>
                    </div>
                    <div class="col">
                        <p><b>Teléfono: </b>{{$asunto->personas->telefono}}</p>
                        <p><b>Correo: </b>{{$asunto->personas->correo}}</p>
                        <p><b>Asuntos: </b>
                        <ul>
                            @foreach ($asunto->asuntos as $a)
                            <li>{{$a->patria->opciones}}</li>
                            @endforeach
                        </ul>
                        </p>
                    </div>
                    <input type="hidden" name="id_atencion" value="{{$asunto->id}}">
                </div>
                <input type="submit" class="btn btn-primary mt-3 col" value="Guardar cita">
            </form>
        </div>
    </div>
</div>
<div class="contenedor">
    <h3 class="my-3">Citas: <span id="titulo-cita"></span></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Cédula</th>
                <th scope="col">Nombre</th>
                <th scope="col">Asunto</th>
                <th scope="col">Hora</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody id="tabla-citas">
        <!--Llenar con Javascript-->
        </tbody>
    </table>
</div>
</div>
<script>
    const citasRegistradas = @json($citas);
    const asunto = @json($asunto);
</script>
<script src="{{ asset('js/calendario.js') }}"></script>
@endsection