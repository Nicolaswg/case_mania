<!doctype html>
<html lang="en">

<head>
    <title>Servicio {{$servicio->id}}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table {
            font-size: 15px;
            border-collapse: collapse;
            color: #1a202c;
        }
        td , th
        {
            border: 1px solid grey;
            vertical-align:top
        }
        .small{
            font-size: 12px;
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4cm;
            background-color: hotpink;
            color: white;
            text-align: center;

        }

    </style>
</head>

<body>

    <div class="row">
        <div class="col-md-6 text-center" >
            <img src="{{asset('images/logo.png')}}" alt="Logo" height="120px" width="40%">
        </div>
        <div class="col-md-6 text-center">
            <p class="m-0">Dirección: AV. Aviadores Centro Comercial Multicentro Locatel local 056</p>
            <p class="m-0">Maracay - Estado Aragua</p>
            <p class="m-0">Rif: J-50227944-0</p>
            <p class="m-0">Número de Contacto: 0414-5432112</p>
        </div>
    </div>
    <hr>
<div class="">
    <h4>--- Datos del Cliente ---</h4>
    Cliente: <strong> {{ucwords($servicio->cliente->nombre)}}</strong> / {{ucfirst($servicio->cliente->tipo_documento)}}-{{$servicio->cliente->num_documento}}<br>
    Número de Teléfono: <strong>{{$servicio->cliente->telefono}} </strong>  <br>
    Recibido por: <strong>{{ucwords($servicio->user)}}</strong> <br>
    Fecha de Recepción: <strong>{{\Carbon\Carbon::parse($servicio->fecha_recibido)->format('d-m-Y h:i A')}}</strong>
    <h5 class="@if($servicio->status == 'recibido') text-info @else text-success  @endif ">Estado: {{strtoupper($servicio->status)}}</h5>
    <table  width="100%" class="">
        <caption class="">
            <h5 class="text-dark text-center">Detalles del Servicio Técnico</h5>
        </caption>
        <thead>
        <tr class="text-center">
            <th scope="col" >Producto</th>
            <th scope="col">
                Cantidad
            </th>
            <th scope="col">
            Falla Registrada
            </th>
            @if($servicio->status == 'entregado')
                <th>
                    Estado de la Falla
                </th>
            @endif
            <th scope="col">
             Serial del Producto
            </th>
        </tr>
        </thead>
        <tbody class="text-center" >
            @foreach($productos as $i=>$producto)
                <tr class="text-center" >
                    <td  style="vertical-align: middle">
                        {{ucwords($producto)}}
                    </td>
                    <td  style="vertical-align: middle;">
                       {{$cantidad[$i]}}
                    </td>
                    <td  style="vertical-align: middle">
                        {{$falla[$i]}}
                    </td>
                    @if($servicio->status == 'entregado')
                        <th class="text-success">
                            Corregido
                        </th>
                    @endif
                    <td class="text-center"  style="vertical-align: middle">
                       {{$serial[$i]}}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <hr>
    @if($servicio->costo_dolar != null)
    <div class="row" >
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class=" table-sm table-striped" align="right" style="margin-right: auto">
                <thead class="table-striped">
                <tr class="text-center">
                    <th colspan="2" class="">Monto a Pagar</th>
                </tr>
                <tr class="text-center">
                    <th >Dólar</th>
                    <th>Bolívares</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <th >
                        {{number_format($servicio->costo_dolar,2,',','.')}} $
                    </th>
                    <th>
                        {{number_format($servicio->costo_bolivar,2,',','.')}} Bs
                    </th>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <hr>
    <div class="row">
        <div class="col-md-12">

        <table class="table mt-5 table-borderless" size="10px">
            <thead>
                <tr class="text-center">
                    <th>Firma del Cliente</th>
                    <th>Firma del Empleado</th><br>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>_____________________________________</td>
                    <td>_____________________________________</td>
                </tr>
            <tr class="text-center">
                <td>   {{ucwords($servicio->cliente->nombre)}}</td>
                <td>   {{ucwords($servicio->user)}}</td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
    <br>
</div>



</body>

</html>


