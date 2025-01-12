@extends('layout')

@section('title', 'Lista de Compras')
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Compras</li>
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
           Lista de Compras
        </h1>
        <p> <!-- Botón para realizar una nueva compra -->
            <a href="{{ route('compras.create') }}" class="btn btn-primary bi bi-plus-lg"> Registrar Nueva Compra</a>

        </p>
    </div>

    @include('compras._filters') <!-- Cuadro de búsqueda para buscar la compra -->
    @if ($compras->isNotEmpty())
        <p>Viendo Página {{$compras->currentPage()}} de {{$compras->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center">
                    <th scope="col"># Factura</th>
                    <th scope="col" class="text-center"><a href="{{$sortable->url('fecha_compra')}}" class="{{ $sortable->classes('fecha_compra') }}">Fecha de Compra <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-center">Proveedor </th>
                    <th scope="col" class="text-center">Productos Adquiridos</th>
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($compras as $i=>$compra)
                    @include('compras._row',['compra'=>$compra,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $compras->links()}}
        </div>
        <div class="pt-2 text-center">
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
        </div>
    @else
        <p>No hay compras registradas.</p>
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
                deletecompra:function (compra_id){
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar la compra?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/compra/delete',
                                method:'POST',
                                data:{
                                    'compra_id':compra_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data.status=== true){
                                        Swal.fire(
                                            'Eliminado',
                                            'La compra ha sido eliminada exitosamente',
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



