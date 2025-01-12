@extends('layout')

@section('title', 'Lista de Productos')
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Productos</li>
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
           Lista de Productos
        </h1>
        <p> <!-- Botón para registrar nuevo producto -->
            <a href="{{ route('productos.create') }}" class="btn btn-primary bi bi-plus-lg"> Regisitrar Nuevo Producto</a>

        </p>
    </div>

    @include('productos._filters') <!-- Incluir filtros de búsqueda -->
    @if ($productos->isNotEmpty())
        <p>Viendo Página {{$productos->currentPage()}} de {{$productos->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app"> <!-- Detalles de la tabla -->
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center">
                    <th scope="col">Imagen del Producto</th>
                    <th scope="col" class="text-center"><a href="{{$sortable->url('nombre')}}" class="{{ $sortable->classes('nombre') }}">Nombre del Producto <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center">Descripción</th>
                    <th scope="col" class="text-center">Categoría </th>
                    <th scope="col" class="text-center">Sucursal</th>
                    <!--<th scope="col">% Ganancia </th>
                    <th scope="col">Precio de Venta </th>-->
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productos as $i=>$producto)
                    @include('productos._row',['producto'=>$producto,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $productos->links()}}
        </div>
        <div class="pt-2 text-center"> <!-- Botón para regresar al inicio -->
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
        </div>
    @else
        <h2>No hay productos registrados.</h2>
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
                    Swal.fire({ //Función para eliminar el producto
                        title: '¿Seguro que deseas eliminar el producto?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/productos/delete',
                                method:'POST',
                                data:{
                                    'producto_id':producto_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){ //Confirmación de producto eliminado
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



