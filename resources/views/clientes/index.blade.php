@extends('layout')

@section('title', 'Clientes')
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Clientes</li>
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
            Lista de Clientes
        </h1>
        <p> <!-- Botón para crear un nuevo cliente -->
        <a href="{{ route('clientes.create') }}" class="btn btn-primary bi bi-plus-lg"> Registrar Nuevo Cliente</a>
        </p>
    </div>

    @include('clientes._filters') <!-- Filtros de búsqueda -->
    @if ($clientes->isNotEmpty())
    <div class="card col-md-3" align="left"> <!-- Leyenda -->
        <div class="text-center"><label><strong >Leyenda</strong></label></div>
            <label>Estado Activo = <strong class="text-success">Verde</strong></label>
            <label>Estado Inactivo = <strong class="text-danger">Rojo</strong></label>
    </div>
        <p>Viendo Página {{$clientes->currentPage()}} de {{$clientes->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app"> <!-- Detalles de la tabla -->
                <thead class="thead-dark">
                <tr class="text-center">
                    <th scope="col"><a href="{{$sortable->url('nombre')}}" class="{{ $sortable->classes('nombre') }}">Nombre del Cliente <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center">Contacto</th>
                    <th scope="col" class="text-center">Dirección</th>
                    <th scope="col" class="text-center">Fecha de Registro</th>
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clientes as $i=>$cliente)
                    @include('clientes._row',['cliente'=>$cliente,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $clientes->links()}}
        </div>
        <div class="pt-2 text-center">
    <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
</div>
    @else
        <p>No hay clientes registrados.</p>
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
                deletecliente:function (cliente_id){
                    Swal.fire({
                        title: '¿Seguro que deseas desactivar este Cliente?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Desactivarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/cliente/delete',
                                method:'POST',
                                data:{
                                    'cliente_id':cliente_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire(
                                            'Desactivado!',
                                            'El cliente a sido Desactivado de Forma Exitosa.',
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



