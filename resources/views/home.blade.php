@extends('layout')
@section('title', "Inicio")
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Inicio</li>
@endsection
@section('content')
    <div class="container px-4 py-5 " id="hanging-icons">
        <h2 class="pb-2 border-bottom">Bienvenido, {{ucwords(auth()->user()->name)}}  <span class="note">/  {{strtolower(auth()->user()->role)}}</span></h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            @if(auth()->user()->isAdmin() || auth()->user()->isVendedor() || auth()->user()->isServicio() )
             <div class="col d-flex align-items-center card card-header">
                <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                    <svg class="bi" width="1em" height="2em"><i class="bi bi-graph-up-arrow"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Ventas</h3></svg>
                </div>
                <hr class="mt-0">
                <div class="text-center">
                        @foreach($nombre_sucur as $i=>$sucursal)
                        <li class="text-center mb-0 list-group-item"> <strong> {{strtoupper($sucursal)}} </strong>: <strong>{{$acum_sucur[$i]}} $</strong> # Ventas: {{$num_ventas[$i]}} </li>
                        @endforeach
                    <a href="{{route('ventas.index')}}" class="btn btn-success mt-2 text-center align-content-center" >
                        <i class="bi bi-patch-plus-fill"></i>
                       Ver mas
                    </a>
                </div>
            </div>
            @endif
            <div class="col d-flex align-items-center card">
                <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                    <svg class="bi" width="1em" height="2em"><i class="bi bi-car-front-fill"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Deliverys</h3></svg>
                </div>
                <hr class="mt-0">
                <div class="text-center">
                    <ul class="list-unstyled mb-0 mt-0">
                        <li class="text-center mb-0 list-group-item text-danger" > <strong> Pendientes </strong>: <strong>{{$pendientes}}</strong>  </li>
                        <li class="text-center mb-0 list-group-item text-warning"> <strong> Proceso </strong>: <strong>{{$proceso}} </strong>  </li>
                        <li class="text-center mb-0 list-group-item text-success"> <strong> Entregadas </strong>: <strong>{{$entregadas}} </strong> </li>
                    </ul>
                    <a href="{{route('deliverys.index')}}" class="btn btn-success mt-1 text-center align-content-center" >
                        <i class="bi bi-patch-plus-fill"></i>
                        Ver mas
                    </a>
                </div>
            </div>
                @if(auth()->user()->isAdmin() ||auth()->user()->isServicio() )
                     <div class="col d-flex align-items-center card card-header">
                <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                    <svg class="bi" width="1em" height="2em"><i class="bi bi-phone-flip"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Servicio Tecnico</h3></svg>
                </div>
                <hr class="mt-0">
                <div class="text-center">
                    <ul class="list-unstyled mb-0 mt-0">
                        <li class="text-center mb-0 list-group-item text-danger" > <strong> Pendientes </strong>: <strong>{{$pendi}}</strong>  </li>
                        <li class="text-center mb-0 list-group-item text-success"> <strong> Entregados </strong>: <strong>{{$entregado}} </strong> </li>
                    </ul>
                    <a href="{{route('servicios.index')}}" class="btn btn-success mt-2 text-center align-content-center" >
                        <i class="bi bi-patch-plus-fill"></i>
                        Ver mas
                    </a>
                </div>
            </div>
                @endif

        </div>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            @if(auth()->user()->isAdmin() || auth()->user()->isVendedor() )
            <div class="col d-flex align-items-center card card-header">
                <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                    <svg class="bi" width="1em" height="2em"><i class="bi bi-box-arrow-down"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Productos en almacen</h3></svg>
                </div>
                <hr class="mt-0">
                <div class="text-center">
                    @foreach($productos as $i=>$producto)
                            <li class="text-center mb-0 list-group-item"> <strong>{{strtoupper($producto->categoria->nombre)}}-{{strtoupper($producto->nombre)}} </strong> <strong class="text-danger"> #: {{$producto->cantidad}} </strong> <span class="note"> Sucursal: {{$producto->sucursal->nombre}}</span></li>
                    @endforeach
                    <a href="{{route('productos.index')}}" class="btn btn-success mt-2 text-center align-content-center" >
                        <i class="bi bi-patch-plus-fill"></i>
                        Ver mas
                    </a>
                </div>
            </div>
            @endif
            <div class="col d-flex align-items-center"></div>
            <div class="col d-flex align-items-center"></div>

        </div>
    </div>
@endsection
@section('script')


@endsection

