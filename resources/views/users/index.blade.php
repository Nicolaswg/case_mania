@extends('layout')

@section('title', 'Usuarios')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
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
            {{trans("users.title.{$view}")}}
        </h1>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-dark">Nuevo usuario</a>

        </p>
    </div>

    @includeWhen($view=='index','users._filters')
    @if ($users->isNotEmpty())
        <p>Viendo pagina {{$users->currentPage()}} de {{$users->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="">
                    <th scope="col">#</th>
                    <th scope="col"><a href="{{$sortable->url('name')}}" class="{{ $sortable->classes('name') }}">Nombre <i class="icon-sort"></i></a></th>
                    <th scope="col"><a href="{{$sortable->url('email')}}" class="{{ $sortable->classes('email') }}">Correo <i class="icon-sort"></i></a></th>
                    <th scope="col"><a href="{{$sortable->url('date')}}" class="{{ $sortable->classes('date') }}">Registro <i class="icon-sort"></i></a></th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @each('users._row', $users, 'user')
                </tbody>
            </table>

            {{ $users->links()}}
        </div>
    @else
        <p>No hay usuarios registrados.</p>
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
                deleteuser:function (user_id){
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar el Usuario?',
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



