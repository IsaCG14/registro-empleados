<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="shortcut icon" href="img/icono.png"/>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            @csrf
            <img class="m-3" src="/img/user.png" alt="user" width="110" height="110">
            <h2>Iniciar sesión</h2>
            <div>
                <div class="mb-3 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" autofocus value="{{old('user')}}" name="user" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="password" required>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="remember">
                        <label class="form-check-label" for="flexCheckDefault">
                          Recordar sesión
                        </label>
                      </div>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Iniciar sesión">
                </div>
            </div>
            @foreach($errors->all() as $error)
              <div class="alert alert-danger" role="alert">
                {{$error}}
              </div>              
            @endforeach
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>
</html>