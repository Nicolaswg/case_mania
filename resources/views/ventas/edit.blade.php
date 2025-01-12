@extends('layout')
@section('title', "Editar una Venta")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('ventas.index')}}" class="link-dark">Ventas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Venta')
    @include('shared._errors')
    <form method="POST" action="{{ url('ventas') }}" id="app">
        @include('ventas._fields')
        <div class="form-group mt-4" align="middle"> <!-- Botón de editar venta y regresar al listado -->
            <button type="button" :disabled="(!datos || ini)"  class="btn btn-primary" @click="editardata()"><i class="bi bi-pencil"></i> Editar Venta</button>
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

        const app=new Vue({
            el:'#app',
            data: {
                tasa_dolar:{
                    price:0,
                    date:'',
                },
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
                venta_id:<?php echo $venta->id?>,
                delivery:'',
                costo_delivery:'',
                direccion_delivery:'',
                referencia_delivery:'',
                costo_delivery_bs:'',
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
                ini:true,
            },
            mounted() {
                this.setpreciodolar()
                this.cargardatosventa()
            },
            methods:{
                checkdelivery(){ //Función para verificar el estado del servicio a domicilio
                    if(this.delivery){
                        if(this.direccion_delivery === '' || this.referencia_delivery === '' || this.costo_delivery === '' ){
                            this.ini=true
                            return false
                        }else{
                            this.ini=false
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
                        this.ini=false
                    }else{
                        this.delivery=true
                        this.ini=false
                    }
                    this.delivery = this.delivery !== true;
                },
                setcostodelivery(){
                    this.ini=false
                    if(this.delivery){
                        this.costo_delivery_bs= new Intl.NumberFormat('de-DE',{ style: 'currency', currency: 'BsF'}).format(parseFloat(this.costo_delivery)*parseFloat(this.tasa_dolar.price))
                    }else{
                        this.costo_delivery_bs=''
                    }

                },
                cargardatosventa(){ //Función para actualizar los datos de la venta
                    $.ajax({
                        url:'/cargarventa',
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
                selecproductos(){ //Función para seleccionar los productos de la venta
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
                verifimax(){ //Función para verificar la cantidad máxima del producto
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
                agregarfila(){ //Función para agregar filas
                    let status=this.checkfields()
                    if(status){
                        this.datos=true
                        this.error=false
                        this.ini=false
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
                        Swal.fire({ //Función para dar mensaje de error
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
                            if(parseInt(id) === this.productos.ids[this.index_producto]){
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
                            acum=acum+parseFloat(subtotal)
                        }
                    );
                    this.lista_venta.subtotal_factura=acum.toFixed(2)
                    this.lista_venta.iva=(acum*0.16).toFixed(2)
                    this.lista_venta.total_factura=(parseFloat(this.lista_venta.subtotal_factura) +  parseFloat(this.lista_venta.iva)).toFixed(2)
                    if(this.lista_venta.subtotal_factura !== 0) {
                        this.bs.subtotal = new Intl.NumberFormat('de-DE', {
                            style: 'currency',
                            currency: 'BsF'
                        }).format(parseFloat(this.lista_venta.subtotal) * parseFloat(this.tasa_dolar.price))
                        this.bs.iva = new Intl.NumberFormat('de-DE', {
                            style: 'currency',
                            currency: 'BsF'
                        }).format((parseFloat(this.lista_venta.iva) * parseFloat(this.tasa_dolar.price)))
                        this.bs.total_factura = new Intl.NumberFormat('de-DE', {
                            style: 'currency',
                            currency: 'BsF'
                        }).format((parseFloat(this.lista_venta.total_factura) * parseFloat(this.tasa_dolar.price)))
                    }
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
                    this.ini=false
                    if (this.lista_venta.nombres.length === 0) {
                        this.datos = false
                    }

                },
                resetfields() {
                    this.cantidad=''
                    this.index_producto=''
                    this.categoria_id=''
                },
                editardata(){ //Función para confirmar los cambios de la venta
                    Swal.fire({
                        title: "Seguro que quieres editar la Venta?",
                        showDenyButton: true,
                        showCancelButton: true,
                        icon:'info',
                        confirmButtonText: "Si, Guardar",
                        cancelButtonText: "Cancelar",
                        allowOutsideClick:false,
                        denyButtonText: `No`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/venta/update',
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
                                    'sucursal_id':app.sucursal,
                                    'venta_id':app.venta_id,
                                    'tasa_bcv':app.tasa_dolar.price,
                                    //DELIVERY
                                    'delivery':app.delivery,
                                    'direccion_delivery':app.direccion_delivery,
                                    'referencia_delivery':app.referencia_delivery,
                                    'costo_delivery':app.costo_delivery,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data.status=== true){
                                        console.log(data.delivery)
                                        Swal.fire({ //Función para confirmación de cambios en la venta
                                            icon: "success",
                                            title: "Realizado",
                                            text: "Venta modificada exitosamente",
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
                        } else if (result.isDenied) {
                            Swal.fire("Los cambios no se han Guardado", "", "info");
                        }
                    });
                },

            },
            computed:{
            }
        })

    </script>


@endsection
