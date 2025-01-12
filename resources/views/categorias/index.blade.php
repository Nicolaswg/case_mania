@extends('layout')

@section('title', 'Categorías')
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categorías</li>
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
            Lista de Categorías
        </h1>
        <p> <!-- Botón para crear nueva categoría -->
        <a href="{{ route('categorias.create') }}" class="btn btn-primary bi bi-plus-lg"> Regisitrar Nueva Categoría</a> 
        </p>
    </div>
    <div class="card col-md-3" align="left"> <!-- Leyenda -->
        <div class="text-center"><label><strong >Leyenda</strong></label></div>
            <label>Estado Activo = <strong class="text-success">Verde</strong></label>
            <label>Estado Inactivo = <strong class="text-danger">Rojo</strong></label>
    </div>
    @if ($categorias->isNotEmpty())
        <p>Viendo Página {{$categorias->currentPage()}} de {{$categorias->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app"> <!-- Detalles de la tabla -->
                <thead class="thead-dark">
                <tr class="">
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">Nombre de la Categoría</th>
                    <th scope="col" class="text-center">Productos Asociados</th>
                    <th scope="col" class="text-center">Registro</th>
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorias as $i=>$categoria)
                    @include('categorias._row',['categoria'=>$categoria,'i'=>$i])
                @endforeach
                </tbody>
            </table>
            <div class="pt-2 text-center"> <!-- Botón pra regresar al inicio -->
            <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
            </div>
            {{ $categorias->links()}}
        </div>
    @else
        <h2>No hay Categorías registradas.</h2>
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
                deletecategoria:function (categoria_id){
                    Swal.fire({ //Función para desactivar la categoría
                        title: '¿Seguro que deseas desactivar esta Categoría?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Desactivar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/categorias/delete',
                                method:'POST',
                                data:{
                                    'categoria_id':categoria_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire( //Confirmación de categoría desactivada
                                            'Desactivado',
                                            'La categoría ha sido desactivada exitosamente',
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



