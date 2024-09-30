@extends('layouts.nav')
@section('content')
<div class="contenedor-grid">
    <div class="container">
        <h3>Estadísticas</h3>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ver gráfica de 
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Géneros</a></li>
              <li><a class="dropdown-item" href="#">Edades</a></li>
              <li><a class="dropdown-item" href="#">Años de servicio</a></li>
            </ul>
          </div>
        <canvas id="grafica"></canvas>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const empls = @json($empleados);
    console.log(empls)

    var num_f = 0
    var num_m = 0
    var num_o = 0

    $.each(empls, function(key, value){
        if(value.sexo == "Masculino"){
            num_m++
        } else if (value.sexo == "Femenino"){
            num_f++
        } else if (value.sexo == "Otro"){
            num_o++
        }
    })

    const ctx = document.getElementById('grafica');
  
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Masculino', 'Femenino', 'Otro'],
        datasets: [{
          label: '# personas',
          data: [num_m, num_f, num_o],
          backgroundColor: [
            'rgb(54, 162, 235)',
            'rgb(255, 99, 132)',
            'rgb(255, 205, 86)'
          ],
        }]
      }
    });
  </script>
@endsection