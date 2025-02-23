@extends('layout')
@section('title', "Realizar una Venta")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('ventas.index')}}" class="link-dark">Ventas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Realizar Venta')
    @include('shared._errors')
    <form method="POST" action="{{ url('ventas') }}" id="app" >
        @include('ventas._fields')
        <div class="form-group mt-4" align="middle"> <!-- Botón para guardar la venta y regresar al listado -->
            <button type="button" :disabled="!datos || !checkdelivery()"  class="btn btn-primary" @click="savedata()"><i class="bi bi-save-fill"></i> Guardar Venta</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-link">Regresar al Listado de Ventas</a>
        </div>
    </form>
    @endcard
@endsection
@section('script')
    <script>
        Vue.filter('upper',function (value){
            return value.toUpperCase();
        })
        Vue.config.debug=true
        Vue.config.devtools=true
        const app=new Vue({
            el:'#app',
            data: {
                tasa_dolar:{
                    price:0,
                    date:'',
                },
                delivery:false,
                costo_delivery:'',
                costo_delivery_bs:'',
                direccion_delivery:'',
                referencia_delivery: '',
                categoria_id:'',
                productos:{
                    nombres:[],
                    ids:[],
                    photos:[],
                    precio_venta:[],
                    descripcion:[],
                    nombre_categoria:''
                },
                lista_venta:{
                    nombres:[],
                    ids:[],
                    cantidad:[],
                    precio_unitario:[],
                    subtotal:[],
                    categoria:[],
                    photos:[],
                    subtotal_factura:0,
                    iva:0,
                    total_factura:0,
                },
                bs:{
                    subtotal:0,
                    iva:0,
                    total_factura:0,
                },
                sucursal:<?php echo auth()->user()->profile->sucursal->id?>,
                index_producto:'', //ID_PRODUCTO
                cantidad:'',
                datos:false,
                cont:0,
                disabled:false,
                cliente:'',
                disabledprecio:false,
                error:false,
                errormax:false,
                maximo_producto:'',
                producto_nombre:'',
            },
            mounted() {
                this.setpreciodolar()
            },
            methods:{
                checkdelivery(){ //Función para revisar el estado del servicio a domicilio
                    if(this.delivery){
                        if(this.direccion_delivery === '' || this.referencia_delivery === '' || this.costo_delivery === '' ){
                            return false
                        }else{
                            return true
                        }
                    }else{
                        return true
                    }
                },
                configdelivery(){ //Función para configurar el servicio a domicilio
                    if(this.delivery){
                        this.delivery=false
                        this.costo_delivery=''
                        this.direccion_delivery=''
                        this.referencia_delivery=''
                    }else{
                        this.delivery=true
                    }
                    this.delivery = this.delivery !== true;
                },
                setcostodelivery(){
                    this.costo_delivery_bs= new Intl.NumberFormat('de-DE',{ style: 'currency', currency: 'BsF'}).format(parseFloat(this.costo_delivery)*parseFloat(this.tasa_dolar.price))
                },
                setpreciodolar() {
                    $.ajax({
                        url:'https://pydolarve.org/api/v1/dollar?page=bcv', //Función para obtener el valor del servicio a domicilio
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
                selecproductos(){ //Función para seleccionar los productos
                    $.ajax({
                        url:'/selecproducto',
                        method:'POST',
                        data:{
                            'categoria_id':app.categoria_id,
                            'sucursal_id':app.sucursal,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            if(data){
                                app.productos.nombres=data.nombres
                                app.productos.descripcion=data.descripcion
                                app.productos.ids=data.ids
                                app.productos.photos=data.photos
                                app.productos.nombre_categoria=data.nombre_categoria
                                app.productos.precio_venta=data.precio_venta
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                verificarproducto(){ //Función para verificar la cantidad del producto
                    $.ajax({
                        url:'/verificarmaxproducto',
                        method:'POST',
                        data:{
                            'producto_id':app.productos.ids[this.index_producto],
                            'sucursal_id':app.sucursal,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            if(data.status === true){
                                app.maximo_producto=data.maximo
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                verifimax(){ //Función para verificar la cantidad máxima del producto y que no se pase de dicha cantidad al momento de hacer la venta
                    let adicional=0
                    this.lista_venta.ids.forEach((id, index)=>{
                        if(id === this.productos.ids[this.index_producto]){
                             adicional= parseInt(this.lista_venta.cantidad[index]) + parseInt(this.cantidad)
                        }
                    })
                    if(adicional === 0){
                        if((this.cantidad) > this.maximo_producto){
                            this.error=true
                            this.errormax=true
                        }else{
                            this.error=false
                            this.errormax=false
                        }
                    }else{
                        if((adicional) > this.maximo_producto){
                            this.error=true
                            this.errormax=true
                        }else{
                            this.error=false
                            this.errormax=false
                        }
                    }

                },
                checkfields() {
                    if(this.cantidad === '' || this.index_producto === ''  || this.cliente === '' || this.errormax=== true){
                        this.disabled=true
                        return false
                    }else{
                        return true
                    }
                },
                agregarfila(){ //Función para agregar las filas de los productos
                    let status=this.checkfields()
                    if(status){
                        this.datos=true
                        this.error=false
                        let bandera=this.verificarigualesids()
                        //let bandera=false
                        if(bandera === false){
                            this.lista_venta.nombres[this.cont]=  this.productos.nombres[this.index_producto]
                            this.lista_venta.ids[this.cont]=  this.productos.ids[this.index_producto]
                            this.lista_venta.photos[this.cont]=  this.productos.photos[this.index_producto]
                            this.lista_venta.cantidad[this.cont]=  this.cantidad
                            this.lista_venta.precio_unitario[this.cont]=  this.productos.precio_venta[this.index_producto]
                            this.lista_venta.categoria[this.cont]=  this.productos.nombre_categoria
                            this.lista_venta.subtotal[this.cont]= parseInt( this.lista_venta.cantidad[this.cont]) * parseFloat( this.lista_venta.precio_unitario[this.cont])
                            this.calculofactura()
                            this.cont=this.cont+1
                        }
                        this.resetfields()
                    }else{
                        Swal.fire({ //Función para aviso de error en la venta
                            icon: "error",
                            title: "Error",
                            text: "Verifica que los campos no contengan un Error",
                            footer: '<span class="note">Estaran Subrallados de Color Rojo</span>'
                        }).then((result)=>{
                           this.error=true
                        })
                    }

                },
                verificarigualesids() {
                    let band=false
                    this.lista_venta.ids.forEach((id, index)=>{
                            if(id === this.productos.ids[this.index_producto]){
                                this.lista_venta.cantidad[index]=    parseInt(this.lista_venta.cantidad[index]) + parseInt(this.cantidad)
                                this.lista_venta.subtotal[index]=   parseFloat(this.lista_venta.subtotal[index]) +( parseInt(this.cantidad)*this.productos.precio_venta[index])
                                band=true
                            }
                        }
                    );
                    this.calculofactura()
                    return band
                },
                calculofactura(){ //Función para el cálculo de la factura
                    let acum=0
                    this.lista_venta.subtotal.forEach((subtotal, index)=>{
                            acum=acum+subtotal
                        }
                    );
                    this.lista_venta.subtotal_factura=acum
                    this.lista_venta.iva=(acum*0.16).toFixed(2)
                    this.lista_venta.total_factura=(parseFloat(this.lista_venta.subtotal_factura) +  parseFloat(this.lista_venta.iva)).toFixed(2)
                    //AUXILIARES BS
                    this.bs.subtotal= new Intl.NumberFormat('de-DE',{ style: 'currency', currency: 'BsF'}).format(parseFloat(this.lista_venta.subtotal)*parseFloat(this.tasa_dolar.price))
                    this.bs.iva= new Intl.NumberFormat('de-DE',{ style: 'currency',currency: 'BsF'}).format((parseFloat(this.lista_venta.iva )* parseFloat(this.tasa_dolar.price)))
                    this.bs.total_factura=  new Intl.NumberFormat('de-DE',{ style: 'currency',currency: 'BsF' }).format((parseFloat(this.lista_venta.total_factura) * parseFloat(this.tasa_dolar.price)))
                },
                deletefila(indice){ //Función para eliminar la fila
                    this.lista_venta.nombres.splice(indice,1)
                    this.lista_venta.ids.splice(indice,1)
                    this.lista_venta.cantidad.splice(indice,1)
                    this.lista_venta.precio_unitario.splice(indice,1)
                    this.lista_venta.subtotal.splice(indice,1)
                    this.lista_venta.categoria.splice(indice,1)
                    this.lista_venta.photos.splice(indice,1)
                    this.calculofactura()
                    this.cont=this.cont-1
                    if (this.lista_venta.nombres.length === 0) {
                        this.datos = false
                    }

                },
                resetfields() {
                    this.cantidad=''
                    this.index_producto=''
                    this.categoria_id=''
                },
                savedata(){
                    $.ajax({
                        url:'/ventas',
                        method:'POST',
                        data:{
                            'nombre_productos':app.lista_venta.nombres,
                            'ids_productos':app.lista_venta.ids,
                            'cantidad_productos':app.lista_venta.cantidad,
                            'precio_productos':app.lista_venta.precio_unitario,
                            'subtotal_productos':app.lista_venta.subtotal,
                            'categoria_productos':app.lista_venta.categoria,
                            'subtotal_factura':app.lista_venta.subtotal_factura,
                            'iva_factura':app.lista_venta.iva,
                            'total_factura':app.lista_venta.total_factura,
                            'cliente_id':app.cliente,
                            'photos_productos':app.lista_venta.photos,
                            'tasa':app.tasa_dolar.price,
                            'sucursal_id':app.sucursal,
                            //DELIVERY
                            'delivery':app.delivery,
                            'direccion_delivery':app.direccion_delivery,
                            'referencia_delivery':app.referencia_delivery,
                            'costo_delivery':app.costo_delivery,
                            //TOKEN
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            if(data.status=== true){
                                Swal.fire({ //Función para la confirmación de la venta
                                    icon: "success",
                                    title: "Realizado",
                                    text: "Venta registrada exitosamente",
                                    confirmButtonText: 'Enterado',
                                    allowOutsideClick:false,
                                    footer: '<a class="note" href="/ventas/nueva">Deseas Agregar otra venta?</a>'
                                }).then((result)=>{
                                    if(result.isConfirmed){
                                        window.location.href = '/ventas'
                                    }
                                })
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                validar(){

                }

            },
            computed:{
            }
        })

    </script>

@endsection
