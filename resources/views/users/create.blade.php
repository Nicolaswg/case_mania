@extends('layout')
@section('title', "Crear usuario")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}" class="link-dark">Usuarios</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nuevo usuario')
    @include('shared._errors')
    <form method="POST" action="{{ url('usuarios') }}" id="app">
        @include('users._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit" :disabled=" empleado === true && cargo === ''" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Crear usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
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

