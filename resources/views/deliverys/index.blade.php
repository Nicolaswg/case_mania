@extends('layout')

@section('title', 'Servicios a Domicilio')
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Servicios a Domicilio</li>
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
            Lista de Entregas (Deliverys)
        </h1>
    </div>

    @include('deliverys._filters') <!-- Filtros -->
    @if ($deliverys->isNotEmpty())
        <p>Viendo Página {{$deliverys->currentPage()}} de {{$deliverys->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm" id="app"> <!-- Subtítulos de la tabla -->
                <thead class="thead-dark">
                <tr class="">
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">Cliente</th>
                    <th scope="col" class="text-center">Productos a Enviar</th>
                    <th scope="col" class="text-center">Dirección</th>
                    <th scope="col"  class="text-center">Repartidor</th>
                    <th scope="col" class="text-center">Estado</th>
                    @if( auth()->user()->isAdmin() || auth()->user()->isVendedor() || auth()->user()->isServicio() )
                        <th scope="col" class="text-center th-actions">Acciones</th>
                    @endif
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
        <div class="pt-2 text-center"> <!-- Botón para volver al inicio -->
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
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
                    Swal.fire({ //Función para mostrar confirmación de eliminar servicio a domicilio
                        title: '¿Seguro que deseas eliminar esta entrega?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar'
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
                                        Swal.fire( //Función para mostrar confirmación
                                            'Eliminado!',
                                            'La entrega ha sido eliminada exitosamente',
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
                asignarrepartidor( delivery_id) { //Función para asignar repartidor
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
                                    return 'Por favor, debes seleccionar a un Repartidor'
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                console.log(this.repartidores.ids[result.value])
                                let user_id=this.repartidores.ids[result.value]
                                Swal.fire({
                                    title: "¿Seguro que deseas agregar a " + this.repartidores.nombres[result.value] + " para la Entrega?",
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
                cargarrepartidores() { //Función para cargar los repartidores
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
                registrarentrega(user_id,delivery_id){ //Función para el registro de la entrega
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



