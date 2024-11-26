<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>PDF de empleados</title>
		<style>
			*{
				font-family: sans-serif;
			}
			.table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-size: 10px;
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
    <img src="img/headerpdf.png" width="100%">
    <div class="container">
      <div class="col m-4">
					  <h5>Empleados {{$title}}</h5>
					  <table class="table">
              <thead>
                <tr>
                  <th scope="col">Cédula</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Fecha de nacimiento</th>
                  <th scope="col">Teléfono</th>
                  <th scope="col">Cargo</th>
                </tr>
              </thead>
              <tbody>
                @foreach($empleados as $empleado)
                    <tr>
                      <td>{!!$empleado->cedula!!}</td>
                      <td>{!!$empleado->nombre!!}</td>
                      <td>{!!$empleado->correo!!}</td>
                      <td>{!!$empleado->fecha_nacimiento!!}</td>
                      <td>{!!$empleado->telefono!!}</td>
                      <td>{!!$empleado->cargo!!}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
					</div>
    </div>	
	</body>
</html>

