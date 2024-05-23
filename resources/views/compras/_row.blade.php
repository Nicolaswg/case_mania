<tr class="" align="center">
    <td>{{$i + 1}}</td>
    <td>
      {{\Carbon\Carbon::parse($compra->fecha_compra)->format('d-m-Y')}}
    </td>
    <td>
        {{ucfirst($compra->proveedor->nombre)}}
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
            @foreach(explode(',',$compra->detalle_compra->productos_nombres) as $i=>$producto)
                <tr class="text-center">
                    <th>{{ucwords($producto)}}</th>
                    <td>{{explode(',',$compra->detalle_compra->cantidad)[$i]}}</td>
                    <td>{{explode(',',$compra->detalle_compra->costo_unitario)[$i] }} $</td>
                    <th>{{number_format((float)explode(',',$compra->detalle_compra->subtotal)[$i] ,2,',','.')}} $</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </td>

    <td class="text-center">
        <a href="{{ route('compras.showpdf', $compra) }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-break"></i></a>
        <a href="{{ route('compras.edit', $compra) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button  type="button" class="btn btn-outline-danger btn-sm"  @click="deletecompra({{$compra->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
