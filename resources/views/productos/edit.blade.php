@extends('layout')

@section('title', "Editar Producto")
@section('breadcrumb')

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('productos.index')}}" class="link-dark">Productos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection
@section('content')
    @card
    @slot('header', 'Editar Producto')

    @include('shared._errors')

    <form method="POST" action="{{ url("productos/{$producto->id}") }}" enctype="multipart/form-data" id="app"> <!-- Botón de actualizar y regresa al listado -->
        {{ method_field('PUT') }}

        @include('productos._fields')

        <div class="form-group mt-4 text-center"> <!-- Botones de actualizar proveedor y regresar al listado -->
            <button type="submit" class="btn btn-primary"> <i class="bi bi-arrow-repeat"></i> Actualizar Producto</button>
            <a href="{{ route('productos.index') }}" class="btn btn-link">Regresar al Listado de Productos</a>
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
                empleado:'',
                cargo:'',
                precio_venta:<?php echo $precio_venta?>,
                porcentaje_ganancia:<?php echo $porcentaje_ganancia?>,
                precio_compra:<?php echo $precio_compra?>,
                tasa:<?php echo $tasa?>,
                tasa_dolar:{
                    price:0,
                    date:'',
                },
                precio_bs:'',
                ganancia_bs:'',
                total_bs:'',

            },
            mounted() {
                this.setpreciodolar()
                this.setprecio()
            },
            methods:{
                setpreciodolar() {
                    $.ajax({
                        url:'https://pydolarvenezuela-api.vercel.app/api/v1/dollar?page=bcv', //Enlce para obtener el valor del BCV
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
                config(){
                    if(this.empleado===true){
                        this.empleado=false

                    }else{
                        this.empleado=true
                    }
                },
                deleteuser:function (user_id){ //Función para eliminar el producto
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar el producto?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:'/user/delete',
                                method:'POST',
                                data:{
                                    'user_id':user_id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType:'json',
                                success:function (data){
                                    if(data){
                                        Swal.fire( //Confirmación de producto eliminado
                                            'Eliminado',
                                            'El producto ha sido eliminado exitosamente',
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
                setprecio(){ //Función para obtener el valor del precio
                    this.precio_venta=(parseFloat(this.precio_compra)*parseFloat(this.porcentaje_ganancia)/100)+parseFloat(this.precio_compra)
                    if(this.tasa !== 0){
                        this.precio_bs= (parseFloat(this.precio_compra) * parseFloat(this.tasa)).toFixed(2)
                    }else{
                        this.precio_bs= (parseFloat(this.precio_compra) * parseFloat(this.tasa_dolar.price)).toFixed(2)
                    }
                    this.ganancia_bs=(( parseInt(this.porcentaje_ganancia)*this.precio_bs)/100).toFixed(2)
                    this.total_bs=(parseFloat(this.precio_bs)+ parseFloat(this.ganancia_bs)).toFixed(2)
                }
            },
            computed:{
            }
        })

    </script>

@endsection
