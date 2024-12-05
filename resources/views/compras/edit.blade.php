@extends('layout')
@section('title', "Editar una Compra")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('compras.index')}}" class="link-dark">Compras</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar una Compra')
    @include('shared._errors')
    <form method="POST" action="{{ url('compras') }}" id="app">
        @include('compras._fields')
        <div class="form-group mt-4" align="middle">
            <button type="button" :disabled="(!datos || ini)"  class="btn btn-primary" @click="editardata()"><i class="bi bi-pencil"></i> Editar Factura</button>
            <a href="{{ route('compras.index') }}" class="btn btn-link">Regresar a Lista de Compras</a>
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
                categoria_id:'',
                productos_inicial:{
                    ids:[],
                    cantidad:[],
                },
                tasa_dolar:{
                    price:0,
                    date:'',
                },
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
                    subtotal:'',
                    iva:'',
                    total_factura:'',
                },
                tasa:0,
                index_producto:'',
                sucursal:<?php echo $compra->sucursal->id?>,
                cantidad:'',
                datos:false,
                cont:0,
                disabled:false,
                proveedor:'',
                precio_unitario:'',
                disabledprecio:false,
                error:false,
                ini:true,
                compra_id:<?php echo $compra->id?>
            },
            mounted() {
                this.cargardatoscompra()
                this.setpreciodolar()
                //this.calculofactura()
            },
            methods:{
                setpreciodolar() {
                    $.ajax({
                        url:'https://pydolarvenezuela-api.vercel.app/api/v1/dollar?page=bcv',
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
                selecproductos(){
                    $.ajax({
                        url:'/selecproducto',
                        method:'POST',
                        data:{
                            'categoria_id':app.categoria_id,
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
                            }
                        },
                        error:function (jqXHR){
                            console.log(jqXHR.responseJSON)
                        }
                    })
                },
                cargardatoscompra(){
                    $.ajax({
                        url:'/cargarproducto',
                        method:'POST',
                        data:{
                            'compra_id':this.compra_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType:'json',
                        success:function (data){
                            if(data){
                                app.productos_inicial.ids=data.ids
                                app.productos_inicial.cantidad=data.cantidad
                                //LISTA_COMPRAS
                                app.lista_compras.nombres=data.nombres
                                app.lista_compras.ids=data.ids
                                app.lista_compras.cantidad=data.cantidad
                                app.lista_compras.precio_unitario=data.precio_unitario
                                app.lista_compras.subtotal=data.subtotal
                                app.lista_compras.categoria=data.categorias_compra
                                app.lista_compras.photos=data.photos
                                app.lista_compras.subtotal_factura=data.subtotal_factura
                                app.lista_compras.iva=data.iva
                                app.lista_compras.total_factura=data.total_factura
                                app.tasa=data.tasa
                                app.proveedor=data.proveedor_id
                                app.cont=app.lista_compras.nombres.length
                                app.datos=true
                                app.calculofactura()



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
                agregarfila(){
                    let status=this.checkfields()
                    if(status){
                        this.datos=true
                        this.error=false
                        this.ini=false
                        let bandera=this.verificarigualesids()
                        if(bandera === false){
                            this.lista_compras.nombres[this.cont]=  this.productos.nombres[this.index_producto]
                            this.lista_compras.ids[this.cont]=  this.productos.ids[this.index_producto]
                            this.lista_compras.photos[this.cont]=  this.productos.photos[this.index_producto]
                            this.lista_compras.cantidad[this.cont]=  this.cantidad
                            this.lista_compras.precio_unitario[this.cont]=  this.precio_unitario
                            this.lista_compras.categoria[this.cont]=  this.productos.nombre_categoria
                            this.lista_compras.subtotal[this.cont]= parseInt( this.lista_compras.cantidad[this.cont]) * parseFloat( this.lista_compras.precio_unitario[this.cont])
                            this.cont=this.cont+1
                        }
                        this.calculofactura()
                        this.resetfields()
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "todos los campos deben estar llenos",
                            footer: '<span class="note">Estaran Subrallados de Color Rojo</span>'
                        }).then((result)=>{
                            this.error=true
                        })
                    }

                },
                deletefila(indice){
                    this.lista_compras.nombres.splice(indice,1)
                    this.lista_compras.ids.splice(indice,1)
                    this.lista_compras.cantidad.splice(indice,1)
                    this.lista_compras.precio_unitario.splice(indice,1)
                    this.lista_compras.subtotal.splice(indice,1)
                    this.lista_compras.categoria.splice(indice,1)
                    this.calculofactura()
                    this.cont=this.cont-1
                    this.ini=false
                    if (this.lista_compras.nombres.length === 0) {
                        this.datos = false
                    }

                },
                calculofactura(){
                    //console.log('entro aqui')
                    let acum=0
                    this.lista_compras.subtotal.forEach((subtotal, index)=>{
                            acum=parseFloat(acum)+parseFloat(subtotal)
                        }
                    );
                    this.lista_compras.subtotal_factura=parseFloat(acum).toFixed(2)
                    this.lista_compras.iva=(parseFloat(acum)*0.16).toFixed(2)
                    this.lista_compras.total_factura=(parseFloat(this.lista_compras.subtotal_factura) + parseFloat(this.lista_compras.iva)).toFixed(2)
                    //BS
                    if( this.lista_compras.subtotal_factura !== 0){
                        this.bs.subtotal= new Intl.NumberFormat('de-DE',{ style: 'currency', currency: 'BsF'}).format(parseFloat(this.lista_compras.subtotal_factura)*parseFloat(this.tasa_dolar.price))
                        this.bs.iva= new Intl.NumberFormat('de-DE',{ style: 'currency',currency: 'BsF'}).format((parseFloat(this.lista_compras.iva )* parseFloat(this.tasa_dolar.price)))
                        this.bs.total_factura=  new Intl.NumberFormat('de-DE',{ style: 'currency',currency: 'BsF' }).format((parseFloat(this.lista_compras.total_factura) * parseFloat(this.tasa_dolar.price)))
                    }
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
                            if(parseInt(id) === this.productos.ids[this.index_producto]){
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
                            if(parseInt(id) === this.productos.ids[this.index_producto]){
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
                editardata(){
                    Swal.fire({
                        title: "Seguro que quieres editar la Compra?",
                        showDenyButton: true,
                        showCancelButton: true,
                        icon:'info',
                        confirmButtonText: "Guardar",
                        cancelButtonText: "Cancelar",
                        allowOutsideClick:false,
                        denyButtonText: `No`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/compra/update',
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
                                    'sucursal_id':app.sucursal,
                                    'compra_id':app.compra_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data.status=== true){
                                        Swal.fire({
                                            icon: "success",
                                            title: "Exito",
                                            text: "Compra Modificada Exitosamente",
                                            confirmButtonText: 'Enterado',
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
                        } else if (result.isDenied) {
                            Swal.fire("Los cambios no se han Guardado", "", "info");
                        }
                    });
                }

            },
            computed:{
            }
        })

    </script>

@endsection
