
@extends('layout')
@section('title', "Editar Categoría")
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('categorias.index')}}" class="link-dark">Categorías</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Categoría')
    @include('shared._errors')
    <form method="POST" action="{{ url("categorias/{$categoria->id}") }}"> <!-- Botones de editar y regresar al listado -->
        {{ method_field('PUT') }}
        @include('categorias._fields')
        <div class="form-group mt-4 text-center">
            <button type="submit" class="btn btn-primary"> <i class="bi bi-arrow-repeat"></i> Actualizar Categoría</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-link">Regresar al Listado de Categorías</a>
        </div>
    </form>
    @endcard
@endsection
