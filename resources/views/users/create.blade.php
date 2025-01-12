@extends('layout')
@section('title', "Crear un Empleado")
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}" class="link-dark">Empleados</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nuevo Empleado')
    @include('shared._errors')
    <form method="POST" action="{{ url('usuarios') }}" id="app"> <!-- Botón crear empleado y  botón regresar al listado -->
        @include('users._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit" :disabled=" empleado === true && cargo === ''" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Crear Empleado</button>
            <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al Listado de Empleados</a>
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
                showinfo:false,
            },
            methods:{
                config(){
                    if(this.empleado===true){
                        this.empleado=false

                    }else{
                        this.empleado=true
                    }
                },
                deleteuser:function (user_id){ //Función para eliminar el empleado
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar el empleado?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar'
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
                                        Swal.fire( //Confirmación de empleado eliminado
                                            'Eliminado',
                                            'El empleado ha sido eliminado exitosamente',
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
                },
                verificarinfo(){ //Función para ver los detalles del empleado
                    this.showinfo = this.showinfo !== true;
                },
            },
            computed:{
            }
        })

    </script>

@endsection

