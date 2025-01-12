
@extends('layout')
@section('title', "Editar Sucursal")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('sucursales.index')}}" class="link-dark">Sucursales</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Sucursal')
    @include('shared._errors')
    <form method="POST" action="{{ url("sucursales/{$sucursal->id}") }}">
        {{ method_field('PUT') }}
        @include('sucursales._fields')
        <div class="form-group mt-4 text-center"> <!-- Botón de actualizar y regresar al listado -->
            <button type="submit" class="btn btn-primary"> <i class="bi bi-arrow-repeat"></i> Actualizar Sucursal</button>
            <a href="{{ route('sucursales.index') }}" class="btn btn-link">Regresar al Listado de Sucursales</a>
        </div>
    </form>
    @endcard
@endsection
