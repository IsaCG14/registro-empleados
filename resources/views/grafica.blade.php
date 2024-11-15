@extends('layouts.nav')
@section('content')
<div class="contenedor-grid">
    <div class="container">
        <h3>Estadísticas</h3>
        <!--<a href="/pdf" target="_blank" class="btn btn-primary my-4">Generar PDF</a>-->
        <button id="generarPdfGeneral" class="btn btn-primary my-4">Generar PDF</button>
        <!--<div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ver gráfica de 
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/grafica?tipo=1">Géneros</a></li>
              <li><a class="dropdown-item" href="/grafica?tipo=2">Centros de votación</a></li>
              <li><a class="dropdown-item" href="/grafica?tipo=3">Años de servicio</a></li>
            </ul>
          </div>-->
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
              <h5>Gráfica por centro de votación</h5>
              <canvas id="grafica-centro"></canvas>
              <button class="btn btn-dark generarPdf">Descargar PDF</button>
            </div>
            <div class="col-lg-5 m-4">
              <h5>Gráfica por tipo de empleado</h5>
              <canvas id="grafica-tipo"></canvas>
              <button class="btn btn-dark generarPdf">Descargar PDF</button>
            </div>
            <div class="col-lg-5 m-4">
              <h5>Gráfica por años de servicio</h5>
              <canvas id="grafica-servicio"></canvas>
              <button class="btn btn-dark generarPdf">Descargar PDF</button>
            </div>
            <div class="col-lg-5 m-4">
              <h5>Gráfica de estudiantes</h5>
              <canvas id="grafica-estudiante"></canvas>
              <button class="btn btn-dark generarPdf">Descargar PDF</button>
            </div>
          </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js" integrity="sha512-t2JWqzirxOmR9MZKu+BMz0TNHe55G5BZ/tfTmXMlxpUY8tsTo3QMD27QGoYKZKFAraIPDhFv56HLdN11ctmiTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
  <script src="https://unpkg.com/jspdf-autotable@3.8.4/dist/jspdf.plugin.autotable.js"></script>
  <script>
    const empls = @json($empleados);
    
    //Obtener tipo de grafica
    /*const url = new URLSearchParams(window.location.search)
    var tipo = url.get("tipo")*/

    //Grafica por sexo
    var num_f = 0
    var num_m = 0
    var num_o = 0
    var num_estudiante = 0
    var no_estudiante = 0
    var num_contratado = 0
    var num_fijo = 0
    var num_pasante = 0
    var rango1 = 0 
    var rango2 = 0
    var rango3 = 0 
    var rango4 = 0 
    var rango5 = 0
    var anio1 = 0 
    var anio2 = 0
    var anio3 = 0 
    var anio4 = 0 
    var anio5 = 0

    $.each(empls, function(key, value){
      //valorar genero
        if(value.sexo == "Masculino"){
            num_m++
        } else if (value.sexo == "Femenino"){
            num_f++
        } else if (value.sexo == "Otro"){
            num_o++
        }

        //valorar tipo
        if(value.tipo == 1){
            num_fijo++
        } else if (value.tipo == 0){
            num_contratado++
        } else if (value.tipo == 2){
            num_pasante++
        }

        if (value.estudiante == 1){
            num_estudiante++
        } else {
          no_estudiante++
        }

        //valorar edades

        //Calcular edad
        var fecha_actual = new Date();
        var fecha_nac = new Date(value.fecha_nacimiento);
        var edad = fecha_actual - fecha_nac;
        var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
        edad = Math.floor(anios)

        //console.log(edad)

        if(edad >= 18 && edad <= 24){
          rango1++
        } else if(edad >= 25 && edad <= 30){
          rango2++
        } else if(edad >= 31 && edad <= 45){
          rango3++
        } else if(edad >= 46 && edad <= 55){
          rango4++
        } else if(edad >= 56){
          rango5++
        }

        //Calcular años de servicio
        var fecha_in = new Date(value.fecha_ingreso);
        var tiempo = fecha_actual - fecha_in;
        var anios_servicio = tiempo / (1000 * 60 * 60 * 24 * 365.25);
        var anios = Math.floor(anios_servicio)

        if(anios <= 5){
          anio1++
        } else if (anios >= 6 && anios <= 10){
          anio2++
        } else if (anios >= 11 && anios <= 15){
          anio3++
        } else if (anios >= 16 && anios <= 20){
          anio4++
        } else {
          anio5++
        }
    })

    const plugin = {
  id: 'customCanvasBackgroundColor',
  beforeDraw: (chart, args, options) => {
    const {ctx} = chart;
    ctx.save();
    ctx.globalCompositeOperation = 'destination-over';
    ctx.fillStyle = options.color || '#ffffff';
    ctx.fillRect(0, 0, chart.width, chart.height);
    ctx.restore();
  }
};

    const grafica_sexo = document.getElementById('grafica-sexo');
    new Chart(grafica_sexo, {
      type: 'doughnut',
      data: {
        labels: ['Masculino: '+String(num_m), 'Femenino: '+String(num_f), 'Otro: '+String(num_o)],
        datasets: [{
          label: '# empleados',
          data: [num_m, num_f, num_o],
          backgroundColor: [
            '#0dcaf0',
            '#d63384',
            'rgb(255, 205, 86)'
          ],
        }]
      },
      plugins: [plugin],
    });

    const grafica_edad = document.getElementById('grafica-edad');

    //Grafica por edades 
    new Chart(grafica_edad, {
      type: 'bar',
      data: {
      labels: ["18 a 24 ("+rango1+")", "25 a 30 ("+rango2+")", "31 a 45 ("+rango3+")", "46 a 55 ("+rango4+")", "56+ ("+rango5+")"],
      datasets: [{
        label: 'Empleados entre rango de edad',
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

    //Grafica por centro de votación
    const grafica_centro = document.getElementById('grafica-centro');
    const centros = @json($centros);
    var centros_label = []
    var centros_total = []

    $.each(centros, function(key, value){
        centros_label.push(value.nombre_centro+": "+String(value.total))
        centros_total.push(value.total)
    })
  
    new Chart(grafica_centro, {
      type: 'pie',
      data: {
        labels: centros_label,
        datasets: [{
          label: '# empleados',
          data: centros_total
        }]
      },
      plugins: [plugin],
    });

    //Grafica por tipo de empleado
    const grafica_tipo = document.getElementById('grafica-tipo');
  
    new Chart(grafica_tipo, {
      type: 'doughnut',
      data: {
        labels: ['Trabajador fijo: '+String(num_fijo), 'Contratado: '+String(num_contratado), 'Pasante: '+String(num_pasante)],
        datasets: [{
          label: '# empleados',
          backgroundColor: [
            '#0d6efd',
            '#6f42c1',
            '#20c997'
          ],
          data: [num_fijo, num_contratado, num_pasante],
        }]
      },
      plugins: [plugin],
    });
    
    //Grafica por años de servicio
    const grafica_servicio = document.getElementById('grafica-servicio');
    new Chart(grafica_servicio, {
      type: 'bar',
      data: {
      labels: ["0 - 5 ("+anio1+")", "6 - 10 ("+anio2+")", "11 - 15 ("+anio3+")", "16 - 20 ("+anio4+")", "21+ ("+anio5+")"],
      datasets: [{
        label: 'Empleados entre rango de años de servicio',
        data: [anio1, anio2, anio3, anio4, anio5],
        borderWidth: 1
      }]
    },
    plugins: [plugin],
    })

    //Grafica para estudiantes
    const grafica_estudiante = document.getElementById('grafica-estudiante');
  
    new Chart(grafica_estudiante, {
      type: 'pie',
      data: {
        labels: ['Estudiante: '+String(num_estudiante), 'No estudiante: '+String(no_estudiante)],
        datasets: [{
          label: '# empleados',
          backgroundColor: [
            '#0d6efd',
            '#dc3545'
          ],
          data: [num_estudiante, no_estudiante]
        }]
      },
      plugins: [plugin],
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

      pdf.addImage(pdfImage, 'JPEG', 15, 15, 270, 150)

      pdf.setProperties({
          title: "Report"
      });

      //pdf.save('chart.pdf')
      pdf.output('dataurlnewwindow');
    })

    //Descargar pdf
    $("#generarPdfGeneral").on("click", function() {
      let heightText = 10
      let heightGrafica = 15
      let pdf = new jsPDF('p', 'mm', [1200, 300])

        $("canvas").each(function(index){
          var canvas = $(this).attr("id")
          var grafica = document.getElementById(canvas)
          var pdfImage = grafica.toDataURL("image/jpeg", 1.0)

          pdf.setFontSize(20)
          var title = $(this).parent().find("h5").text()

          pdf.text(title, 10, heightText)

          pdf.addImage(pdfImage, 'JPEG', 15, heightGrafica, 270, 150)

          heightText+=200
          heightGrafica+=200
        })
      pdf.output('dataurlnewwindow');
    })
  </script>
@endsection