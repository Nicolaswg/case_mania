@extends('layout')

@section('title', "Editar usuario")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}" class="link-dark">Usuarios</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar usuario')

    @include('shared._errors')

    <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
        {{ method_field('PUT') }}

        @include('users._fields')

        <div class="form-group mt-4 text-center">
            <button type="submit" class="btn btn-primary"> <i class="bi bi-person-check-fill"></i> Actualizar usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-link">Regresar</a>
        </div>
    </form>
    @endcard
@endsection
