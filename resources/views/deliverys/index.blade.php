@extends('layout')

@section('title', 'Deliverys')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Deliverys</li>
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
            Lista de Entregas
        </h1>
    </div>

    @include('deliverys._filters')
    @if ($deliverys->isNotEmpty())
        <p>Viendo pagina {{$deliverys->currentPage()}} de {{$deliverys->lastPage()}}</p>
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app">
                <thead class="thead-dark">
                <tr class="">
                    <th scope="col">#</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Productos</th>
                    <th scope="col" class="text-center">Direccion</th>
                    <th scope="col"  class="text-center">Repartidor</th>
                    <th scope="col" class="text-center">Estatus</th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deliverys as $i=>$deliver)
                    @include('deliverys._row',['delivery'=>$deliver,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $deliverys->links()}}
        </div>
    @else
        <p>No hay Entregas Pendientes.</p>
    @endif
@endsection

@section('sidebar')
    @parent
@endsection
@section('script')
    <script>
        const app=new Vue({
            el:'#app',
            data: {
                repartidores:{
                    ids:[],
                    nombres:[],
                    status:false
                }
            },
            methods:{
                deletedelivery:function (delivery_id){
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar esta entrega?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Desactivarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/delivery/delete',
                                method:'POST',
                                data:{
                                    'delivery_id':delivery_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire(
                                            'Eliminado!',
                                            'La entrega a sido Desactivado de Forma Exitosa.',
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
                },
                asignarrepartidor( delivery_id) {
                    this.cargarrepartidores()
                    if(this.repartidores.status){
                        let array=this.repartidores.nombres
                        let Nombres=Array()
                        array.forEach(function (elemento,indice,array){
                            Nombres.push(elemento)
                        })
                        Swal.fire({
                            title: "Selecciona un Repartidor",
                            input: "select",
                            inputOptions: {
                                Nombres
                            },
                            inputPlaceholder: "Selecciona un Repatidor",
                            confirmButtonText:'Seleccionar',
                            showCancelButton: true,
                            inputValidator: (value) => {
                                if(!value){
                                    return 'Por favor debes seleccionar un Repartidor'
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                console.log(this.repartidores.ids[result.value])
                                let user_id=this.repartidores.ids[result.value]
                                Swal.fire({
                                    title: "Seguro que deseas agregar a " + this.repartidores.nombres[result.value] + " para la Entrega?",
                                    showDenyButton: true,
                                    showCancelButton: true,
                                    confirmButtonText: "Si",
                                    denyButtonText: `No`
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: '/delivery/update/repartidor',
                                            method: 'POST',
                                            data: {
                                                'user_id': user_id,
                                                'delivery_id':delivery_id,
                                                "_token": "{{ csrf_token() }}"
                                            },
                                            dataType: 'json',
                                            success: function (data) {
                                                if(data.status === true){
                                                    Swal.fire("Guardado!", "", "success");
                                                    location.reload()
                                                }
                                            },
                                            error: function (jqXHR) {
                                                console.log(jqXHR.responseJSON)
                                            }
                                        })

                                    } else if (result.isDenied) {
                                        Swal.fire("Cambios no Guardados", "", "info");
                                    }
                                });
                            }

                        })
                    }


                },
                cargarrepartidores() {
                    $.ajax({
                        url: '/delivery/repartidor',
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            //console.log(data.nombres)
                            app.repartidores.nombres = data.nombres
                            app.repartidores.ids = data.ids
                            app.repartidores.status=true
                        },
                        error: function (jqXHR) {
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                registrarentrega(user_id,delivery_id){
                    $.ajax({
                        url: '/delivery/registrar',
                        method: 'POST',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            'user_id':user_id,
                            'delivery_id':delivery_id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Registro Exitoso",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function (jqXHR) {
                            console.log(jqXHR.responseJSON)
                        }
                    })
                }
            },
            computed:{
            }
        })

    </script>

@endsection



