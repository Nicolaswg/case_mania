<!doctype html>
<html lang="en">

<head>
    <title>Compra {{$compra->id}}</title> <!-- Título de la Compra -->
    <link rel="icon" href="{{ asset('images/logo.png') }}"> <!-- Imagen del logo -->
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

    <div class="row"> <!-- Datos principales de la factura -->
        <div class="col-md-6 text-center" >
            <img src="{{asset('images/logo.png')}}" alt="Logo" height="120px" width="40%"> <!-- Logo -->
        </div>
        <div class="col-md-6 text-center"> <!-- Detalles de la empresa -->
            <p class="m-0">Dirección: AV. Aviadores Centro Comercial Multicentro Locatel local 056</p>
            <p class="m-0">Maracay - Estado Aragua</p>
            <p class="m-0">Rif: J-50227944-0</p>
            <p class="m-0">Número de Contacto: 0414-5432112</p>
        </div>
    </div>
    <hr>
<div class=""> <!-- Detalle del Proveedor -->
    <h4>--- Datos del Proveedor ---</h4>
    Proveedor: <strong> {{ucwords($compra->proveedor->nombre)}}</strong> <br>
    Número de Teléfono: <strong>{{$compra->proveedor->num_cel}} </strong>  <br>
    Fecha de la Compra: <strong>{{\Carbon\Carbon::parse($compra->fecha_compra)->format('d-m-Y')}}</strong>
    

    <table  width="100%" class="">
        <caption class="">
            <h5 class="text-dark text-center">Detalles de la Compra</h5> <!-- Detalles de la compra -->
        </caption>
        <thead>
        <tr class="text-center"> <!-- Subtítulos de los productos -->
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
                <tr >
                    <td>
                        <div style="display: flex; justify-content: center">
                            <img src="{{asset('storage/productos/'.$photos[$i])}}" class="img-thumbnail" width="25" height="25" alt="{{'Foto'.$photos[$i]}}">
                        </div>
                    </td>
                    <td  style="vertical-align: middle">
                        {{ucwords($producto)}}
                    </td>
                    <td  style="vertical-align: middle">
                       {{$cantidad[$i]}}
                    </td>
                    <td  style="vertical-align: middle">
                        {{number_format($precio[$i],2,',','.')}}
                    </td>
                    <td class="text-center"  style="vertical-align: middle">
                        {{number_format($subtotal[$i],2,',','.')}}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
    <hr>
    <div class="row"> <!-- Detalles del cálculo de la factura -->
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class=" table-sm table-striped" align="right" style="margin-right: auto">
                <thead class="table-dark">
                <tr class="text-center">
                    <th colspan="4" class="">Monto a Pagar</th>
                    <th >Dólares</th>
                    <th>Bolívares</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <th colspan="4"> <!-- Subtotal -->
                        Subtotal de la Orden de Compra
                    </th>
                    <th>
                        {{number_format($compra->subtotal,2,',','.')}} $
                    </th>
                    <th>
                        {{number_format(((float)$compra->subtotal* (float)$compra->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                <tr class="text-center"> <!-- I.V.A -->
                    <th colspan="4">
                        I.V.A (16%)
                    </th>
                    <th>
                         -
                    </th>
                    <th>
                        {{number_format(((float)$compra->iva* (float)$compra->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                <tr class="text-center"> <!-- IGTF -->
                    <th colspan="4">
                        I.G.T.F
                    </th>
                    <th>
                        {{number_format($compra->total,2,',','.')}} $
                    </th>
                    <th>
                         -
                    </th>
                </tr>
                <tr class="text-center" style="border-style: double"> <!-- Total de la factura -->
                    <th colspan="4">
                        Total de la Orden de Compra
                    </th>
                    <th>
                        {{number_format($compra->total,2,',','.')}} $
                    </th>
                    <th>
                        {{number_format(((float)$compra->total* (float)$compra->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
</div>

</body>

</html>


