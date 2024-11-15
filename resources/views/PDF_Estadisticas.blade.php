<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>PDF de estadisticas</title>
		<style>
			*{
				font-family: sans-serif;
			}
			.table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-spacing: 0; 
    width: 100%;
}

.table td, .table th {
    padding: 8px;
    text-align: center;
}

.table tr:nth-child(even){
    background-color: #f2f2f2;
    }

.table th{
    background-color: #00889f;
    color: white;
}
		</style>
	</head>
	<body>
		@php
	    $num_f = 0;
        $num_m = 0;
        $num_o = 0;
        $num_estudiante = 0;
        $no_estudiante = 0;
        $num_contratado = 0;
        $num_fijo = 0;
        $rango1 = 0;
        $rango2 = 0;
        $rango3 = 0;
        $rango4 = 0;
        $rango5 = 0;
        $anio1 = 0; 
        $anio2 = 0;
        $anio3 = 0;
        $anio4 = 0; 
        $anio5 = 0;

		foreach($empleados as $empleado){
        //valorar genero
        if($empleado->sexo == "Masculino"){
            $num_m++;
        } else if ($empleado->sexo == "Femenino"){
            $num_f++;
        } else if ($empleado->sexo == "Otro"){
            $num_o++;
        }

        //valorar tipo
        if($empleado->tipo == 1){
            $num_fijo++;
        } else if ($empleado->tipo == 0){
            $num_contratado++;
        } 
        if ($empleado->estudiante == 1){
            $num_estudiante++;
        } else {
          $no_estudiante++;
        }

        //valorar edades

        //Calcular edad
        date_default_timezone_set('UTC');
        $fecha_actual = new DateTime(date('Y-m-d'));
        $fecha_nac = new DateTime($empleado->fecha_nacimiento);
        $diferencia = $fecha_nac->diff($fecha_actual);

        // Obtener la diferencia en años
        $edad = $diferencia->y;

        //console.log(edad)

        if($edad >= 18 && $edad <= 24){
          $rango1++;
        } else if($edad >= 25 && $edad <= 30){
          $rango2++;
        } else if($edad >= 31 && $edad <= 45){
          $rango3++;
        } else if($edad >= 46 && $edad <= 55){
          $rango4++;
        } else if($edad >= 56){
          $rango5++;
        }

        //Calcular años de servicio
        date_default_timezone_set('UTC');
        $fecha_actual = new DateTime(date('Y-m-d'));
        $fecha_in = new DateTime($empleado->fecha_ingreso);
        $diferencia = $fecha_in->diff($fecha_actual);
        $anios = $diferencia->y;

        if($anios <= 5){
          $anio1++;
        } else if ($anios >= 6 && $anios <= 10){
          $anio2++;
        } else if ($anios >= 11 && $anios <= 15){
          $anio3++;
        } else if ($anios >= 16 && $anios <= 20){
          $anio4++;
        } else {
          $anio5++;
        }
    } 

		@endphp
		<div class="contenedor-grid">
			<div class="container">
				<h3>Estadísticas</h3>
				  <div class="row m-2">
					<div class="col m-4">
					  <h5>Tabla por sexo</h5>
					  <table class="table">
						<thead>
							<th>Género</th>
							<th>Cantidad</th>
						</thead>
						<tbody>
							<tr>
								<td>Masculino</td>
								<td>{{$num_m}}</td>
							</tr>
							<tr>
								<td>Femenino</td>
								<td>{{$num_f}}</td>
							</tr>
						</tbody>
					  </table>
					</div>
					<div class="col m-4">
					  <h5>Tabla por rango de edades</h5>
					  <table class="table">
              <thead>
                <th>Rango</th>
                <th>Cantidad</th>
              </thead>
              <tbody>
                <tr>
                  <td>18 a 24</td>
                  <td>{{$rango1}}</td>
                </tr>
                <tr>
                  <td>25 a 30</td>
                  <td>{{$rango2}}</td>
                </tr>
                <tr>
                  <td>31 a 45</td>
                  <td>{{$rango3}}</td>
                </tr>
                <tr>
                  <td>46 a 55</td>
                  <td>{{$rango4}}</td>
                </tr>
                <tr>
                  <td>56+</td>
                  <td>{{$rango5}}</td>
                </tr>
              </tbody>
              </table>
					</div>
				  </div>
				  <div class="row m-2">
					<div class="col m-4">
					  <h5>Tabla por centro de votación</h5>
					  <table class="table">
              <thead>
                <tr>
                  <th>Centro de votación</th>
                  <th>Empleados que votan allí</th>
                </tr>
              </thead>
              <tbody>
                @foreach($centros as $centro)
                    <tr>
                      <td>{{$centro->nombre_centro}}</td>
                      <td>{{$centro->total}}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
					</div>
					<div class="col m-4">
					  <h5>Tabla por tipo de empleado</h5>
					  <table class="table">
              <thead>
                <th>Tipo de empleado</th>
                <th>Cantidad</th>
              </thead>
              <tbody>
                <tr>
                  <td>Trabajador fijo</td>
                  <td>{{$num_fijo}}</td>
                </tr>
                <tr>
                  <td>Contratado</td>
                  <td>{{$num_contratado}}</td>
                </tr>
              </tbody>
            </table>
					</div>
				  </div>
				  <div class="row m-2">
					<div class="col m-4">
					  <h5>Tabla por años de servicio</h5>
					  <table class="table">
              <thead>
                <th>Rango</th>
                <th>Cantidad</th>
              </thead>
              <tbody>
                <tr>
                  <td>0 a 5</td>
                  <td>{{$anio1}}</td>
                </tr>
                <tr>
                  <td>6 a 10</td>
                  <td>{{$anio2}}</td>
                </tr>
                <tr>
                  <td>11 a 15</td>
                  <td>{{$anio3}}</td>
                </tr>
                <tr>
                  <td>16 a 20</td>
                  <td>{{$anio4}}</td>
                </tr>
                <tr>
                  <td>21+</td>
                  <td>{{$anio5}}</td>
                </tr>
              </tbody>
              </table>
					</div>
					<div class="col m-4">
					  <h5>Tabla de estudiantes</h5>
					  <table class="table">
              <tbody>
                <tr>
                  <td>Estudiantes</td>
                  <td>{{$num_estudiante}}</td>
                </tr>
                <tr>
                  <td>No estudiantes</td>
                  <td>{{$no_estudiante}}</td>
                </tr>
              </tbody>
              </table>
					</div>
				  </div>
			</div>
		  </div>		  
	</body>
</html>

