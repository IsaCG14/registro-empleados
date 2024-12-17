<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>PDF de empleados</title>
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
    @php
        $comprobar_estudiante = false;
        $comprobar_tipo = false;
        $comprobar_centro = false;
        $comprobar_area = false;
        $comprobar_codigo = false;
        $comprobar_serial = false;

        function isEstudiante($estudiante)
        {
            if ($estudiante == 1) {
                return 'Si';
            } else {
                return 'No';
            }
        }

        function tipoEmpleado($tipo)
        {
            switch ($tipo) {
                case 0:
                    return 'Contratado';
                    break;

                case 1:
                    return 'Trabajador fijo';
                    break;

                case 2:
                    return 'Pasante';
                    break;

                case 3:
                    return 'Jubilado';
                    break;

                default:
                    return '???';
                    break;
            }
        }

        function obtenerCentro($centro, $centros)
        {
            foreach ($centros as $c) {
                if ($c->id == $centro) {
                    return $c->nombre_centro;
                }
            }
        }

        function obtenerArea($area, $areas)
        {
            foreach ($areas as $a) {
                if ($a->id == $area) {
                    return $a->oficina;
                }
            }
        }

        function obtenerCodigo($id, $carnets, $cod)
        {
            foreach ($carnets as $c) {
                if ($c->id_empleado == $id && $cod == 1) {
                    return $c->codigo;
                } elseif ($c->id_empleado == $id && $cod == 2) {
                    return $c->serial;
                }
            }
        }
    @endphp
    <img src="img/headerpdf.png" width="100%">
    <div class="container">
        <div class="col m-4">
            <h5>Empleados {{ $title }}</h5>
            <table class="table">
                <thead>
                    <tr>
                        @foreach ($atributos as $atributo)
                            <th scope="col">{{ str_replace('_', ' ', ucwords($atributo)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            @foreach ($atributos as $atributo)
                                @php
                                    if ($atributo == 'estudiante') {
                                        $comprobar_estudiante = true;
                                    } else {
                                        $comprobar_estudiante = false;
                                    }

                                    if ($atributo == 'centro_electoral') {
                                        $comprobar_centro = true;
                                    } else {
                                        $comprobar_centro = false;
                                    }

                                    if ($atributo == 'area') {
                                        $comprobar_area = true;
                                    } else {
                                        $comprobar_area = false;
                                    }

                                    if ($atributo == 'codigo') {
                                        $comprobar_codigo = true;
                                        $cod = 1;
                                    } elseif ($atributo == 'serial') {
                                        $comprobar_codigo = true;
                                        $cod = 2;
                                    } else {
                                        $comprobar_codigo = false;
                                    }

                                    if ($atributo == 'tipo') {
                                        $comprobar_tipo = true;
                                    } else {
                                        $comprobar_tipo = false;
                                    }
                                @endphp
                                @if ($comprobar_estudiante == true)
                                    <td>{!! isEstudiante($empleado->$atributo) !!}</td>
                                @elseif ($comprobar_tipo == true)
                                    <td>{!! tipoEmpleado($empleado->$atributo) !!}</td>
                                @elseif ($comprobar_centro == true)
                                    <td>{!! obtenerCentro($empleado->id_centro, $centros) !!}</td>
                                @elseif ($comprobar_area == true)
                                    <td>{!! obtenerArea($empleado->area, $areas) !!}</td>
                                @elseif ($comprobar_codigo == true)
                                    <td>{!! obtenerCodigo($empleado->id_empleado, $carnets, $cod) !!}</td>
                                @elseif ($atributo == 'fecha_ingreso' || $atributo == 'fecha_nacimiento')
                                    <td>{!! date('d/m/Y', strtotime($empleado->$atributo)) !!}</td>
                                @else
                                    <td>{!! $empleado->$atributo !!}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
