@extends('layout')
@section('title', "Crear Cliente")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('clientes.index')}}" class="link-dark">Clientes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nuevo Cliente')
    @include('shared._errors')
    <form method="POST" action="{{ url('clientes') }}" id="app">
        @include('clientes._fields')
        <div class="form-group mt-4" align="middle"> <!-- Botón para guardar cliente y regresar al listado -->
        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Guardar Cliente</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-link">Regresar al Listado de Clientes</a>
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
            methods:{
                config(){
                    if(this.empleado===true){
                        this.empleado=false

                    }else{
                        this.empleado=true
                    }
                },
            },
            computed:{
            }
        })

    </script>

@endsection

