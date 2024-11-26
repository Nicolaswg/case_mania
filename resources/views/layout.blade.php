<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title') - CaseMania</title>
    <!-- Favicon-->
   <link rel="icon" href="{{ asset('images/logo.png') }}">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/style.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.css" integrity="sha256-CNwnGWPO03a1kOlAsGaH5g8P3dFaqFqqGFV/1nkX5OU=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
<div class="d-flex" id="wrapper"x|>
    <!-- Sidebar-->

    <div class="border-end " id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom bg-primary bg-gradient"><img src="{{asset('images/logo.png')}}" width="150" class="img-thumbnail rounded" alt="CaseMania"></div>
        <div class="list-group text-center">
            <a class="list-group-item list-group-item-action p-3  bg-gradient" href="{{route('home')}}"><i class="bi bi-house-door-fill"></i> Inicio</a>
            @vendedor
            <a class="list-group-item list-group-item-action  p-3" href="{{route('almacen.index')}}"><i class="bi bi-collection-fill"></i> Almacen</a>
            <button class="btn btn-toggle list-group-item list-group-item-action  p-3" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true"><i class="bi bi-journals"></i>
                Registros <i class="bi bi-caret-down-fill"></i>
            </button>
            <div class="collapse" id="home-collapse">
                <ul class="btn-toggle-nav list-unstyled list-group-item-light fw-normal  list-group-item list-group-item-action">
                    <li><a href="{{route('categorias.index')}}" class="link-dark rounded"><i class="bi bi-card-list"></i> Categorias de Productos</a></li>
                    <li><a href="{{route('productos.index')}}" class=" link-dark link-underline-dark rounded"><i class="bi bi-list-nested"></i> Lista de Productos</a></li>
                </ul>
            </div>
            <button class="btn btn-toggle list-group-item list-group-item-action  p-3" data-bs-toggle="collapse" data-bs-target="#compras" aria-expanded="true"><i class="bi bi-cart-fill"></i>
                Compras <i class="bi bi-caret-down-fill"></i>
            </button>
            <div class="collapse" id="compras">
                <ul class="btn-toggle-nav list-unstyled  fw-normal  list-group-item list-group-item-action">
                    <li><a href="{{route('proveedores.index')}}" class="link-dark rounded"><i class="bi bi-person-badge-fill"></i> Proveedores</a></li>
                    <li><a href="{{route('compras.index')}}" class=" link-dark link-underline-dark rounded"><i class="bi bi-list-nested"></i> Lista de Compras</a></li>
                </ul>
            </div>
            @endvendedor
            @servicio
            <button class="btn btn-toggle list-group-item list-group-item-action  p-3" data-bs-toggle="collapse" data-bs-target="#ventas" aria-expanded="true"><i class="bi bi-graph-up-arrow"></i>
                Ventas <i class="bi bi-caret-down-fill"></i>
            </button>
            <div class="collapse" id="ventas">
                <ul class="btn-toggle-nav list-unstyled  fw-normal  list-group-item list-group-item-action">
                    <li><a href="{{route('clientes.index')}}" class="link-dark rounded"><i class="bi bi-person-plus-fill"></i> Clientes</a></li>
                    <li><a href="{{route('ventas.index')}}" class=" link-dark link-underline-dark rounded"><i class="bi bi-list-nested"></i> Lista de Ventas</a></li>
                </ul>
            </div>
            @endservicio
            @if(auth()->user()->isServicio() || auth()->user()->isAdmin() )
                <a class="list-group-item list-group-item-action  p-3" href="{{route('servicios.index')}}"><i class="bi bi-exclamation-square-fill"></i> Servicio Tecnico</a>
            @endif
                <a class="list-group-item list-group-item-action  p-3" href="{{route('deliverys.index')}}"><i class="bi bi-car-front-fill"></i> Deliverys</a>
            @admin
            <button class="btn btn-toggle list-group-item list-group-item-action  p-3" data-bs-toggle="collapse" data-bs-target="#empleado" aria-expanded="true"><i class="bi bi-person-circle"></i>
                Empleados <i class="bi bi-caret-down-fill"></i>
            </button>
            <div class="collapse" id="empleado">
                <ul class="btn-toggle-nav list-unstyled  fw-normal  list-group-item list-group-item-action">
                    <li><a href="{{route('users.create')}}" class="link-dark rounded"><i class="bi bi bi-plus-lg"></i> Registrar un Empleado</a></li>
                    <li><a href="{{route('users.index')}}" class="link-dark rounded"><i class="bi bi bi-list-nested"></i>Lista de Empleados</a></li>
                </ul>
            </div>
            <a class="list-group-item list-group-item-action  p-3" href="{{route('sucursales.index')}}"><i class="bi bi-bank"></i> Sucursales</a>
            @endadmin
        </div>
    </div>
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-primary bg-gradient border-bottom">
            <div class="container-fluid">
                <button class="btn btn-dark" id="sidebarToggle"><i class="bi bi-arrow-left-right"></i></button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <nav aria-label="breadcrumb" class="ml-3 mt-1">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                    </ol>
                </nav>
                <div class="collapse navbar-collapse" id="helper">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">

                        <li class="nav-item active nav-link">Tasa BCV: <span class="fw-bold">@{{ tasa_dolar.price }}</span> Bs/Dolar</li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{auth()->user()->name}}</a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                {{--<div class="dropdown-divider"></div>--}}
                                 {{--  LOGOUT--}}
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
<!-- Bootstrap core JS-->
<script type="text/javascript" src="https://unpkg.com/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.29/dist/sweetalert2.all.min.js"></script>
<!-- Core theme JS-->
<script src="{{asset('js/scripts.js')}}"></script>
<script>
    const helper=new Vue({
        el:'#helper',
        data: {
            tasa_dolar:{
                price:0,
                date:'',
            },
        },
        mounted() {
            this.setpreciodolar()
        },
        methods:{
            setpreciodolar(){
                $.ajax({
                    url:'https://pydolarve.org/api/v1/dollar?page=bcv',
                    method:'GET',
                    dataType:'json',
                    success:function (data){
                        if(data){
                            helper.tasa_dolar.price=data.monitors.usd.price
                            helper.tasa_dolar.date=data.datetime.date
                        }
                    },
                    error:function (jqXHR){
                        console.log(jqXHR.responseJSON)
                    }
                })

            },

        },
    })

</script>
@yield('script')
</body>
</html>
