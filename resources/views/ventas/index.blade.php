@extends('layout')

@section('title', 'Ventas')
@section('breadcrumb')
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
        <p>
            <a href="{{ route('ventas.create') }}" class="btn btn-dark">Añadir Nueva</a>

        </p>
    </div>

    @include('ventas._filters')
    @if ($ventas->isNotEmpty())
        <p>Viendo pagina {{$ventas->currentPage()}} de {{$ventas->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="" style="justify-content: center" align="center">
                    <th scope="col">#</th>
                    <th scope="col"><a href="{{$sortable->url('fecha_venta')}}" class="{{ $sortable->classes('fecha_venta') }}">Fecha de Venta <i class="icon-sort"></i></a></th>
                    <th scope="col">Cliente </th>
                    <th scope="col">Productos Vendidos</th>
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
    @else
        <p>No hay Ventas registradas.</p>
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
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar la venta?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminarlo!'
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
                                        Swal.fire(
                                            'Elimininado!',
                                            'la venta a sido Eliminado.',
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



