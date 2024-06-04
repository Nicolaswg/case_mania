
@extends('layout')
@section('title', "Editar Categoria")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('categorias.index')}}" class="link-dark">Categorias</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Categoria')
    @include('shared._errors')
    <form method="POST" action="{{ url("categorias/{$categoria->id}") }}">
        {{ method_field('PUT') }}
        @include('categorias._fields')
        <div class="form-group mt-4 text-center">
            <button type="submit" class="btn btn-primary"> <i class="bi bi-person-check-fill"></i> Actualizar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-link">Regresar</a>
        </div>
    </form>
    @endcard
@endsection
