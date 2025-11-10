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
                    @foreach ($datos as $asunto)
                        <tr>
                            <th scope="row">{!! $asunto->personas->cedula !!}</th>
                            <td>{!! $asunto->personas->nombre !!}</td>
                            <td>{!! $asunto->personas->telefono !!}</td>
                            <td>{!! $asunto->patria->opciones !!}</td>
                            <td>{!! date('d/m/Y', strtotime($asunto->fecha_cita)) !!}</td>
                            <td>{!! $asunto->personas->parroquia->parroquia !!} ({!! $asunto->personas->parroquia->municipio->estado->estado !!})</td>
                            <td>{!! $asunto->usuarios->name !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
