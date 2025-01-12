@extends('layout')
@section('title', "Realizar un Traslado")
@section('breadcrumb')

<!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('almacen.index')}}" class="link-dark">Almacén</a></li>
    <li class="breadcrumb-item active" aria-current="page">Traslado</li>
@endsection
@section('content')
    @card
    @slot('header', 'Registrar Traslado')
    @include('shared._errors')
<div class="row" id="app">
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
                <h5>Datos del Producto</h5>
            </div>
            <div class="card-header"> <!-- Sección de datos del producto -->
                <p><strong>Código: </strong>{{$producto->id }}<p>
                <p><strong>Nombre: </strong>{{ucwords($producto->nombre)}}</p>
                <div class="card-text">
                    <p><strong>Categoría: </strong> {{ucwords( $producto->categoria->nombre) }}</p>
                    <p><strong>Descripción: </strong> {{ucfirst( $producto->descripcion) }}</p>
                    <p><strong>Precio de Compra ($): </strong> {{ $producto->precio_compra }}</p>
                    <p><strong>Precio de Venta ($): </strong> {{ $producto->precio_venta}}</p>
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
    <div class="col-md-6"> <!-- Sección de traslado -->
        <div class="card">
            <div class="card-header">
            <h5>Seleccionar Sucursal para el Traslado</h5>
            </div>
            <div class="card-body">
                <label for="">Sucursal de Origen:</label> <!-- sucursal de origen -->
                <select name="" id="" v-model="desde" class="form-control" @change="setcantidad()">
                    <option value="">-- Seleccionar Sucursal de Origen --</option>
                    <option value="" v-for="(sucur,index) in sucursales" :value="index">@{{ sucur }}</option>
                </select>
                <hr>
                <label for="">Sucursal de Destino:</label> <!-- sucursal de destino -->
                <select name="" id="" class="form-control" v-model="hasta" @change="configcantidad()" :disabled="desde===''">
                    <option value="">-- Seleccionar Sucursal de Destino --</option>
                    <option value="" v-for="(sucur,index) in sucursales2" :value="index">@{{ sucur }}</option>
                </select>
                <div v-if="selec_cantidad">
                    <hr>
                    <label for="">Cantidad a Trasladar</label> <!-- Cantidad del traslado -->
                    <input type="number" minlength="1" class="form-control" :max="cantidad_produc " v-model="canti_traslado" @keyup="validate()">
                    <div class="text-center">
                        <button type="button" @click="savetraslado()" :disabled="!validar" class="btn btn-success mt-2 bi bi-box" style="align-content: center"> Trasladar Producto</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
    @endcard
@endsection
@section('script')
    <script>
        Vue.config.debug=true
        Vue.config.devtools=true
        const app=new Vue({
            el:'#app',
            data: {
                cargo:'',
                sucursales:<?php echo $nombre_sucur?>,
                cantidad:<?php echo $cantidad?>,
                producto_id:<?php echo $producto->id?>,
                desde:'',
                hasta:'',
                sucursales2:[],
                cantidad_produc:0,
                canti_traslado:1,
                error:false,
                selec_cantidad:false,
                validar:true,

            },
            methods:{
                config(index){
                    if(this.index===0){
                        $('#index').value(true)

                    }else{
                        this.devolucion=true
                    }
                },
                setcantidad(){
                    this.sucursales2=[]
                    this.error=false
                    if(this.cantidad[this.desde] <= 1){
                        this.error=true
                        this.sucursales2=[]
                        Swal.fire({ //Función para mostrar mensaje cuando se quiera trasladar mas de la cantidad existente
                            icon: "error",
                            title: "Error",
                            text: "Esta sucursal no tiene suficentes productos",
                        })
                    }
                    if(this.error !== true){
                        this.cantidad_produc=this.cantidad[this.desde]
                        this.sucursales2=this.sucursales.filter( sucursal=>sucursal !=this.sucursales[this.desde])
                    }


                },
                configcantidad(){
                    this.selec_cantidad=true
                },
                validate(){
                    if(this.cantidad_produc < this.canti_traslado || parseInt(this.canti_traslado) < 1){
                        this.validar=false
                    }else{
                        this.validar=true
                    }
                },
                savetraslado(){ //Función para confirmación del traslado
                    Swal.fire({
                        title: '¿Seguro que deseas registrar el traslado?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Trasladarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/traslado/update',
                                method:'POST',
                                data:{
                                    'desde':this.sucursales[this.desde],
                                    'hasta':this.sucursales2[this.hasta],
                                    'producto_id':this.producto_id,
                                    'cantidad_traslado':this.canti_traslado,
                                    'cantidad_ini':this.cantidad_produc,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    console.log(data.datos)
                                    if(data.status=== true){
                                        Swal.fire( //Función para confirmar traslado relizado
                                            'Exito!',
                                            'El traslado se registro de manera exitosa.',
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


