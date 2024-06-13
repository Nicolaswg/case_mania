@extends('layout')
@section('title', "Añadir Producto")
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}" class="link-dark">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('productos.index')}}" class="link-dark">Productos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
@endsection
@section('content')
    @card
    @slot('header', 'Añadir Producto')
    @include('shared._errors')
    <form method="POST" action="{{ url('productos') }}" id="app" enctype="multipart/form-data">
        @include('productos._fields')
        <div class="form-group mt-4" align="middle">
            <button type="submit"  class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Añadir Producto</button>
            <a href="{{ route('productos.index') }}" class="btn btn-link">Regresar</a>
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
                config(){
                    if(this.empleado===true){
                        this.empleado=false

                    }else{
                        this.empleado=true
                    }
                },
                deleteuser:function (user_id){
                    Swal.fire({
                        title: '¿Seguro que deseas eliminar el Usuario?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminarlo!'
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
                                        Swal.fire(
                                            'Elimininado!',
                                            'El archivo a sido Eliminado.',
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
                setprecio(){
                    this.precio_venta=(parseFloat(this.precio_compra)*parseFloat(this.porcentaje_ganancia)/100)+parseFloat(this.precio_compra)
                    //console.log(this.tasa_dolar.price)
                    this.precio_bs= (parseFloat(this.precio_compra) * parseFloat(this.tasa_dolar.price)).toFixed(2)
                    this.ganancia_bs=(( parseInt(this.porcentaje_ganancia)*this.precio_bs)/100).toFixed(2)
                    this.total_bs=parseFloat(this.precio_bs)+ parseFloat(this.ganancia_bs)
                }
            },
            computed:{
            }
        })

    </script>

@endsection
