@extends('layout')

@section('title', 'Almacén')
@section('breadcrumb')
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
        <p>
            <a href="{{ route('compras.cargar') }}" class="btn btn-success bi bi-plus-lg">Cargar Compra</a>
            <a href="{{ route('compras.create') }}" class="btn btn-primary bi bi-plus-lg">Registrar Nueva Compra</a>
            <a href="{{ route('productos.create') }}" class="btn btn-primary bi bi-plus-lg">Registrar Nuevo Producto</a>
        </p>
    </div>

    @include('productos._filtersalmacen')
    @if ($productos->isNotEmpty())
        <p>Viendo pagina {{$productos->currentPage()}} de {{$productos->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center">
                    <th scope="col">Imagen</th>
                    <th scope="col" class="text-center"><a href="{{$sortable->url('nombre')}}" class="{{ $sortable->classes('nombre') }}">Nombre <i class="icon-sort"></i></a></th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Cantidad Total</th>
                    <th scope="col">Disponible por Sucursal</th>
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
    @else
        <p>No hay productos registrados.</p>
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



