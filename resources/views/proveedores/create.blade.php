@extends('layout')
@section('title', "Crear un Proveedor")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('proveedores.index')}}" class="link-dark">Proveedores</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nuevo Proveedor')
    @include('shared._errors')
    <form method="POST" action="{{ url('proveedores') }}" id="app">
        @include('proveedores._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Guardar Proveedor</button>
            <a href="{{ route('proveedores.index') }}" class="btn btn-link">Regresar al Listado de Proveedores</a>
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

