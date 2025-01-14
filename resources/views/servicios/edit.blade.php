@extends('layout')
@section('title', "Editar Servicio")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('servicios.index')}}" class="link-dark">Servicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Servicio Técnico')
    @include('shared._errors')
    <form method="POST" action="{{ url('servicio') }}" id="app">
        @include('servicios._fields')
        <div class="form-group mt-4" align="middle"> <!-- Botones de actuliazar servicio tecnico y regresar al listado -->
            <button type="button" :disabled="!datos || ini" class="btn btn-primary" @click="editdata()"><i class="bi bi-arrow-repeat"></i> Actualizar Servicio Ténico</button>
            <a href="{{ route('servicios.index') }}" class="btn btn-link">Regresar al Listado de Servicios Técnicos</a>
        </div>
    </form>
    @endcard
@endsection
@section('script')
    <script>
        Vue.filter('upper',function (value){
            return value.toUpperCase();
        })

        const app=new Vue({
            el:'#app',
            data: {
                tasa_dolar:{
                    price:0,
                    date:'',
                },
                serial:'',
                cantidad:1,
                ini:true,
                producto:'',
                cliente_id:<?php echo $servicio->cliente->id?>,
                costo_unitario:<?php echo $servicio->costo_dolar?>,
                costo_unitario_bs:<?php echo $servicio->costo_bolivar?>,
                servicio_id:<?php echo $servicio->id?>,
                falla:'',
                costo:<?php echo $costo?>,
                total_dolar:<?php echo $servicio->costo_dolar?>,
                total_bs:<?php echo $servicio->costo_bolivar?>,
                lista_servicio:{
                    productos:<?php echo $productos?>,
                    cantidad:<?php echo $cantidad?>,
                    serial:<?php echo $serial?>,
                    falla:<?php echo $fallas?>,
                },
                datos:true,
                cont:<?php echo $cont?>,


            },
            mounted() {
                this.setpreciodolar()
                //this.cargardatosservicio()
            },
            methods:{
                setpreciodolar() {
                    $.ajax({
                        url:'https://pydolarvenezuela-api.vercel.app/api/v1/dollar', //Función para obtener el valor del BCV
                        method:'GET',
                        dataType:'json',
                        success:function (data){
                            if(data){
                                app.tasa_dolar.price=data.monitors.bcv.price
                                app.tasa_dolar.date=data.datetime.date
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                setcostobs(){ //Función para obtener el costo del servicio técnico
                    this.ini=false
                    this.costo_unitario_bs=(parseFloat(this.costo_unitario)*parseFloat(this.tasa_dolar.price)).toFixed(2)
                    this.total_dolar=(parseFloat(this.costo_unitario)*parseInt(this.cantidad)).toFixed(2)
                    this.total_bs=(parseFloat(this.total_dolar)*parseFloat(this.tasa_dolar.price)).toFixed(2)
                },
                agregarfila(){ //Función para agregar las filas
                    this.ini=false
                    let status=this.checkfields()
                    if(status){
                        this.datos=true
                        this.error=false
                        this.lista_servicio.productos[this.cont]=  this.producto
                        this.lista_servicio.cantidad[this.cont]=  this.cantidad
                        this.lista_servicio.serial[this.cont]=  this.serial
                        this.lista_servicio.falla[this.cont]=  this.falla
                        this.cont=this.cont+1
                        this.resetfields()
                    }else{
                        Swal.fire({ //Función para dar mensaje de error
                            icon: "error",
                            title: "Error",
                            text: "Todos los campos deben estar llenos",
                        }).then((result)=>{
                            this.error=true
                        })
                    }

                },
                deletefila(indice){ //Función para eliminar fila
                    this.ini=false
                    this.lista_servicio.productos.splice(indice,1)
                    this.lista_servicio.cantidad.splice(indice,1)
                    this.lista_servicio.serial.splice(indice,1)
                    this.lista_servicio.falla.splice(indice,1)
                    this.cont=this.cont-1
                    if (this.lista_servicio.productos.length === 0) {
                        this.datos = false
                    }
                },
                resetfields() {
                    this.cantidad=1
                    this.producto=''
                    this.serial=''
                    this.costo_unitario_bs=''
                    this.costo_unitario=''
                    this.total_bs=0
                    this.total_dolar=0
                    this.falla=''
                },
                checkfields() {
                    if(this.cantidad === '' || this.serial === ''  || this.cliente === '' || this.producto=== true){
                        //this.disabled=true
                        return false
                    }else{
                        return true
                    }
                },
                config(){
                    this.ini=false
                    if(this.costo===true){
                        this.costo=false
                        this.resetfields()

                    }else{
                        this.costo=true
                    }
                },
                editdata(){
                    $.ajax({
                        url:'/servicios/update',
                        method:'POST',
                        data:{
                            'servicio_id':app.servicio_id,
                            //FILAS
                            'productos':app.lista_servicio.productos,
                            'cantidad':app.lista_servicio.cantidad,
                            'serial':app.lista_servicio.serial,
                            'falla':app.lista_servicio.falla,
                            //COSTOS
                            'costo':app.costo,
                            'total_bs':parseFloat(app.total_bs),
                            'total_dolar':parseFloat(app.total_dolar),
                            'cliente_id':app.cliente_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            //console.log(data.costo)
                            if(data.status=== true){
                                Swal.fire({ //Función para mostrar mensajes de confirmación
                                    icon: "success",
                                    title: "Realizado",
                                    text: "Servicio Técnico actualizado exitosamente",
                                    confirmButtonText: 'Enterado',
                                    allowOutsideClick:false,
                                    footer: '<a class="note" href="/servicio/nuevo">Deseas Agregar otro servicio?</a>'
                                }).then((result)=>{
                                    if(result.isConfirmed){
                                        window.location.href = '/servicio'
                                    }
                                })
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                cargardatosservicio() {
                    $.ajax({
                        url:'/cargarservicio',
                        method:'POST',
                        data:{
                            'venta_id':this.venta_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            if(data){
                                //LISTA VENTA
                                app.lista_venta.nombres=data.nombres
                                app.lista_venta.ids=data.ids
                                app.lista_venta.cantidad=data.cantidad
                                app.lista_venta.precio_unitario=data.precio_unitario
                                app.lista_venta.subtotal=data.subtotal
                                app.lista_venta.categoria=data.categorias_venta
                                app.lista_venta.photos=data.photos
                                app.lista_venta.subtotal_factura=data.subtotal_factura
                                app.lista_venta.iva=data.iva
                                app.lista_venta.total_factura=data.total_factura
                                app.cliente=data.cliente_id
                                app.cont=app.lista_venta.nombres.length
                                app.calculofactura()
                                //DELIVERY
                                app.delivery=data.delivery
                                app.referencia_delivery=data.referencia_delivery
                                app.direccion_delivery=data.direccion_delivery
                                app.costo_delivery=data.costo_delivery
                                app.costo_delivery_bs=data.costo_delivery_bs
                                app.datos=true

                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                }

            },
            computed:{
            },

        })

    </script>


@endsection
