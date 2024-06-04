<tr class="" align="center">
    <td>{{$i + 1}}</td>
    <td>
      {{\Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y')}}
        <span class="note">Sucursal: {{ucwords($venta->sucursal->nombre)}}</span>
    </td>
    <td>
        {{ucfirst($venta->cliente->nombre)}} <br>
        {{ucfirst($venta->cliente->tipo_documento)}}-{{$venta->cliente->num_documento}} <br>
    </td>
    <td>
        <table class="table table-striped">
            <thead >
                <tr class="text-center">
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @foreach(explode(',',$venta->detalle_venta->productos_nombres) as $i=>$producto)
                <tr class="text-center">
                    <th>{{ucwords($producto)}}</th>
                    <td>{{explode(',',$venta->detalle_venta->cantidad)[$i]}}</td>
                    <td>{{explode(',',$venta->detalle_venta->costo_unitario)[$i] }} $</td>
                    <th>{{number_format((float)explode(',',$venta->detalle_venta->subtotal)[$i] ,2,',','.')}} $</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </td>
    <td>
        @if($venta->delivery->status != null)
            <span class="@if($venta->delivery->status == 'pendiente') text-danger @endif"><strong>{{ucwords($venta->delivery->status)  }}</strong></span>
        @else
            <span><strong>No Solicitado</strong></span>
        @endif
    </td>

    <td class="text-center">
        <a href="{{ route('ventas.showpdf', $venta) }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-break"></i></a>
        <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button  type="button" class="btn btn-outline-danger btn-sm"  @click="deleteventa({{$venta->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
