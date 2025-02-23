@extends('layout')
@section('title', "Crear un Servicio Técnico")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('servicios.index')}}" class="link-dark">Servicio Técnico</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Nuevo Servicio Técnico')
    @include('shared._errors')
    <form method="POST" action="{{ url('servicio') }}" id="app">
        @include('servicios._fields')
        <div class="form-group mt-4" align="middle"> <!-- Botón de gurdar servicio tecnico y regresar al listado -->
            <button type="button" :disabled="!datos" class="btn btn-primary" @click="savedata()"><i class="bi bi-save-fill"></i> Guardar Servicio Técnico</button>
            <a href="{{ route('servicios.index') }}" class="btn btn-link">Regresar al Listado de Servicios Técnicos</a>
        </div>
    </form>
    @endcard
@endsection
@section('script')
    <script>
        Vue.config.debug=true
        Vue.config.devtools=true
        const app=new Vue({
            el:'#app',
            data: {
                tasa_dolar:{
                    price:0,
                    date:'',
                },
                serial:'',
                cantidad:1,
                producto:'',
                cliente_id:'',
                costo_unitario:0,
                costo_unitario_bs:0,
                falla:'',
                costo:false,
                total_dolar:0,
                total_bs:0,
                lista_servicio:{
                    productos:[],
                    cantidad:[],
                    serial:[],
                    falla:[],
                },
                datos:false,
                cont:0,


            },
            mounted() {
                this.setpreciodolar()
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
                setcostobs(){ //Función para el costo del servicio tecnico
                    this.costo_unitario_bs=(parseFloat(this.costo_unitario)*parseFloat(this.tasa_dolar.price)).toFixed(2)
                    this.total_dolar=(parseFloat(this.costo_unitario)*parseInt(this.cantidad)).toFixed(2)
                    this.total_bs=(parseFloat(this.total_dolar)*parseFloat(this.tasa_dolar.price)).toFixed(2)
                },
                agregarfila(){ //Función para agregar las filas
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
                        Swal.fire({ //Función para mostrar el mensaje de error
                            icon: "error",
                            title: "Error",
                            text: "Todos los campos deben estar llenos",
                        }).then((result)=>{
                            this.error=true
                        })
                    }

                },
                deletefila(indice){ //Función para eliminar la fila
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
                    if(this.costo===true){
                        this.costo=false
                        this.resetfields()

                    }else{
                        this.costo=true
                    }
                },
                savedata(){
                    $.ajax({
                        url:'/servicios',
                        method:'POST',
                        data:{
                            //FILAS
                            'productos':app.lista_servicio.productos,
                            'cantidad':app.lista_servicio.cantidad,
                            'serial':app.lista_servicio.serial,
                            'falla':app.lista_servicio.falla,
                            //COSTOS
                            'costo':app.costo,
                            'total_bs':app.total_bs,
                            'total_dolar':app.total_dolar,
                            'cliente_id':app.cliente_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            //console.log(data.costo)
                           if(data.status=== true){
                                Swal.fire({ //Función para mostrar mensaje de confirmación
                                    icon: "success",
                                    title: "Realizado",
                                    text: "Sercivio Técnico registrado exitosamente",
                                    confirmButtonText: 'Entendido',
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
                }
            },
            computed:{
            }
        })

    </script>

@endsection

