@extends('layouts.nav')
@section('content')
    <div class="contenedor">
        <div>
            <h3>Estadísticas</h3>
            <div class="row w-50 my-4">
                <button type="button" id="generarPdfGeneral" class="col w-25 btn btn-primary">Generar PDF</button>
                <div class="dropdown col">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Ver
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/grafica?ver=general">General</a></li>
                        <li><a class="dropdown-item" href="/grafica?ver=mis-estadisticas">Mis estadísticas</a></li>
                    </ul>
                </div>
            </div>
            <div class="row w-auto my-3">
                <div class="col-6 d-flex align-items-center">
                    <label for="inicio" class="me-2 text-nowrap">Desde:</label>
                    <input type="date" name="inicio" id="inicio" class="form-select"
                        value="{{ $inicio ? $inicio : date('Y-m-d')  }}">
                </div>

                <div class="col-6 d-flex align-items-center">
                    <label for="fin" class="me-2 text-nowrap">Hasta:</label>
                    <input type="date" name="fin" id="fin" class="form-select" value="{{ $fin ? $fin : date('Y-m-d')  }}">
                </div>
            </div>
            <div class="row m-2" id="grafic-container">
                <div class="col-lg-12 m-4">
                    <h5>Gráfica por sexo</h5>
                    <canvas id="grafica-sexo"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-12 m-4">
                    <h5>Gráfica por rango de edades</h5>
                    <canvas id="grafica-edad"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <!-- <div class="col-lg-5 m-4">
                            <h5>Gráfica por sexos registrados por usuario</h5>
                            <canvas id="grafica-sexo-usuario"></canvas>
                            <button class="btn btn-dark generarPdf">Descargar PDF</button>
                        </div> -->
                <div class="col-lg-12 m-4">
                    <h5>Gráfica de asuntos atendidos por estado</h5>
                    <canvas id="grafica-estado"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-12 m-4">
                    <h5>Gráfica de asuntos atendidos por municipio</h5>
                    <select name="estado" class="form-select" id="estado-municipio">
                        @foreach($estados as $estado)
                            <option value="{!!$estado->id_estado!!}">{!!$estado->estado!!}</option>
                        @endforeach
                    </select>
                    <canvas id="grafica-municipio"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-12 m-4">
                    <h5>Gráfica de asuntos atendidos por parroquia</h5>
                    <select name="estado" class="form-select my-2" id="estado">
                        @foreach($estados as $estado)
                            <option value="{!!$estado->id_estado!!}">{!!$estado->estado!!}</option>
                        @endforeach
                    </select>
                    <select name="municipio" class="form-select" id="municipio">
                        <option value="0">Municipio</option>
                    </select>
                    <canvas id="grafica-parroquia"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-12 m-4">
                    <h5>Gráfica de asuntos atendidos</h5>
                    <!-- <select name="usuario" class="form-select" id="user">
                                <option value="0">General</option>
                            </select> -->
                    <canvas id="grafica-asunto"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-12 m-4">
                    <h5>Gráfica de status de citas</h5>
                    <canvas id="grafica-cita"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-12 m-4">
                    <h5>Gráfica de Comunas y Circuitos Comunales</h5>
                    <canvas id="grafica-comuna"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('librerias/jquery-3.7.1.min.js.js') }}"></script>
    <script src="{{ asset('librerias/chart.js.js') }}"></script>
    <script src="{{ asset('librerias/pdf.min.js.js') }}"></script>
    <script src="{{ asset('librerias/jspdf.min.js.js') }}"></script>
    <script src="{{ asset('librerias/jspdf.plugin.autotable.js.js') }}"></script>
    <script src="{{ asset('librerias/html2canvas.min.js') }}"></script>
    <script>
        const atendidos = @json($atendidos);
        const citas = @json($citas);
        let fecha_inicio = @json($inicio);
        let fecha_fin = @json($fin);
        let circuitos = @json($circuitos);
        let comunas = @json($comunas);
        let sin_conocimiento = @json($sin_especificar);
        let id_usuario = @json($id_usuario);

        //Formatear fechas
        function formatDate(date) {
            const partes = date.split('-');

            const anio = parseInt(partes[0]);
            const mes = parseInt(partes[1]) - 1; // 11 - 1 = 10 (Noviembre)
            const dia = parseInt(partes[2]);
            return `${dia}/${mes}/${anio}`;
        }

        dia_inicio = formatDate(fecha_inicio)
        dia_fin = formatDate(fecha_fin)
    </script>
    <script src="{{ asset('js/graficas.js') }}"></script>
@endsection