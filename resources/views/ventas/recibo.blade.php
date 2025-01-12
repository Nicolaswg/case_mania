<!doctype html>
<html lang="en">

<head>
    <title>Venta {{$venta->id}}</title> <!-- Título de la venta -->
    <link rel="icon" href="{{ asset('images/logo.png') }}"> <!-- Logo -->
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

    <div class="row"> <!-- Bloque de datos de la empresa -->
        <div class="col-md-6 text-center" >
            <img src="{{asset('images/logo.png')}}" alt="Logo" height="120px" width="40%"> <!-- Venta -->
        </div>
        <div class="col-md-6 text-center"> <!-- Datos de la empresa -->
            <p class="m-0">Dirección: AV. Aviadores Centro Comercial Multicentro Locatel local 056</p>
            <p class="m-0">Maracay - Estado Aragua</p>
            <p class="m-0">Rif: J-50227944-0</p>
            <p class="m-0">Número de Contacto: 0414-5432112</p>
        </div>
    </div>
    <hr>
<div class=""> <!-- Bloque de datos del cliente -->
    <h4>--- Datos del Cliente ---</h4>
    Cliente: <strong> {{ucwords($venta->cliente->nombre)}}</strong> / <strong>{{ucfirst($venta->cliente->tipo_documento)}}-{{$venta->cliente->num_documento}}</strong><br>
    Número de Teléfono: <strong>{{$venta->cliente->telefono}} </strong>  <br>
    Dirección de Domicilio: <strong> </strong>  <br>
    Fecha de la Venta: <strong>{{\Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y')}}</strong>
    <hr>
    <!-- Mensaje sobre que se está adquiriendo una nota de entrega -->
    <h5 class="text-center">Estimado Usuario, usted está adquiriendo una <strong>Nota de Entrega</strong>, para consignar su factura debe dirigirse a la tienda correspondiente</h5>
    <hr>
    <table  width="100%" class="">
        <caption class=""> <!-- Detalles de la venta -->
            <h5 class="text-dark text-center">Detalles de la Venta</h5>
        </caption>
        <thead>
        <tr class="text-center"> <!-- Subtítulos de la venta -->
            <th scope="col" colspan="2" >Producto</th>
            <th scope="col">
                Cantidad
            </th>
            <th scope="col">
              Precio Unitario ($)
            </th>
            <th scope="col">
               Subtotal ($)
            </th>
        </tr>
        </thead>
        <tbody class="text-center"> <!-- Detalles de los productos ingresados -->
            @foreach($nombre as $i=>$producto)
                <tr class="text-center" >
                    <td> <!-- Imagen del producto -->
                        <div style="display: flex; justify-content: center">
                            <img src="{{asset('storage/productos/'.$photos[$i])}}" class="img-thumbnail" width="25" height="25" alt="{{'Foto'.$photos[$i]}}">
                        </div>
                    </td>
                    <td  style="vertical-align: middle"> <!-- Nombre del producto -->
                        {{ucwords($producto)}}
                    </td>
                    <td  style="vertical-align: middle;"> <!-- Cantidad del producto -->
                       {{$cantidad[$i]}}
                    </td>
                    <td  style="vertical-align: middle"> <!-- Precio individual del producto -->
                        {{number_format($precio[$i],2,',','.')}}
                    </td>
                    <td class="text-center"  style="vertical-align: middle"> <!-- Subtotal a pagar -->
                        {{number_format($subtotal[$i],2,',','.')}}
                    </td>                       
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <hr>
    <div class="row"> <!-- Detalles del cálculo de la nota de entrega -->
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class=" table-sm table-striped" align="right" style="margin-right: auto">
                <thead class="table-dark"> <!-- Subtítulos del cálculo de la nota de entrega -->
                    <tr class="text-center">
                        <th colspan="4" class="">Monto a Pagar</th>
                        <th >Dólares</th>
                        <th>Bolívares</th>
                    </tr>
                </thead>
                <tbody>
                <tr class="text-center"> <!-- Detalles del cálculo de la nota de entrega -->
                    <th colspan="4">
                        Total a Pagar
                    </th>
                    <th> <!-- Monto en divisas -->
                        {{number_format($venta->subtotal_dolar,2,',','.')}} $
                    </th>
                    <th> <!-- Monto en bolívares -->
                        {{number_format(((float)$venta->subtotal_dolar * (float)$venta->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                <!-- <tr class="text-center">
                    <th colspan="4">
                        I.V.A (16%)
                    </th>
                    <th>
                        {{number_format($venta->iva_dolar,2,',','.')}} $
                    </th>
                    <th>
                        {{number_format(((float)$venta->iva_dolar* (float)$venta->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                <tr class="text-center" style="border-style: double">
                    <th colspan="4">
                        Total de la Nota de Entrega
                    </th>
                    <th>
                        {{number_format($venta->total_dolar,2,',','.')}} $
                    </th>
                    <th>
                        {{number_format(((float)$venta->total_dolar* (float)$venta->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr> -->
                @if($venta->delivery->id != null)
                <tr class="text-center" style="border-style: double"> <!-- Montos del servicio a domicilio -->
                    <th colspan="4">
                        Costo del Servicio a Domicilio
                    </th>
                    <th> <!-- Divisas -->
                        {{number_format($venta->delivery->costo_delivery,2,',','.')}} $
                    </th>
                    <th> <!-- Blívares -->
                        {{number_format(((float)$venta->delivery->costo_delivery* (float)$venta->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <br>
</div>

</body>

</html>


