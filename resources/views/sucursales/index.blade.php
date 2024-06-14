@extends('layout')

@section('title', 'Sucursales')
@section('breadcrumb')
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
            <a href="{{ route('sucursales.create') }}" class="btn btn-dark">Nueva Sucursal</a>
        </p>
    </div>
    @if ($sucursales->isNotEmpty())
        <p>Viendo pagina {{$sucursales->currentPage()}} de {{$sucursales->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="">
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Ubicacion</th>
                    <th scope="col">Registro</th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
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



