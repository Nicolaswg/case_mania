@extends('layout')

@section('title', 'Sucursales')
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Sucursales</li>
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
            Lista de Sucursales
        </h1>
        <p>
        <a href="{{ route('sucursales.create') }}" class="btn btn-primary bi bi-plus-lg"> Regisitrar Nueva Sucursal</a>
        </p>
    </div>
    <div class="card col-md-3" align="left">
        <div class="text-center"><label><strong >Leyenda</strong></label></div>
            <label>Estado Activo = <strong class="text-success">Verde</strong></label>
            <label>Estado Inactivo = <strong class="text-danger">Rojo</strong></label>
    </div>
    @if ($sucursales->isNotEmpty())
        <p>Viendo Página {{$sucursales->currentPage()}} de {{$sucursales->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark"> <!-- Subtítulos de la tabla -->
                <tr class="">
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">Nombre de la Sucursal</th>
                    <th scope="col" class="text-center">Código</th>
                    <th scope="col" class="text-center">Ubicación</th>
                    <th scope="col" class="text-center">Registro</th>
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sucursales as $i=>$sucursal)
                    @include('sucursales._row',['sucursal'=>$sucursal,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $sucursales->links()}}
        </div>
        <div class="pt-2 text-center">
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
        </div>
    @else
        <p>No hay Sucursales registrados.</p>
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
                deletesucursal:function (sucursal_id){
                    Swal.fire({
                        title: '¿Seguro que deseas desactivar esta Sucursal?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Desactivarla!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/sucursales/delete',
                                method:'POST',
                                data:{
                                    'sucursal_id':sucursal_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire(
                                            'Desactivado!',
                                            'La Scuursal a sido Desactivado de Forma Exitosa.',
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



