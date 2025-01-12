@extends('layout')

@section('title', 'Lista de Empleados')
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Empleado</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <span class="oi oi-check"></span> {{session('success')}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-warning" role="alert">
            <span class="oi oi-x"></span> {{session('error')}}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">
            {{trans("users.title.{$view}")}}
        </h1>
        <p>
        <a href="{{ route('users.create') }}" class="btn btn-primary bi bi-plus-lg"> Regisitrar Nuevo Empleado</a>

        </p>
    </div>

    @includeWhen($view=='index','users._filters') <!-- Incluir los filtros de los roles -->
    @if ($users->isNotEmpty())
        <p>Viendo Página {{$users->currentPage()}} de {{$users->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app"> <!-- Detalles de la tabla -->
                <thead class="thead-dark">
                <tr class="">
                    <!-- <th scope="col">#</th> -->
                    <th scope="col"><a href="{{$sortable->url('name')}}" class="{{ $sortable->classes('name') }}">Nombre <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center"><a href="{{$sortable->url('name')}}" class="{{ $sortable->classes('name') }}">Dirección <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center"><a href="{{$sortable->url('email')}}" class="{{ $sortable->classes('email') }}">Correo Electrónico<i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center"><a href="{{$sortable->url('date')}}" class="{{ $sortable->classes('date') }}">Fecha de Registro <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @each('users._row', $users, 'user')
                </tbody>
            </table>

            {{ $users->links()}}
        </div>
        <div class="pt-2 text-center"> <!-- Botón para regresar al inicio -->
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
        </div>
    @else
        <h2>No hay empleados registrados.</h2> <!-- Cuando no hayan empleados registrados -->
    @endif
@endsection

@section('sidebar')
    @parent
@endsection
@section('script')
    <script>
        const user=new Vue({
            el:'#app',
            data: {

            },
            methods:{
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
                }
            },
            computed:{
            }
        })

    </script>

@endsection



