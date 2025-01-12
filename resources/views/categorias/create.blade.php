@extends('layout')
@section('title', "Crear Categoría")
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('categorias.index')}}" class="link-dark">Categorías</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nueva Categoría')
    @include('shared._errors')
    <form method="POST" action="{{ url('categorias') }}" id="app"> <!-- Botones de guardar categoría y regresar al listado -->
        @include('categorias._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Guardar Categoría</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-link">Regresar al Listado de Categorías</a>
        </div>
    </form>
    @endcard
@endsection
@section('script')
    <script>
        Vue.config.debug=true
        Vue.config.devtools=true
        const app=new Vue({
            el:'#app',
            data: {
                empleado:'',
                cargo:'',
            },
            methods: {},
            computed:{
            }
        })

    </script>

@endsection

