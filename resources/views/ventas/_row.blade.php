<tr class="" align="center">
    <td> <!-- Columna para la fecha y la sucursal de la venta -->
      {{\Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y')}}
        <span class="note">Sucursal: {{ucwords($venta->sucursal->nombre)}}</span>
    </td>
    <td> <!-- Columna para mostrar el nombre y documento del cliente -->
        {{ucfirst($venta->cliente->nombre)}} <br>
        {{ucfirst($venta->cliente->tipo_documento)}}-{{$venta->cliente->num_documento}} <br>
    </td>
    <td> <!-- Columna para mostrar los productos de la venta -->
        <table class="table table-striped">
            <thead >
                <tr class="text-center">
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach(explode(',',$venta->detalle_venta->productos_nombres) as $i=>$producto)
                <tr class="text-center">
                    <th>{{explode(',',$venta->detalle_venta->productos_ids)[$i]}}-{{explode(',',$venta->detalle_venta->categorias_productos)[$i]}}-{{ucwords($producto)}}</th>
                    <td>{{explode(',',$venta->detalle_venta->cantidad)[$i]}}</td>
                    <td>{{explode(',',$venta->detalle_venta->costo_unitario)[$i] }} $</td>
                    <th>{{number_format((float)explode(',',$venta->detalle_venta->subtotal)[$i] ,2,',','.')}}$</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </td>
    <td> <!-- Columna para mostrar el estado del servicio a domicilio -->
        @if($venta->delivery->status != null)
            <span class="@if($venta->delivery->status == 'pendiente') text-danger @endif"><strong>{{ucwords($venta->delivery->status)  }}</strong></span>
        @else
            <span><strong>No Solicitado</strong></span>
        @endif
    </td>
    <td  class=" @if($venta->status == 'devuelto') text-danger @else text-success @endif"> <!-- Columna para mostrar los productos devueltos y el motivo -->
        {{$venta->status == 'devuelto' ? 'Productos Devueltos': 'Activa'}}
        @if($venta->status == 'devuelto')
            <br>
            Motivo: <strong>{{ucfirst($venta->devolucion->motivo_devolucion)}}</strong>
        @endif
    </td>

    <td class="text-center"> <!-- Botones de exportar, editar, devolver y eliminar -->
        @if($venta->status == null)
        <div>
        <a href="{{ route('ventas.showpdf', $venta) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-break"> Exportar</i></a>
        </div>
        <div>
        <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"> Editar</i></a>
        </div>
        @if ( auth()->user()->isAdmin() || auth()->user()->isVendedor() )
        <div>
        <a href="{{ route('devoluciones.create', $venta->id) }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-dropbox"> Devolver</i></a>
        </div>
        @endif
        @endif
        <div>
        <button type="button" class="btn btn-outline-danger btn-sm"  @click="deleteventa({{$venta->id}})"><i class="bi bi-trash"> Eliminar</i></button>
        </div>
    </td>
</tr>