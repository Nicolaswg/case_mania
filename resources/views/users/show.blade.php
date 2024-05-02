@extends('layout')

@section('title', "{$user->name}")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}" class="link-dark">Usuarios</a></li>
    <li class="breadcrumb-item active" aria-current="page">Mostrar</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3 mt-2">
        <h3 class="pb-1">{{ $user->name }}</h3>
        <p><a href="{{ route('users.index') }}" class="btn btn-outline-dark btn-sm">Regresar al listado</a></p>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Detalles de la Cuenta del Usuario
                </div>
                <div class="card-body">
                    <h5 class="card-title">ID del usuario: {{ $user->id }}</h5>
                    <div class="card-text">
                        <p><strong>Correo electrónico</strong>: {{ $user->email }}</p>
                        <p><strong>Rol</strong>: {{ucwords( $user->role)  }}</p>
                        <p><strong>Fecha de registro</strong>: {{\Carbon\Carbon::parse( $user->created_at)->format('d-m-Y h:i' )  }}</p>



                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Detalles del Perfil del Usuario
                </div>
                <div class="card-body">
                    <h5 class="card-title">ID del usuario: {{ $user->id }}</h5>
                    <div class="card-text">
                        <p><strong>Ubicacion</strong>: {{ ucfirst($user->profile->ubicacion) }}</p>
                        <p><strong>Telefono</strong>: {{ $user->profile->num_cel  }}</p>
                        <p><strong>N° de Documento: </strong>:{{ucfirst($user->profile->tipo_documento)}}-{{$user->profile->num_documento}}</p>
                        <p><strong>Profesion</strong>: {{ucwords( $user->profile->profesion)  }}</p>

                    </div>
                    <div class="card-header-pills" align="right">
                        <div class="btn-group" role="group" aria-label="Basic example" align="right">
                            <a type="button" href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary"><span class="oi oi-pencil"></span>Editar</a>
                            <a type="button" href="{{ route('users.index') }}"  class="btn btn-outline-danger"><span class="oi oi-chevron-left"></span> Regresar</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <br>
@endsection
