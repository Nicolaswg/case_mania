@extends('layout')

@section('title', "Editar Producto")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('productos.index')}}" class="link-dark">Productos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Producto')

    @include('shared._errors')

    <form method="POST" action="{{ url("productos/{$producto->id}") }}" enctype="multipart/form-data">
        {{ method_field('PUT') }}

        @include('productos._fields')

        <div class="form-group mt-4 text-center">
            <button type="submit" class="btn btn-primary"> <i class="bi bi-arrow-repeat"></i> Actualizar Producto</button>
            <a href="{{ route('productos.index') }}" class="btn btn-link">Regresar</a>
        </div>
    </form>
    @endcard
@endsection
