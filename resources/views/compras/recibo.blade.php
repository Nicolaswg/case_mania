<!doctype html>
<html lang="en">

<head>
    <title>Compra {{$compra->id}}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table {
            font-size: 10px;
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
            <img src="{{asset('images/logo.png')}}" alt="Logo" height="120px" width="50%">
        </div>
        <div class="col-md-6 text-center">
            <p class="m-0">Rif: J-5165131</p>
            <p class="m-0">Numero de Contacto: 0426-8796544</p>
        </div>
    </div>
    <hr>
<div class="">
    Proveedor: <strong> {{ucwords($compra->proveedor->nombre)}}</strong> <br>
    Numero de Telefono: <strong>{{$compra->proveedor->num_cel}} </strong>  <br>
    Fecha de Compra: <strong>{{\Carbon\Carbon::parse($compra->fecha_compra)->format('d-m-Y')}}</strong>

    <table  width="100%" class="">
        <caption class="">
            <h5 class="text-dark text-center">Detalles de Compra</h5>
        </caption>
        <thead>
        <tr class="text-center">
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
        <tbody class="text-center" >
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
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class=" table-sm table-striped" align="right" style="margin-right: auto">
                <thead class="table-dark">
                <tr class="text-center">
                    <th colspan="4" class="">Monto a Pagar</th>
                    <th >Dolar</th>
                    <th>Bs</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <th colspan="4">
                        SUBTOTAL FACTURA
                    </th>
                    <th>
                        {{number_format($compra->subtotal,2,',','.')}} $
                    </th>
                    <th>
                        {{number_format(((float)$compra->subtotal* (float)$compra->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                <tr class="text-center">
                    <th colspan="4">
                        IVA (16%)
                    </th>
                    <th>
                        {{number_format($compra->iva,2,',','.')}} $
                    </th>
                    <th>
                        {{number_format(((float)$compra->iva* (float)$compra->tasa_bcv),2,',','.')}} Bs
                    </th>
                </tr>
                <tr class="text-center" style="border-style: double">
                    <th colspan="4">
                        TOTAL FACTURA
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


