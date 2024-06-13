@extends('layout')

@section('title', 'Productos')
@section('breadcrumb')
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
        <p>
            <a href="{{ route('productos.create') }}" class="btn btn-dark">Añadir Nuevo</a>

        </p>
    </div>

    @include('productos._filters')
    @if ($productos->isNotEmpty())
        <p>Viendo pagina {{$productos->currentPage()}} de {{$productos->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center">
                    <th scope="col">#</th>
                    <th scope="col">Imagen</th>
                    <th scope="col"><a href="{{$sortable->url('nombre')}}" class="{{ $sortable->classes('nombre') }}">Nombre <i class="icon-sort"></i></a></th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Categoria </th>
                    <th scope="col">Precio de Compra </th>
                    <th scope="col">% Ganancia </th>
                    <th scope="col">Precio de Venta </th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
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



