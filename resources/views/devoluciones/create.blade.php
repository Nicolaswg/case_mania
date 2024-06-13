@extends('layout')
@section('title', "Crear Devolucion")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('ventas.index')}}" class="link-dark">Ventas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Registrar Devolucion')
    @include('shared._errors')
    <form method="POST" action="{{ url('devolucion') }}" id="app">
        @include('devoluciones._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit" :disabled="ini || (devolucion && razon === '')" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i>Guardar</button>
            <a href="{{ route('devoluciones.index') }}" class="btn btn-link">Ir al listado</a>
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
                cargo:'',
                producto:'',
                devolucion:false,
                razon:'',
                ini:true,
            },
            methods:{
                config(){
                    this.ini=false
                    if(this.devolucion===true){
                        this.devolucion=false

                    }else{
                        this.devolucion=true
                    }
                },
            },
            computed:{
            }
        })

    </script>

@endsection

