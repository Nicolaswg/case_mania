@extends('layout')

@section('title', "{$user->name}")
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}" class="link-dark">Empleados</a></li>
    <li class="breadcrumb-item active" aria-current="page">Mostrar</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3 mt-2">
        <h3 class="pb-1">{{ $user->name }}</h3>
        <p><a href="{{ route('users.index') }}" class="btn btn-primary btn-sm bi bi-arrow-return-left"> Regresar al Listado de Empleados</a></p>
    </div>

    <div class="row"> 
        <div class="col-6"> <!-- Cuadro de los detalles de la cuenta del empleado -->
            <div class="card">
                <div class="card-header">
                    <h5>Detalles de la Cuenta del Empleado</h5>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <p><strong>Correo Electrónico:</strong> {{ $user->email }}</p>
                        <p><strong>Rol de Usuario:</strong> {{ucwords( $user->role)  }}</p>
                        <p><strong>Fecha de Registro:</strong> {{\Carbon\Carbon::parse( $user->created_at)->format('d-m-Y h:i' )  }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6"> <!-- Cuadro de los detalles del perfil del empleado -->
            <div class="card">
                <div class="card-header">
                    <h5>Detalles del Perfil del Empleado</h5>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <p><strong>Fecha de Nacimiento:</strong> </p>
                        <p><strong>Dirección de Domicilio:</strong> {{ ucfirst($user->profile->ubicacion) }}</p>
                        <p><strong>Teléfono:</strong> {{ $user->profile->num_cel  }}</p>
                        <p><strong>Número de Documento:</strong> {{ucfirst($user->profile->tipo_documento)}}-{{$user->profile->num_documento}}</p>
                        <p><strong>Sucursal:</strong> {{ucwords( $user->profile->sucursal->nombre)  }}</p>
                    </div>
                    <div class="card-header-pills" align="right"> <!-- Botón para editar el empleado -->
                        <div class="btn-group" role="group" aria-label="Basic example" align="right">
                            <a type="button" href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary"><span class="oi oi-pencil"></span> Editar</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <br>
@endsection
