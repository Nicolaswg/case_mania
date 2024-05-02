@extends('layout')
@section('title', "Crear usuario")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}" class="link-dark">Usuarios</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nuevo usuario')
    @include('shared._errors')
    <form method="POST" action="{{ url('usuarios') }}">
        @include('users._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Crear usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
        </div>
    </form>
    @endcard
@endsection

