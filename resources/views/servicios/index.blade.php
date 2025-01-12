@extends('layout')

@section('title', 'Servicios Técnicos')
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Servicio Técnico</li>
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
            Servicios Técnicos
        </h1>
        <p> <!-- Botón para registrar nuevo servicio técnico -->
        <a href="{{ route('servicios.create') }}" class="btn btn-primary bi bi-plus-lg"> Regisitrar Nuevo Servicio Técnico</a>
        </p>
    </div>

    @include('servicios._filters') <!-- Filtros -->
    @if ($servicios->isNotEmpty())
        <p>Viendo Página {{$servicios->currentPage()}} de {{$servicios->lastPage()}}</p> <!-- Paginación -->
        <div class="table-responsive-lg">
            <table class="table table-sm table-bordered" id="app"> <!-- Subtítulos de la tabla -->
                <thead class="thead-dark">
                <tr class="">
                    <!-- <th scope="col">#</th> -->
                    <th scope="col" class="text-center">Cliente</th>
                    <th scope="col" class="text-center">Datos de Recepción</th>
                    <th scope="col" class="text-center">Productos</th>
                    <th scope="col" class="text-center">Cantidad</th>
                    <th scope="col" colspan="2" class="text-center">Falla Registrada</th>
                    <th scope="col" class="text-center">Estado</th>
                    <th scope="col" class="text-center">Datos del Recibo</th>
                    <th scope="col" class="text-center th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servicios as $i=>$servicio)
                    @include('servicios._row',['servicio'=>$servicio,'i'=>$i])
                @endforeach
                </tbody>
            </table>

            {{ $servicios->links()}}
        </div>
        <div class="pt-4 text-center">
        <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio</a>
        </div>
    @else
        <p>No hay Servicios registrados.</p>
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
                tasa_dolar:{
                    price:0,
                    date:'',
                },
                costo_dolar:0,
                costo_bs:0,
            },

            mounted() {
                this.setpreciodolar()
            },
            methods:{
                deleteservicio:function (servicio_id){
                    Swal.fire({ //Función para confirmar eliminar el servicio técnico
                        title: '¿Seguro que deseas eliminar este Servicio Técnico?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/servicio/delete',
                                method:'POST',
                                data:{
                                    'servicio_id':servicio_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire(
                                            'Eliminado',
                                            'El Servicio ha sido eliminado exitosamente',
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
                setpreciodolar() {
                    $.ajax({
                        url:'https://pydolarvenezuela-api.vercel.app/api/v1/dollar?page=bcv', //Función para obtener el valor del BCV
                        method:'GET',
                        dataType:'json',
                        success:function (data){
                            if(data){
                                app.tasa_dolar.price=data.monitors.usd.price
                                app.tasa_dolar.date=data.datetime.date
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                async setcosto(servicio_id) { //Función para anexar el costo desde la lista de los servicios
                    const {value: formValues} = await Swal.fire({
                        title: "Ingresa el Costo del Servicio ($)",
                        html: `
                            <input id="swal-input1"  type="number" min="1" class="form-control text-center"  name="costo_dolar">
                           `,
                        showCancelButton: true,
                        preConfirm: () => {
                            return [
                                document.getElementById("swal-input1").value,
                            ]
                        }

                    });
                    if (formValues) {
                       //console.log(formValues[0])
                        this.costo_dolar=formValues[0]
                        this.costo_bs=(parseFloat(this.costo_dolar) * parseFloat(this.tasa_dolar.price)).toFixed(2)
                        $.ajax({
                            url:'/servicios/recibo/update',
                            method:'POST',
                            data:{
                                //COSTOS
                                'total_bs':app.costo_bs,
                                'total_dolar':app.costo_dolar,
                                'servicio_id':servicio_id,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType:'json',
                            success:function (data){
                              //  console.log(data.servicio)
                               if(data.status=== true){
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Guardado",
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then((result)=>{
                                        if(result){
                                            window.location.href = '/servicio'
                                        }
                                    })
                                }
                            },
                            error:function (jqXHR){
                                console.log(jqXHR.responseJSON)
                            }
                        })
                    }
                },
                changestatus(servicio_id){ //Función para cambiar el estado a "Entregado"
                    Swal.fire({
                        title: '¿Seguro que deseas cambiar el estatus del servicio a : Entregado?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Cambiar a "Entregado"'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/servicio/changestatus',
                                method:'POST',
                                data:{
                                    'servicio_id':servicio_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data.status=== true){
                                        Swal.fire( //Función para confirmación de cambio de estado
                                            'Realizado',
                                            'Cambio de estado a "Entregado" realizado exitosamente',
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



            },
            computed:{
            }
        })

    </script>

@endsection



