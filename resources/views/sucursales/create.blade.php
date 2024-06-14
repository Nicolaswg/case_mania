@extends('layout')
@section('title', "Crear Sucursal")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('sucursales.index')}}" class="link-dark">Sucursales</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nueva Sucursal')
    @include('shared._errors')
    <form method="POST" action="{{ url('sucursales') }}" id="app">
        @include('sucursales._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Guardar</button>
            <a href="{{ route('sucursales.index') }}" class="btn btn-link">Regresar al listado</a>
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

