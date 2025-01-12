@extends('layout')
@section('title', "Añadir un Producto")
@section('breadcrumb') 

    <!-- Ruta -->

    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('productos.index')}}" class="link-dark">Productos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Añadir Producto')
    @include('shared._errors')
    <form method="POST" action="{{ url('productos') }}" id="app" enctype="multipart/form-data"> <!-- Botones de guardar y regresar al listado -->
        @include('productos._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit"  class="btn btn-primary"><i class="bi bi-save-fill"></i> Guardar Producto</button>
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
                precio_venta:'',
                porcentaje_ganancia:30,
                precio_compra:'',
                precio_bs:'',
                ganancia_bs:'',
                total_bs:'',
                tasa_dolar:{
                    price:0,
                    date:'',
                },
            },
            mounted() {
                this.setpreciodolar()
            },
            methods:{
                setpreciodolar() {
                    $.ajax({
                        url:'https://pydolarvenezuela-api.vercel.app/api/v1/dollar?page=bcv', //Enlace para obtener el valor del BCV
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
                setprecio(){ //Función para cálculos de los precios
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
