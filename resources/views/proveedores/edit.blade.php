
@extends('layout')
@section('title', "Editar un Proveedor")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('proveedores.index')}}" class="link-dark">Proveedores</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Proveedor')
    @include('shared._errors')
    <form method="POST" action="{{ url("proveedores/{$proveedor->id}") }}">
        {{ method_field('PUT') }}
        @include('proveedores._fields')
        <div class="form-group mt-4 text-center"> <!-- Botones de actualizar proveedor y regresal al listado -->
            <button type="submit" class="btn btn-primary"> <i class="bi bi-arrow-repeat"></i> Actualizar Proveedor</button>
            <a href="{{ route('proveedores.index') }}" class="btn btn-link">Regresar al Listado de Proveedores</a>
        </div>
    </form>
    @endcard
@endsection
