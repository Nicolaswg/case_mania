@extends('layout')

@section('title', "Editar un Empleado")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}" class="link-dark">Empleados</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Empleado')

    @include('shared._errors')

    <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
        {{ method_field('PUT') }}

        @include('users._fields')

        <div class="form-group mt-4 text-center">
            <button type="submit" class="btn btn-primary"> <i class="bi bi-arrow-repeat"></i> Actualizar Empleado</button>
            <a href="{{ route('users.index') }}" class="btn btn-link">Regresar a Listado de Empleados</a>
        </div>
    </form>
    @endcard
@endsection
