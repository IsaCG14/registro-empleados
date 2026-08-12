@extends('layouts.nav')
@section('content')

<div class="contenedor">
    <h4>Generar reporte</h4>
    <div class="card-section mb-3">
        <form action="/pdf" target="_blank" class="row g-2 align-items-end reporteForm">
            <div class="col-auto">
                <label for="inicio" class="form-label small mb-0">Inicio</label>
                <input class="form-control form-control-sm" type="date" name="inicio" required>
            </div>
            <div class="col-auto">
                <label for="fin" class="form-label small mb-0">Fin</label>
                <input class="form-control form-control-sm" type="date" name="fin" required>
            </div>
            <div class="col-auto">
                <label for="filtro-sexo" class="form-label small mb-0">Sexo</label>
                <select class="form-select form-select-sm" name="sexo" id="filtro-sexo">
                    <option value="">Todos</option>
                    <option value="1">Masculino</option>
                    <option value="0">Femenino</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="filtro-estado" class="form-label small mb-0">Estado</label>
                <select class="form-select form-select-sm" name="estado" id="filtro-estado">
                    <option value="">Todos</option>
                    @foreach($estados as $estado)
                    <option value="{!!$estado->id_estado!!}">{!!$estado->estado!!}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label for="filtro-municipio" class="form-label small mb-0">Municipio</label>
                <select class="form-select form-select-sm" name="municipio" id="filtro-municipio">
                    <option value="">Todos</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="filtro-parroquia" class="form-label small mb-0">Parroquia</label>
                <select class="form-select form-select-sm" name="parroquia" id="filtro-parroquia">
                    <option value="">Todas</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="filtro-asunto" class="form-label small mb-0">Asunto</label>
                <select class="form-select form-select-sm" name="asunto" id="filtro-asunto">
                    <option value="">Todos</option>
                    @foreach($asuntos as $asunto)
                    <option value="{!!$asunto->id!!}">{!!$asunto->opciones!!}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label for="filtro-comunidad" class="form-label small mb-0">Comuna / Circuito Comunal</label>
                <select class="form-select form-select-sm" name="comunidad" id="filtro-comunidad">
                    <option value="">Todas</option>
                    <option value="comuna">Comuna</option>
                    <option value="circuito">Circuito Comunal</option>
                    <option value="sin_especificar">Sin especificar</option>
                </select>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2 mt-3">
                <button type="submit" name="scope" value="general" class="btn btn-primary btn-sm">Ver estadísticas
                    generales</button>
                <button type="submit" name="scope" value="mis_estadisticas"
                    class="btn btn-outline-primary btn-sm">Ver mis estadísticas</button>
                <button type="submit" name="scope" value="excel" class="btn btn-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                        <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z" />
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 1 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                    </svg> Descargar Excel</button>
            </div>
        </form>
    </div>
</div>
@endsection