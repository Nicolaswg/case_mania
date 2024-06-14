@extends('layout')
@section('title', "Crear Traslado")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Registrar Traslado')
    @include('shared._errors')
<div class="row" id="app">
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
                Datos del Producto
            </div>
            <div class="card-body">
                <h5 class="card-title">CODIGO: 00{{$producto->id }} NOMBRE: {{ucwords($producto->nombre)}}</h5>
                <div class="card-text">
                    <p><strong>Categoria</strong>: {{ucwords( $producto->categoria->nombre) }}</p>
                    <p><strong>Descripcion</strong>: {{ucfirst( $producto->descripcion) }}</p>
                    <p><strong>Precio de Compra ($)</strong>: {{ $producto->precio_compra }}</p>
                    <p><strong>Precio de Venta ($)</strong>: {{ $producto->precio_venta}}</p>
                    <hr>
                    <h5>Cantidades Disponibles por Sucursal</h5>
                    @foreach($sucursales as $i=>$sucursal)
                            <?php
                            $prod=$sucursal->productos->where('sucursal_id',$sucursal->id)->where('id',$producto->id)->first();
                            if($prod != null){
                                $canti=$prod->cantidad;
                            }else{
                                $canti=0;
                            }

                            ?>
                        <li class="">Sucursal {{ucwords( $sucursal->nombre) }} : <strong>{{$canti}}</strong></li>
                    @endforeach
                </div>
            </div>
        </div>
        <hr>

    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
               SELECCIONA
            </div>
            <div class="card-body">
                <label for="">Desde</label>
                <select name="" id="" v-model="desde" class="form-control" @change="setcantidad()">
                    <option value="">--SELECCIONA--</option>
                    <option value="" v-for="(sucur,index) in sucursales" :value="index">@{{ sucur }}</option>
                </select>
                <hr>
                <label for="">Hasta</label>
                <select name="" id="" class="form-control" v-model="hasta" @change="configcantidad()" :disabled="desde===''">
                    <option value="" v-for="(sucur,index) in sucursales2" :value="index">@{{ sucur }}</option>
                </select>
                <div v-if="selec_cantidad">
                    <hr>
                    <label for="">Cantidad</label>
                    <input type="number" min="1" class="form-control" :max="cantidad_produc " v-model="canti_traslado" @keyup="validate()">
                    <div class="text-center">
                        <button type="button" @click="savetraslado()" :disabled="!validar" class="btn btn-primary mt-2" style="align-content: center">Trasladar</button>
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
                        Swal.fire({
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
                savetraslado(){
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
                                    'hasta':this.sucursales[this.hasta],
                                    'producto_id':this.producto_id,
                                    'cantidad_traslado':this.canti_traslado,
                                    'cantidad_ini':this.cantidad_produc,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data.status=== true){
                                        Swal.fire(
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


