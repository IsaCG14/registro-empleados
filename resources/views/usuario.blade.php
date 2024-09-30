@extends('layouts.nav')
@section('content')
<!--Crear usuario-->
<div class="modal fade" id="modal-usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success" data-bs-theme="dark">
                <h1 class="modal-title fs-5" style="color: white;">Registrar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/registrar-usuario">
                    @csrf
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Usuario:</label>
                        <input type="text" class="form-control" name="user" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Contraseña:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="contenedor-grid">
    <div class="container">
        <h3>Usuarios</h3>
        <button data-bs-toggle="modal" data-bs-target="#modal-usuario" class="btn btn-success my-3">Nuevo usuario</button>
        <table class="table table-striped list">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th>{!!$user->name!!}</th>
                        <td>{!!$user->user!!}</td>
                        <td>
                            <a data-bs-toggle="modal" data-bs-target="#modal-edit{{$user->id}}" class="btn btn-sm btn-primary"><img src="/img/pencil.png" width="20" height="25" alt="editar"></a>
                            <a data-bs-toggle="modal" data-bs-target="#modal-pass{{$user->id}}" class="btn btn-sm btn-dark"><img src="/img/lock.png" width="20" height="25" alt="pass"></a>
                            <a href="/destroy/{{$user->id}}" class="btn btn-sm btn-danger eliminar-empleado"><img src="/img/trash.png" width="20" height="25" alt="eliminar"></a>
                        </td>
                    </tr>
                <!--Editar usuario-->
                <div class="modal fade" id="modal-edit{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary" data-bs-theme="dark">
                                <h1 class="modal-title fs-5" style="color: white;">Editar usuario</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="/editar-usuario">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" value="{{$user->name}}" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Usuario:</label>
                                        <input type="text" class="form-control" value="{{$user->user}}" name="user" required>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Cambiar contraseña-->
                <div class="modal fade" id="modal-pass{{$user->id}}" tabindex="-1" aria-labelledby="cambioPass" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-dark" data-bs-theme="dark">
                                <h1 class="modal-title fs-5" style="color: white;">Cambiar contraseña</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="/editar-usuario">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nueva contraseña:</label>
                                        <input type="password" class="form-control" id="recipient-name" name="password" required>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
@endsection