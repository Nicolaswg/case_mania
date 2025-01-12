@extends('layout')

@section('title', 'Almacén')
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Almacén</li>
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
          Productos por Sucursal
        </h1>
        <p> <!-- Botones para cargar producto, registrar nueva compra (solo administrador) y registrar un producto-->
            @admin
            <a href="{{ route('compras.cargar') }}" class="btn btn-success bi bi-plus-lg">Cargar Compra</a>
            <a href="{{ route('compras.create') }}" class="btn btn-primary bi bi-plus-lg">Registrar Nueva Compra</a>
            @endif
            <a href="{{ route('productos.create') }}" class="btn btn-primary bi bi-plus-lg">Registrar Nuevo Producto</a>
        </p>
    </div>

    @include('productos._filtersalmacen') <!-- Incluye los filtros -->
    @if ($productos->isNotEmpty())
        <p>Viendo Página {{$productos->currentPage()}} de {{$productos->lastPage()}}</p>
        <div class="table-responsive-lg"> <!-- Detalles de la Tabla -->
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center">
                    <th scope="col">Imagen del Producto</th>
                    <th scope="col" class="text-center"><a href="{{$sortable->url('nombre')}}" class="{{ $sortable->classes('nombre') }}">Nombre del Producto<i class="icon-sort"></i></a></th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Cantidad Total</th>
                    <th scope="col">Precio de Venta</th>
                    <th scope="col">Disponibilidad por Sucursal</th>
                    <th scope="col">Devoluciones</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productos as $i=>$producto)
                    @include('productos._row_almacen',['producto'=>$producto,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $productos->links()}}
        </div>
        <div class="pt-2 text-center"> <!-- Botón para regresar al inicio -->
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
        </div>
    @else
        <h2>No hay productos registrados</h2>
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
                deleteproducto:function (producto_id){
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar el Producto?',
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
                                        Swal.fire(
                                            'Eliminado',
                                            'El producto ha sido eliminado exitosamente',
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



