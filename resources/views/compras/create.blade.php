@extends('layout')
@section('title', "Registrar Compra")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('compras.index')}}" class="link-dark">Compras</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Registrar Compra')
    @include('shared._errors')
    <form method="POST" action="{{ url('compras') }}" id="app" >
        @include('compras._fields')
        <div class="form-group mt-4" align="middle"> <!-- Botón de guardar compra y regresar al listado -->
            <button type="button" :disabled="!datos"  class="btn btn-primary" @click="savedata()"><i class="bi bi-save-fill"></i> Guardar Orden de Compra</button>
            <a href="{{ route('compras.index') }}" class="btn btn-link">Regresar al Listado de Compras</a>
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
                categoria_id:'',
                categoria_nombre:'',
                productos:{
                    nombres:[],
                    ids:[],
                    photos:[],
                    nombre_categoria:''
                },
                lista_compras:{
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
                index_producto:'',
                sucursal:<?php echo auth()->user()->profile->sucursal->id?>,
                cantidad:'',
                datos:false,
                cont:0,
                disabled:false,
                proveedor:'',
                precio_unitario:'',
                disabledprecio:false,
                error:false,
            },
            mounted() {
                this.setpreciodolar()
            },
            methods:{
                setpreciodolar() {
                    $.ajax({
                        url:'https://pydolarve.org/api/v1/dollar?page=bcv', //Función para obtener el valor del BCV
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
                console.log(this.proveedor)
                    $.ajax({
                        url:'/selecproducto',
                        method:'POST',
                        data:{
                            'proveedor_id':app.proveedor,
                            'sucursal_id':app.sucursal,
                            'tipo':'compras',
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            if(data){

                                app.productos.nombres=data.nombres
                                app.productos.ids=data.ids
                                app.productos.photos=data.photos
                                app.productos.nombre_categoria=data.nombre_categoria
                                console.log( app.productos.nombres)
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                verificarproducto(){
                    this.disabledprecio = this.verificarigualesids2();
                },
                agregarfila(){ //Función para agregar la fila
                    let status=this.checkfields()
                    if(status){
                        this.datos=true
                        this.error=false
                        let bandera=this.verificarigualesids()
                        if(bandera === false){
                            this.lista_compras.nombres[this.cont]=  this.productos.nombres[this.index_producto]
                            this.lista_compras.ids[this.cont]=  this.productos.ids[this.index_producto]
                            this.lista_compras.photos[this.cont]=  this.productos.photos[this.index_producto]
                            this.lista_compras.cantidad[this.cont]=  this.cantidad
                            this.lista_compras.precio_unitario[this.cont]=  this.precio_unitario
                            this.lista_compras.categoria[this.cont]=  this.productos.nombre_categoria
                            this.lista_compras.subtotal[this.cont]= parseInt( this.lista_compras.cantidad[this.cont]) * parseFloat( this.lista_compras.precio_unitario[this.cont])
                            this.calculofactura()
                            this.cont=this.cont+1
                        }
                        this.resetfields()
                    }else{
                        Swal.fire({ //Función para el mensaje de error
                            icon: "error",
                            title: "Error",
                            text: "Todos los campos deben estar llenos",
                            footer: '<span class="note">Estaran Subrallados de Color Rojo</span>'
                        }).then((result)=>{
                           this.error=true
                        })
                    }

                },
                deletefila(indice){ //Función para eliminar la fila
                    this.lista_compras.nombres.splice(indice,1)
                    this.lista_compras.ids.splice(indice,1)
                    this.lista_compras.cantidad.splice(indice,1)
                    this.lista_compras.precio_unitario.splice(indice,1)
                    this.lista_compras.subtotal.splice(indice,1)
                    this.lista_compras.categoria.splice(indice,1)
                    this.lista_compras.photos.splice(indice,1)
                    this.calculofactura()
                    this.cont=this.cont-1
                    if (this.lista_compras.nombres.length === 0) {
                        this.datos = false
                    }

                },
                calculofactura(){ //Función para el cálculo de la factura
                    let acum=0
                    this.lista_compras.subtotal.forEach((subtotal, index)=>{
                            acum=acum+subtotal
                        }
                    );
                    this.lista_compras.subtotal_factura=acum.toFixed(2)
                    this.lista_compras.iva=(acum*0.16).toFixed(2)
                    this.lista_compras.total_factura=(parseFloat(this.lista_compras.subtotal_factura) +  parseFloat(this.lista_compras.iva)).toFixed(2)
                    //AUXILIARES BS
                    this.bs.subtotal= new Intl.NumberFormat('de-DE',{ style: 'currency', currency: 'BsF'}).format(parseFloat(this.lista_compras.subtotal)*parseFloat(this.tasa_dolar.price))
                    this.bs.iva= new Intl.NumberFormat('de-DE',{ style: 'currency',currency: 'BsF'}).format((parseFloat(this.lista_compras.iva )* parseFloat(this.tasa_dolar.price)))
                    this.bs.total_factura=  new Intl.NumberFormat('de-DE',{ style: 'currency',currency: 'BsF' }).format((parseFloat(this.lista_compras.total_factura) * parseFloat(this.tasa_dolar.price)))
                },
                resetfields() {
                    this.cantidad=''
                    this.index_producto=''
                    this.categoria_id=''
                    this.precio_unitario=''
                },
                verificarigualesids2() {
                    let band=false
                    this.lista_compras.ids.forEach((id, index)=>{
                            if(id === this.productos.ids[this.index_producto]){
                                this.precio_unitario= this.lista_compras.precio_unitario[index]
                                band=true
                            }
                        }
                    );
                    return band
                },
                verificarigualesids() {
                    let band=false
                    this.lista_compras.ids.forEach((id, index)=>{
                        if(id === this.productos.ids[this.index_producto]){
                            this.lista_compras.cantidad[index]=    parseInt(this.lista_compras.cantidad[index]) + parseInt(this.cantidad)
                            this.lista_compras.subtotal[index]=   parseFloat(this.lista_compras.subtotal[index]) +( parseInt(this.cantidad) * parseFloat(this.precio_unitario))
                            band=true
                        }
                    }

                    );
                    this.calculofactura()
                    return band


                },
                checkfields() {
                    if(this.cantidad === '' || this.index_producto === '' || this.precio_unitario === '' || this.proveedor === ''){
                        this.disabled=true
                        return false
                    }else{
                        return true
                    }
                },
                savedata(){
                    $.ajax({
                        url:'/compras',
                        method:'POST',
                        data:{
                            'nombre_productos':app.lista_compras.nombres,
                            'ids_productos':app.lista_compras.ids,
                            'cantidad_productos':app.lista_compras.cantidad,
                            'precio_productos':app.lista_compras.precio_unitario,
                            'subtotal_productos':app.lista_compras.subtotal,
                            'categoria_productos':app.lista_compras.categoria,
                            'subtotal_factura':app.lista_compras.subtotal_factura,
                            'iva_factura':app.lista_compras.iva,
                            'total_factura':app.lista_compras.total_factura,
                            'proveedor_id':app.proveedor,
                            'photos_productos':app.lista_compras.photos,
                            'tasa':app.tasa_dolar.price,
                            'sucursal_id':app.sucursal,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            if(data.status=== true){
                               Swal.fire({ //Función para dar un mensaje cuando se registre la compra
                                    icon: "success",
                                    title: "Realizado",
                                    text: "Compra Registrada Exitosamente",
                                    confirmButtonText: 'Entendido',
                                    allowOutsideClick:false,
                                    footer: '<a class="note" href="/compras/nueva">Deseas Agregar otra compra?</a>'
                                }).then((result)=>{
                                    if(result.isConfirmed){
                                        window.location.href = '/compras'
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
