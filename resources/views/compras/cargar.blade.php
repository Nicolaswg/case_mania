@extends('layout')
@section('title', 'Cargar Factura')
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('compras.index')}}" class="link-dark">Compras</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cargar Factura</li>
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
    @card
    @slot('header', 'Cargar Productos')
    <div class="row mb-2" align="center" id="app">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center d-inline"> <!-- Seleccionar el número de la factura -->
            <label for=""><strong>Seleccionar Factura: </strong></label>
            <select name="compra" id="compra" v-model="compra" @change.prevent="selecdata()" class="form-control text-center @if( $errors->get('compra')) field-error @endif">
                <option value="" class="">-- FACTURA N° --</option>
                @foreach($compras as $compra)
                    <option value="{{ $compra->id }}"{{ old('sucursal')}}>
                        {{ ucwords($compra->id )}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3"></div>
        <div v-if="showdatos"> <!-- Datos de la compra -->
            <hr>
            <div class="row card-header">
                <div class="col-md-6"> <!-- Datos del proveedor -->
                    <h6>Datos del Proveedor</h6>
                    <p class="mb-0">Proveedor: @{{ datos_factura.proveedor | upper}}</p>
                    <p class="mb-0"> Rif: @{{ datos_factura.proveedor_rif | upper }}</p>
                </div>
                <div class="col-md-6"> <!-- Datos de la compra -->
                    <h6>Datos de la Orden de Compra</h6>
                    <p class="mb-0">Fecha: @{{ datos_factura.fecha_compra}}</p>
                    <p class="mb-0"> Total: @{{ datos_factura.subtotal | dolar }}</p>
                    <!-- <p class="mb-0"> Iva: @{{ datos_factura.iva | dolar  }}</p>
                    <p class="mb-0"> Total: @{{ datos_factura.total | dolar }}</p> -->
                </div>
                <hr>
            </div>
            <div class="row" style="text-align: center;"> <!-- Tabla de los productos adquiridos -->
                <div class="col-md-2" align="center"></div>
                <div class="col-md-8 container card-body">
                    <table class="table table-responsive  " >
                        <thead>
                        <tr>
                            <th colspan="5"> Productos Adquiridos </th>
                        </tr>
                            <tr>
                                <th>#</th>
                                <th>Nombres de los Productos</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(id,index) in datos_factura.productos.ids">
                                <td align="center">@{{ id }}</td>
                                <td align="center"> <!-- Nombres y categoría -->
                                    @{{ datos_factura.productos.nombres[index] }} <br>
                                    <span class="note"> <strong>Categoria: @{{  datos_factura.productos.categoria[index]  }}</strong></span>
                                </td>
                                <td align="center"> <!-- Cantidad -->
                                    @{{ datos_factura.productos.cantidad[index] }}
                                </td>
                                <td align="center"> <!-- Precio por unidad -->
                                    @{{ datos_factura.productos.precio_unitario[index] | dolar }}
                                </td>
                                <td align="center"> <!-- Subtotal -->
                                    @{{ datos_factura.productos.subtotal[index] | dolar}}
                                </td>
                            </tr>
                        </tbody>
                        <tr>
                            <td colspan="5"> <button class="btn btn-success" @click="cargar_productos()">Guardar</button></td>
                        </tr>
                    </table>
                </div> </div>
                <div class="col-md-2" align="center"></div>
            </div>
<!--        <div class="row">
            <div class="col-md-4 text-center">
                <label for="porcentaje_ganancia"><strong>Porcentaje de Ganancia</strong></label>
                <input type="number" min="1" max="100" class="form-control text-center @if( $errors->get('porcentaje_ganancia')) field-error @endif" :readonly="precio_compra===''" v-model="porcentaje_ganancia" name="porcentaje_ganancia" id="porcentaje_ganancia" @keyup="setprecio()" placeholder="%"  value="{{ old('porcentaje_ganancia') }}">
                <label for="precio_compra"> <strong>Ganancia en Bs</strong></label>
                <input type="number" readonly :value="ganancia_bs" class="form-control text-center" >
            </div>
            <div class="col-md-4 text-center">
                <label for="precio_venta"><strong>Precio de Venta ($)</strong></label>
                <input type="number" class="form-control text-center @if( $errors->get('precio_venta')) field-error @endif" name="precio_venta" id="precio_venta" v-model="precio_venta" readonly value="{{ old('precio_venta') }}">
                <label for="precio_compra"> <strong>Precio Venta (Bs)</strong></label>
                <input type="number" readonly :value="total_bs" class="form-control text-center"  >
            </div>
        </div>-->

        </div>
    @endcard

@endsection
@section('script')
    <script>
        Vue.filter('upper',function (value){
            return value.toUpperCase();
        })
        Vue.filter('numero',function (value){
            return  new Intl.NumberFormat("de-DE").format(value)
        })
        Vue.filter('dolar',function (value){
            return new Intl.NumberFormat('de-DE',{ style: 'currency', currency: 'usd'}).format(value)
        })
        const app=new Vue({
            el:'#app',
            data: {
                compra:'',
                showdatos:false,
                precio_venta:'',
                porcentaje_ganancia:30,
                precio_compra:'',
                precio_bs:'',
                ganancia_bs:'',
                total_bs:'',
                datos_factura:{
                    numero:'',
                    compra_id:'',
                    tasa:'',
                    proveedor:'',
                    fecha_compra:'',
                    proveedor_rif:'',
                    subtotal:0,
                    iva:0,
                    total:0,
                    productos:{
                        ids:[],
                        cantidad:[],
                        nombres:[],
                        precio_unitario:[],
                        subtotal:[],
                        photos:[],
                        categoria:[],
                    },
                }
            },
            methods:{
               selecdata(){
                   $.ajax({
                       url:'/compras/selecdata',
                       method:'POST',
                       data:{
                           'compra_id':app.compra,
                           "_token": "{{ csrf_token() }}"
                       },
                       dataType:'json',
                       success:function (data){
                           if(data.status=== true){
                               app.showdatos=true
                               app.datos_factura.numero='00'+data.compra_id
                               app.datos_factura.compra_id=data.compra_id
                               app.datos_factura.tasa=data.tasa
                               app.datos_factura.productos.ids=data.ids
                               app.datos_factura.productos.cantidad=data.cantidad
                               app.datos_factura.productos.nombres=data.nombres
                               app.datos_factura.productos.precio_unitario=data.precio_unitario
                               app.datos_factura.productos.subtotal=data.subtotal
                               app.datos_factura.productos.photos=data.photos
                               app.datos_factura.productos.categoria=data.categorias_compra
                               app.datos_factura.proveedor=data.proveedor_nombre
                               app.datos_factura.proveedor_rif=data.proveedor_rif
                               app.datos_factura.fecha_compra=data.fecha_compra
                               app.datos_factura.subtotal=data.subtotal_compra
                               app.datos_factura.iva=data.iva
                               app.datos_factura.total=data.total_factura

                               /*Swal.fire({
                                   icon: "success",
                                   title: "Exito",
                                   text: "Compra Registrada Exitosamente",
                                   confirmButtonText: 'Enterado',
                                   allowOutsideClick:false,
                                   footer: '<a class="note" href="/compras/nueva">Deseas Agregar otra compra?</a>'
                               }).then((result)=>{
                                   if(result.isConfirmed){
                                       window.location.href = '/compras'
                                   }
                               })*/
                           }
                       },
                       error:function (jqXHR){
                           console.log(jqXHR.responseJSON)
                       }
                   })
               },
               cargar_productos(){
                   Swal.fire({ //Función para mensaje de confirmación
                       icon: "info",
                       title: "Confirmar",
                       text: "¿Seguro que deseas cargar los productos al almacén? No podrás deshacer los cambios",
                       confirmButtonText: 'Si, Confirmar',
                       cancelButtonText:'Cancelar',
                       showCancelButton: true,
                       allowOutsideClick:false,
                   }).then((result)=>{
                       if(result.isConfirmed){
                           $.ajax({
                               url:'/compras/update_productos',
                               method:'POST',
                               data:{
                                   'ids_productos':app.datos_factura.productos.ids,
                                   'precio_productos':app.datos_factura.productos.precio_unitario,
                                   'cantidad_productos':app.datos_factura.productos.cantidad,
                                   'compra_id':app.datos_factura.compra_id,
                                   "_token": "{{ csrf_token() }}"
                               },
                               dataType:'json',
                               success:function (data){
                                   if(data.status=== true){
                                       Swal.fire({ //Función para confirmar el ingreso de los productos
                                  icon: "success",
                                  title: "Ingreso Completado",
                                  text: "Factura Cargada Exitosamente",
                                  confirmButtonText: 'Realizado',
                                  allowOutsideClick:false,
                                  footer: '<a class="note" href="/compras/cargar">¿Deseas cargar otra Factura?</a>'
                              }).then((result)=>{
                                  if(result.isConfirmed){
                                      window.location.href = '/almacen'
                                  }
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
                setprecio(){
                    this.precio_venta=(parseFloat(this.precio_compra)*parseFloat(this.porcentaje_ganancia)/100)+parseFloat(this.precio_compra)
                    //console.log(this.tasa_dolar.price)
                    this.precio_bs= (parseFloat(this.precio_compra) * parseFloat(this.tasa_dolar.price)).toFixed(2)
                    this.ganancia_bs=(( parseInt(this.porcentaje_ganancia)*this.precio_bs)/100).toFixed(2)
                    this.total_bs=(parseFloat(this.precio_bs)+ parseFloat(this.ganancia_bs)).toFixed(2)
                }

            },
            computed:{
            }
        })

    </script>

@endsection


