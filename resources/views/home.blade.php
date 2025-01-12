@extends('layout')
@section('title', "Inicio")
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Inicio</li>
@endsection
@section('content')
    <div class="container px-4 py-5 " id="hanging-icons">
        <h2 class="pb-2 border-bottom">Bienvenido, {{ucwords(auth()->user()->name)}} <!-- Mensaje de bienvenida y el nombre del usuario -->  
            <!-- <span class="note">/  {{strtolower(auth()->user()->role)}}</span> --></h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3"> <!-- Gráfico de ventas -->
            @if(auth()->user()->isAdmin() || auth()->user()->isVendedor() || auth()->user()->isServicio() )
                <div class="col d-flex align-items-center card card-header">
                    <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                        <svg class="bi" width="1em" height="2em"><i class="bi bi-graph-up-arrow"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Ventas</h3></svg>
                    </div>
                    <hr class="mt-0">
                    <div class="text-center">
                        {!! $chart_ventas->container() !!}
                        <script src="{{ $chart_ventas->cdn() }}"></script>
                        {{ $chart_ventas->script() }}
                        <a href="{{route('ventas.index')}}" class="btn btn-success mt-2 text-center align-content-center" >
                            <i class="bi bi-eye"></i>
                            Ver mas
                        </a>
                    </div>
                </div>
            @endif
            <div class="col d-flex align-items-center card"> <!-- Gráfico de servicios a domicilio -->
                <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                    <svg class="bi" width="1em" height="2em"><i class="bi bi-car-front-fill"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Servicios a Domicilio</h3></svg>
                </div>
                <hr class="mt-0">
                <div class="text-center">
                    {!! $chart->container() !!}
                    <script src="{{ $chart->cdn() }}"></script>
                    {{ $chart->script() }}
                    <a href="{{route('deliverys.index')}}" class="btn btn-success mt-1 text-center align-content-center" >
                        <i class="bi bi-eye"></i>
                        Ver mas
                    </a>
                </div>
            </div>
            @if(auth()->user()->isAdmin() ||auth()->user()->isServicio() ) <!-- Gráfico de servicios téncicos -->
                <div class="col d-flex align-items-center card card-header">
                    <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                        <svg class="bi" width="1em" height="2em"><i class="bi bi-phone-flip"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Servicios Técnicos</h3></svg>
                    </div>
                    <hr class="mt-0">
                    <div class="text-center">
                        {!! $chart1->container() !!}

                        <script src="{{ $chart1->cdn() }}"></script>

                        {{ $chart1->script() }}
                        <a href="{{route('servicios.index')}}" class="btn btn-success mt-2 text-center align-content-center" >
                            <i class="bi bi-eye"></i>
                            Ver mas
                        </a>
                    </div>
                </div>
            @endif

        </div>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3"> <!-- Gráfico de productos en almacén -->
            @if(auth()->user()->isAdmin() || auth()->user()->isVendedor() || auth()->user()->isServicio() )
                <div class="col d-flex align-items-center card card-header">
                    <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3 ">
                        <svg class="bi" width="1em" height="2em"><i class="bi bi-boxes"></i><h3 class="fs-2 ml-2 text-body-emphasis text-center mt-0">Productos en Almacén</h3></svg>
                    </div>
                    <hr class="mt-0">
                    <div class="text-center">
                        @if($productos != null)
                            {!! $chart_productos->container() !!}

                            <script src="{{ $chart_productos->cdn() }}"></script>

                            {{ $chart_productos->script() }}
                        @else
                            <h3>No hay Productos Bajo Stock</h3>
                        @endif
                        <a href="{{route('almacen.index')}}" class="btn btn-success mt-2 text-center align-content-center" >
                            <i class="bi bi-eye"></i>
                            Ver mas
                        </a>
                    </div>
                </div>
            @endif
            <div class="col d-flex align-items-center"></div>

        </div>
        <div class="row">

        </div>

    </div>
@endsection
@section('script')


@endsection

