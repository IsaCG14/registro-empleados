<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>PDF de personas</title>
    <style>
    * {
        font-family: sans-serif;
    }

    .table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-size: 10px;
        border-spacing: 0;
        width: 100%;
    }

    .table td,
    .table th {
        padding: 8px;
        text-align: center;
    }

    .table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table th {
        background-color: #00889f;
        color: white;
    }
    </style>
</head>

<body>
    <img src="img/headerpdf.png" width="100%">
    <div class="container">
        <div class="col m-4">
            <h5>{{ $title }}</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Asunto</th>
                        <th scope="col">Fecha de cita</th>
                        <th scope="col">Proveniencia</th>
                        <th scope="col">Registrado por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $cita)
                    <tr>
                        <th scope="row">{!! $cita->personas->cedula !!}</th>
                        <td>{!! $cita->personas->nombre !!}</td>
                        <td>{!! $cita->personas->telefono !!}</td>
                        <td>
                            @forelse ($cita->asuntos as $asunto)
                            <span>{{ $asunto->patria->opciones }}</span>
                            @if (!$loop->last)
                            ,
                            @endif
                            @empty
                            <span>N/A</span>
                            @endforelse
                        </td>
                        <td>{!! date('d/m/Y', strtotime($cita->fecha_cita)) !!}</td>
                        <td>{!! $cita->personas->parroquia->parroquia !!} ({!!
                            $cita->personas->parroquia->municipio->estado->estado !!})</td>
                        <td>{!! $cita->usuarios->name !!}</td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            <br>
            <h5>Estadísticas</h5>
            <p>Total de citas: {{ $total }}</p>
            <p>Total de citas masculinas: {{ $masculino }}</p>
            <p>Total de citas femeninas: {{ $femenino }}</p>
        </div>
    </div>
</body>

</html>