@extends('layout')
@section('title', "Añadir Producto")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('productos.index')}}" class="link-dark">Productos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Añadir Producto')
    @include('shared._errors')
    <form method="POST" action="{{ url('productos') }}" id="app" enctype="multipart/form-data">
        @include('productos._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit"  class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Añadir Producto</button>
            <a href="{{ route('productos.index') }}" class="btn btn-link">Regresar</a>
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
                deleteuser:function (user_id){
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar el Usuario?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/user/delete',
                                method:'POST',
                                data:{
                                    'user_id':user_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire(
                                            'Elimininado!',
                                            'El archivo a sido Eliminado.',
                                            'success',
                                        ).then(function (){
                                            location.reload()
                                        })
                                    }
                                },
                                error:function (jqXHR){
                                    console.log(jqXHR.responseJSON)
                                }
                            })
                        }
                    })
                }
            },
            computed:{
            }
        })

    </script>

@endsection
