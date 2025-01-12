@extends('layout')
@section('title', "Configurar Precio de Venta")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('almacen.index')}}" class="link-dark">Almacén</a></li>
    <li class="breadcrumb-item active" aria-current="page">Configurar Precio de Venta</li>
@endsection
@section('content')
    @card
    @slot('header', 'Registrar Precio de Venta')
    @include('shared._errors')
    <div class="row" id="app">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header">
                    <h5>Datos del Producto</h5> <!-- Registrar el precio de venta -->
                </div>
                <div class="card-body"> <!-- Detalles del producto -->
                    <p><strong>Código: </strong>{{$producto->id }}<p>
                    <p><strong>Nombre: </strong>{{ucwords($producto->nombre)}}</p>
                    <div class="card-text">
                        <p><strong>Categoría: </strong> {{ucwords( $producto->categoria->nombre) }}</p>
                        <p><strong>Descripción: </strong> {{ucfirst( $producto->descripcion) }}</p>
                        <p><strong>Precio de Compra ($): </strong> {{ number_format($producto->precio_compra,2,',','.') }}</p>
                        <p><strong>Precio de Venta ($): </strong> {{ $producto->precio_venta != null ? number_format($producto->precio_venta ,2,',','.') : 'Por Configurar'}}</p>
                        <hr>
                        <h5>Cantidades Disponibles por Sucursal</h5>
                        <div>
                            <ul class="list-group-item" v-for="(sucursal,index) in sucursales">
                                <li> @{{ sucursal }}. Cantidad: @{{ cantidad[index] }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Configurar Precio de Venta</h5> <!-- Detalles del precio de venta -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <label for="porcentaje_ganancia"><strong>Porcentaje de Ganancia</strong></label>
                            <input type="number" min="1" max="30" class="form-control text-center @if( $errors->get('porcentaje_ganancia')) field-error @endif" :readonly="precio_compra===''" v-model="porcentaje_ganancia" name="porcentaje_ganancia" id="porcentaje_ganancia" @keyup="setprecio()"  @click="setprecio()" @blur="setprecio()" placeholder="Porcentaje de ganancia"  value="{{ old('porcentaje_ganancia') }}">
<!--                        <label for="precio_compra"> <strong>Ganancia en Bs</strong></label>
                            <input type="number" readonly :value="ganancia_bs" class="form-control text-center" >-->
                        </div>
                        <div class="col-md-6 text-center">
                            <label for="precio_venta"><strong>Precio de Venta ($)</strong></label>
                            <input type="number" class="form-control text-center @if( $errors->get('precio_venta')) field-error @endif" name="precio_venta" id="precio_venta" v-model="precio_venta" readonly value="{{ old('precio_venta') }}">
<!--                        <label for="precio_compra"> <strong>Precio Venta (Bs)</strong></label>
                            <input type="number" readonly :value="total_bs " class="form-control text-center"  >-->
                        </div>
                </div>
                    <div class="row">
                        <div class="col-md-12 mt-2" align="center">
                            <button type="button" @click="updateprecioproducto()" class="btn btn-success">Guardar Precio de Venta</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    @endcard
@endsection
@section('script')
    <script>
        Vue.filter('dolar',function (value){
            return new Intl.NumberFormat('de-DE',{ style: 'currency', currency: 'usd'}).format(value)
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
                precio_venta:'',
                porcentaje_ganancia:30,
                precio_compra:<?php echo $producto->precio_compra?>,
                precio_bs:'',
                ganancia_bs:'',
                total_bs:'',
                sucursales:<?php echo $nombre_sucur?>,
                cantidad:<?php echo $cantidad?>,
                producto_id:<?php echo $producto->id?>,
            },
            mounted() {
               // this.setpreciodolar()
               this.setprecio()
            },
            methods:{
                setpreciodolar(){
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
                setprecio(){
                    //console.log(app.tasa_dolar.price)
                    // this.setpreciodolar()
                    this.precio_venta=(parseFloat(this.precio_compra)*parseFloat(this.porcentaje_ganancia)/100)+parseFloat(this.precio_compra)
                    //console.log(this.tasa_dolar.price)
                    this.precio_bs= (parseFloat(this.precio_compra) * parseFloat(this.tasa_dolar.price)).toFixed(2)
                    this.ganancia_bs=(( parseInt(this.porcentaje_ganancia)*this.precio_bs)/100).toFixed(2)
                    this.total_bs=(parseFloat(this.precio_bs)+ parseFloat(this.ganancia_bs)).toFixed(2)
                },
                updateprecioproducto(){ //Función para configurar el precio de venta
                    console.log(this.porcentaje_ganancia)
                    console.log(this.precio_venta)
                    Swal.fire({
                        title: '¿Seguro que deseas ajustar el precio de Venta para este producto?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Guardar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/producto/updateprecioventa',
                                method:'POST',
                                data:{
                                    'producto_id':app.producto_id,
                                    'porcentaje_ganancia':app.porcentaje_ganancia,
                                    'precio_venta':app.precio_venta,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data.status === true){
                                        Swal.fire( //Función para confirmar el registro del precio de venta
                                            'Registrado',
                                            'El Precio de venta ha sido registrado exitosamente',
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
                }
            },
            computed:{
            }
        })

    </script>

@endsection
