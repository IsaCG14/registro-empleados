<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte de Atención</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.4;
            margin: 20px;
        }

        h2 {
            color: #3f3f3fff;
            border-bottom: 2px solid #00889f;
            padding-bottom: 5px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        /* Tabla */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th {
            background-color: #00889f;
            color: white;
            padding: 10px;
            font-size: 10px;
            text-transform: uppercase;
        }

        .table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
            text-align: center;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Contenedor de Estadísticas */
        .stats-wrapper {
            display: table;
            width: 100%;
            margin-top: 25px;
        }

        .stat-card {
            display: table-cell;
            width: 33%;
            padding: 10px;
        }

        .card-inner {
            background: #f4f4f4;
            border-left: 4px solid #00889f;
            padding: 10px;
            border-radius: 4px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #00889f;
        }

        .chart-container {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <img src="{{ public_path('img/headerpdf.png') }}" width="100%">

    <h2>{{ $title }}</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Asunto</th>
                <th>Fecha</th>
                <th>Proveniencia</th>
                <th>Atendido por</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos as $cita)
            <tr>
                <td>{!! $cita->personas->cedula !!}</td>
                <td>{!! $cita->personas->nombre !!}</td>
                <td>{!! $cita->personas->telefono !!}</td>
                <td>
                    @forelse ($cita->asuntos as $asunto)
                    {{ $asunto->patria->opciones }}{{ !$loop->last ? ', ' : '' }}
                    @empty N/A @endforelse
                </td>
                <td>{!! date('d/m/Y', strtotime($cita->fecha_atencion)) !!}</td>
                <td>{!! $cita->personas->parroquia->parroquia !!} ({!! $cita->personas->parroquia->municipio->estado->estado !!})</td>
                <td>{!! $cita->usuarios->name !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Estadísticas Generales</h3>
    <div class="stats-wrapper">
        <div class="stat-card">
            <div class="card-inner">Total<br><span class="stat-value">{{ $total }}</span></div>
        </div>
        <div class="stat-card">
            <div class="card-inner">Masculinos<br><span class="stat-value">{{ $masculino }}</span></div>
        </div>
        <div class="stat-card">
            <div class="card-inner">Femeninos<br><span class="stat-value">{{ $femenino }}</span></div>
        </div>
    </div>

    <h3>Resumen de Proveniencia</h3>
    <table class="table" style="width: 80%; margin: 0 auto;">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Proporción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Comunas</td>
                <td>{{ $comunas }}</td>
                <td>
                    <div style="background: #eee; width: 300px; height: 10px; border-radius: 5px;">
                        <div style="background: #00889f; width: {{ $total > 0 ? ($comunas/$total)*100 : 0 }}%; height: 100%; border-radius: 5px;"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Circuitos Comunales</td>
                <td>{{ $circuitos }}</td>
                <td>
                    <div style="background: #eee; width: 300px; height: 10px; border-radius: 5px;">
                        <div style="background: #ff9f40; width: {{ $total > 0 ? ($circuitos/$total)*100 : 0 }}%; height: 100%; border-radius: 5px;"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Sin Conocimiento</td>
                <td>{{ $sin_especificar }}</td>
                <td>
                    <div style="background: #eee; width: 300px; height: 10px; border-radius: 5px;">
                        <div style="background: #ff6384; width: {{ $total > 0 ? ($sin_especificar/$total)*100 : 0 }}%; height: 100%; border-radius: 5px;"></div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <footer>
        <img src="{{ public_path('img/footerpdf.png') }}" width="100%">
    </footer>
</body>

</html>