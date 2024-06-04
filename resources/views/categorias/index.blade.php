@extends('layout')

@section('title', 'Categorias')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categorias</li>
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
            Lista de Categorias
        </h1>
        <p>
            <a href="{{ route('categorias.create') }}" class="btn btn-dark">Nueva Categoria</a>
        </p>
    </div>
    @if ($categorias->isNotEmpty())
        <p>Viendo pagina {{$categorias->currentPage()}} de {{$categorias->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="">
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Productos Asociados</th>
                    <th scope="col">Registro</th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorias as $i=>$categoria)
                    @include('categorias._row',['categoria'=>$categoria,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $categorias->links()}}
        </div>
    @else
        <p>No hay Categorias registrados.</p>
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
                deletecategoria:function (categoria_id){
                    Swal.fire({
                        title: '¿Seguro que deseas desactivar esta Categoria?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Desactivarla!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/categorias/delete',
                                method:'POST',
                                data:{
                                    'categoria_id':categoria_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire(
                                            'Desactivado!',
                                            'La categoria a sido Desactivado de Forma Exitosa.',
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



