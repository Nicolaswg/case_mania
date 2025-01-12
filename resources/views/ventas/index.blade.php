@extends('layout')

@section('title', 'Lista de Ventas')
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ventas</li>
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
           Lista de Ventas
        </h1>
        <p> <!-- Botón para registrar una nueva venta -->
            <a href="{{ route('ventas.create') }}" class="btn btn-primary bi bi-plus-lg"> Regisitrar Nueva Venta</a>
        </p>
    </div>

    @include('ventas._filters') <!-- Filtros de la venta -->
    @if ($ventas->isNotEmpty())
        <p>Viendo Página {{$ventas->currentPage()}} de {{$ventas->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app"> <!-- Detalles de la tabla -->
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center"> <!-- Subtítulos de la tabla -->
                    <th scope="col"><a href="{{$sortable->url('fecha_venta')}}" class="{{ $sortable->classes('fecha_venta') }}">Fecha de Venta <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center">Cliente </th>
                    <th scope="col" class="text-center">Productos Vendidos</th>
                    <th scope="col" class="text-center">Servicio a Domicilio</th>
                    <th scope="col" class="text-center">Estado</th>
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ventas as $i=>$venta)
                    @include('ventas._row',['venta'=>$venta,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $ventas->links()}}
        </div>
        <div class="pt-2 text-center">
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
        </div>
    @else
        <p>No hay Ventas Registradas.</p>
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
                deleteventa:function (venta_id){
                    Swal.fire({ //Función para eliminar la venta
                        title: '¿Seguro que deseas eliminar la venta?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/venta/delete',
                                method:'POST',
                                data:{
                                    'venta_id':venta_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data.status=== true){
                                        Swal.fire( //Función para confirmación de venta eliminada
                                            'Eliminado',
                                            'La venta ha sido eliminada exitosamente',
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



