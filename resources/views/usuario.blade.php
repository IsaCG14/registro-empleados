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
<div class="contenedor">
    <h3>Usuarios</h3>
    <div class="btn-group w-50">
        <button data-bs-toggle="modal" data-bs-target="#modal-usuario" class="btn btn-success my-3">Nuevo
            usuario</button>
        <div class="dropdown col m-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Ver usuarios
            </button>
            <ul class="dropdown-menu col">
                <li><a class="dropdown-item" href="/usuarios?state=1">Activos</a></li>
                <li><a class="dropdown-item" href="/usuarios?state=0">Inactivos</a></li>
            </ul>
        </div>
    </div>
    <table class="table table-striped">
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
                    @if ($user->deleted_at !== null)
                    <a href="/cambiar-estado/{{$user->id}}" class="btn btn-sm btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-unlock2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 0c1.07 0 2.041.42 2.759 1.104l.14.14.062.08a.5.5 0 0 1-.71.675l-.076-.066-.216-.205A3 3 0 0 0 5 4v2h6.5A2.5 2.5 0 0 1 14 8.5v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7z" />
                        </svg>
                        Activar</a>
                    @else
                    <a data-bs-toggle="modal" data-bs-target="#modal-edit{{$user->id}}"
                        class="btn btn-sm btn-primary"><img src="/img/pencil.png" width="20" height="25" alt="editar">
                        Editar</a>
                    <a data-bs-toggle="modal" data-bs-target="#modal-pass{{$user->id}}" class="btn btn-sm btn-dark"><img
                            src="/img/lock.png" width="20" height="25" alt="pass"> Cambiar contraseña</a>
                    <a href="/destroy/{{$user->id}}" class="btn btn-sm btn-danger eliminar-usuario"><img
                            src="/img/trash.png" width="20" height="25" alt="eliminar"> Bloquear</a>
                    @endif
                </td>
            </tr>
            <!--Editar usuario-->
            <div class="modal fade" id="modal-edit{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
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
                                    <input type="text" class="form-control" value="{{$user->name}}" name="name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Usuario:</label>
                                    <input type="text" class="form-control" value="{{$user->user}}" name="user"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="rol" value="1"
                                            id="checkDefault" {{
                                            $user->rol == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkDefault">
                                            Administrador
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Cambiar contraseña-->
            <div class="modal fade" id="modal-pass{{$user->id}}" tabindex="-1" aria-labelledby="cambioPass"
                aria-hidden="true">
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
                                    <input type="password" class="form-control" id="recipient-name" name="password"
                                        required>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
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
@endsection