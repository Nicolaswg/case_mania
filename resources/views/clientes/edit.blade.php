
@extends('layout')
@section('title', "Editar Cliente")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('clientes.index')}}" class="link-dark">Clientes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Cliente')
    @include('shared._errors')
    <form method="POST" action="{{ url("clientes/{$cliente->id}") }}">
        {{ method_field('PUT') }}
        @include('clientes._fields') <!-- Filtros de búsqueda -->
        <div class="form-group mt-4 text-center"> <!-- Botón para actualizar el cliente y regresar al listado -->
        <button type="submit" class="btn btn-primary"> <i class="bi bi-arrow-repeat"></i> Actualizar Cliente</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-link">Regresar a Listado de Clientes</a>
        </div>
    </form>
    @endcard
@endsection
