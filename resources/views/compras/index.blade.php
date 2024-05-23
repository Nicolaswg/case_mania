@extends('layout')

@section('title', 'Productos')
@section('breadcrumb')
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
        <p>
            <a href="{{ route('compras.create') }}" class="btn btn-dark">Añadir Nueva</a>

        </p>
    </div>

    @include('compras._filters')
    @if ($compras->isNotEmpty())
        <p>Viendo pagina {{$compras->currentPage()}} de {{$compras->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center">
                    <th scope="col">#</th>
                    <th scope="col"><a href="{{$sortable->url('fecha_compra')}}" class="{{ $sortable->classes('fecha_compra') }}">Fecha de Compra <i class="icon-sort"></i></a></th>
                    <th scope="col">Proveedor </th>
                    <th scope="col">Productos Adquiridos</th>
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
                        confirmButtonText: 'Si, Eliminarlo!'
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



