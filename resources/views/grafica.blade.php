@extends('layouts.nav')
@section('content')
    <div class="contenedor">
        <div>
            <h3>Estadísticas</h3>
            <!--<a href="/pdf" target="_blank" class="btn btn-primary my-4">Generar PDF</a>-->
            <button id="generarPdfGeneral" class="btn btn-primary my-4 w-25">Generar PDF</button>
                <!-- <div class="dropdown col">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Estilo de gráfica
                    </button>
                    <ul class="dropdown-menu col">
                        <li><a class="dropdown-item" href="/grafica?tipo=pie">Gráfica de Pastel</a></li>
                        <li><a class="dropdown-item" href="/grafica?tipo=doughnut">Gráfica de Rosca</a></li>
                        <li><a class="dropdown-item" href="/grafica?tipo=bar">Gráfica de Barras</a></li>
                    </ul>
                </div> -->
            <div class="row w-50 my-3">
                <label for="dia" class="col">Seleccionar día:</label>
                    <input type="date" name="dia" id="dia" class="form-control col" value="{{ $dia ? $dia : date('Y-m-d')  }}">
            </div>
            <div class="row m-2" id="grafic-container">
                <div class="col-lg-5 m-4">
                    <h5>Gráfica por sexo</h5>
                    <canvas id="grafica-sexo"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-5 m-4">
                    <h5>Gráfica por rango de edades</h5>
                    <canvas id="grafica-edad"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-5 m-4">
                    <h5>Gráfica por asuntos atendidos</h5>
                    <select name="usuario" id="user">
                        <option value="0">General</option>
                    </select>
                    <canvas id="grafica-asunto"></canvas>
                    <button class="btn btn-dark generarPdf">Descargar PDF</button>
                </div>
                <div class="col-lg-5 m-4">
                    <h5>Gráfica por sexos registrados por usuario</h5>
                    <canvas id="grafica-sexo-usuario"></canvas>
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
        const citas = @json($citas);
        console.log(citas)

        //Obtener tipo de grafica
        const url = new URLSearchParams(window.location.search)

        var tipo = (url.get("tipo") == null) ? 'pie' : url.get("tipo");

        //Llenar select de usuarios
        var usuarios = {};
        citas.forEach(cita => {
            var usuario = cita.usuarios;
            if (!(usuario.name in usuarios)) {
                usuarios[usuario.name] = true;
                $("#user").append(`<option value="${usuario.id}">${usuario.name}</option>`);
            }
        });
        //Obtener id del option seleccionado
        $("#user").on("change", function() {
            var userId = $(this).val();
            //Mostrar solo asuntos registrados por ese usuario
            var asuntoCounts = {};
            citas.forEach(cita => {
                if (cita.usuarios.id == userId) {
                    var asunto = cita.patria.opciones;
                    if (asunto in asuntoCounts) {
                        asuntoCounts[asunto]++;
                    } else {
                        asuntoCounts[asunto] = 1;
                    }
                } else if (userId == 0) {
                    var asunto = cita.patria.opciones;
                    if (asunto in asuntoCounts) {
                        asuntoCounts[asunto]++;
                    } else {
                        asuntoCounts[asunto] = 1;
                    }
                }
            });
            //Destruir grafica anterior
            Chart.getChart("grafica-asunto")?.destroy();
            //Actualizar grafica
            const grafica_asunto = document.getElementById('grafica-asunto');
            new Chart(grafica_asunto, {
                type: tipo,
                data: {
                    labels: Object.keys(asuntoCounts).map(asunto => asunto + " (" + asuntoCounts[asunto] + ")"),
                    datasets: [{
                        label: 'Asuntos atendidos',
                        data: Object.values(asuntoCounts),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                },
                plugins: [plugin],
            })
        })

        //Grafica por sexo
        var num_f = 0
        var num_m = 0

        //Grafica por edades
        var rango1 = 0
        var rango2 = 0
        var rango3 = 0
        var rango4 = 0
        var rango5 = 0

        //Grafica por asuntos
        var asuntoCounts = {};

        citas.forEach(cita => {
            //valorar genero
            // console.log(cita.personas.sexo)
            if (cita.personas.sexo == 1) {
                num_m++
            } else {
                num_f++
            } 

            //valorar edades

            //Calcular edad
            var fecha_actual = new Date();
            var fecha_nac = new Date(cita.personas.fecha_nacimiento);
            var edad = fecha_actual - fecha_nac;
            var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
            edad = Math.floor(anios)

            //console.log(edad)

            if (edad >= 18 && edad <= 24) {
                rango1++
            } else if (edad >= 25 && edad <= 30) {
                rango2++
            } else if (edad >= 31 && edad <= 45) {
                rango3++
            } else if (edad >= 46 && edad <= 55) {
                rango4++
            } else if (edad >= 56) {
                rango5++
            }
            //valorar asuntos
            var asunto = cita.patria.opciones;
            if (asunto in asuntoCounts) {
                asuntoCounts[asunto]++;
            } else {
                asuntoCounts[asunto] = 1;
            }
        })

        const plugin = {
            id: 'customCanvasBackgroundColor',
            beforeDraw: (chart, args, options) => {
                const {
                    ctx
                } = chart;
                ctx.save();
                ctx.globalCompositeOperation = 'destination-over';
                ctx.fillStyle = options.color || '#ffffff';
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        };

        const grafica_sexo = document.getElementById('grafica-sexo');
        new Chart(grafica_sexo, {
            type: tipo,
            data: {
                labels: ['Masculino: ' + String(num_m), 'Femenino: ' + String(num_f)],
                datasets: [{
                    label: '# personas',
                    data: [num_m, num_f],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)'
                    ],
                    borderWidth: 1
                }]
            },
            plugins: [plugin],
        });

        const grafica_edad = document.getElementById('grafica-edad');

        //Grafica por edades 
        new Chart(grafica_edad, {
            type: tipo,
            data: {
                labels: ["18 a 24 (" + rango1 + ")", "25 a 30 (" + rango2 + ")", "31 a 45 (" + rango3 + ")",
                    "46 a 55 (" + rango4 + ")", "56+ (" + rango5 + ")"
                ],
                datasets: [{
                    label: 'Personas entre rango de edad',
                    data: [rango1, rango2, rango3, rango4, rango5],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)'
                    ],
                    borderWidth: 1
                }]
            },
            plugins: [plugin],
        })

        const grafica_asunto = document.getElementById('grafica-asunto');
        //Grafica por asuntos
        new Chart(grafica_asunto, {
            type: tipo,
            data: {
                labels: Object.keys(asuntoCounts).map(asunto => asunto + " (" + asuntoCounts[asunto] + ")"),
                datasets: [{
                    label: 'Asuntos atendidos',
                    data: Object.values(asuntoCounts),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },
            plugins: [plugin],
        })

        const grafica_sexo_usuario = document.getElementById('grafica-sexo-usuario');
        //Grafica por sexo registrado por usuario dividido por femenino y masculino en doble barra
        var usuarioLabels = {};
        citas.forEach(cita => {
            var usuario = cita.usuarios.name;
            if (!(usuario in usuarioLabels)) {
                usuarioLabels[usuario] = { male: 0, female: 0 };
            }
            if (cita.personas.sexo == 1) {
                usuarioLabels[usuario].male++;
            } else {
                usuarioLabels[usuario].female++;
            }
        });
        new Chart(grafica_sexo_usuario, {
            type: 'bar',
            data: {
                labels: Object.keys(usuarioLabels),
                datasets: [
                    {
                        label: 'Masculino',
                        data: Object.values(usuarioLabels).map(data => data.male),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    },
                    {
                        label: 'Femenino',
                        data: Object.values(usuarioLabels).map(data => data.female),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1
                    }
                ]
            },
            plugins: [plugin],
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });    
        
        //Descargar pdf
        $(".generarPdf").on("click", function() {
            //Obtener canvas
            var canvas = $(this).parent().find("canvas").attr("id")
            const grafica = document.getElementById(canvas)
            //crear imagen
            const pdfImage = grafica.toDataURL('image/jpeg', 1.0)
            //imagen a pdf
            let pdf = new jsPDF('landscape')
            //Añadir titulo y descripcion 
            pdf.setFontSize(20)
            var title = $(this).parent().find("h5").text()

            pdf.text(title, 10, 10)

            // Escalar la imagen al 400%
            const imgWidth = grafica.width * 4; // 400% del ancho
            const imgHeight = grafica.height * 4; // 400% de la altura

            pdf.addImage(pdfImage, 'JPEG', 15, 15, 270, 150)

            pdf.setProperties({
                title: "Report"
            });

            pdf.output('dataurlnewwindow');
        })

        //Descargar pdf
        $("#generarPdfGeneral").on("click", function() {
            let heightText = 10
            let heightGrafica = 15
            let pdf = new jsPDF('p', 'mm', [1200, 300])

            $("canvas").each(function(index) {
                var canvas = $(this).attr("id")
                var grafica = document.getElementById(canvas)
                var pdfImage = grafica.toDataURL("image/jpeg", 1.0)

                pdf.setFontSize(20)
                var title = $(this).parent().find("h5").text()
                title+= " - Registrados el "+@json($dia)

                pdf.text(title, 10, heightText)

                pdf.addImage(pdfImage, 'JPEG', 15, heightGrafica, 270, 150)

                heightText += 200
                heightGrafica += 200
            })
            pdf.output('dataurlnewwindow');
        })
    </script>
@endsection
