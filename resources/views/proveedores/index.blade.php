@extends('layout')

@section('title', 'Proveedores')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
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
            Lista de Proveedores
        </h1>
        <p>
            <a href="{{ route('proveedores.create') }}" class="btn btn-dark">Nuevo Proveedor</a>
        </p>
    </div>

    @include('proveedores._filters')
    @if ($proveedores->isNotEmpty())
        <p>Viendo pagina {{$proveedores->currentPage()}} de {{$proveedores->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="">
                    <th scope="col">#</th>
                    <th scope="col"><a href="{{$sortable->url('nombre')}}" class="{{ $sortable->classes('nombre') }}">Nombre <i class="icon-sort"></i></a></th>
                    <th scope="col">Registro</th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proveedores as $i=>$proveedor)
                    @include('proveedores._row',['proveedor'=>$proveedor,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $proveedores->links()}}
        </div>
    @else
        <p>No hay proveedores registrados.</p>
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
                deleteproveedor:function (proveedor_id){
                    Swal.fire({
                        title: '¿Seguro que deseas desactivar este Proveedor?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Desactivarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/proveedor/delete',
                                method:'POST',
                                data:{
                                    'proveedor_id':proveedor_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire(
                                            'Desactivado!',
                                            'El Proveedor a sido Desactivado de Forma Exitosa.',
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



