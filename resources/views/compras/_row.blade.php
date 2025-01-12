<tr class="" align="center">
    <td>00{{$i + 1}}</td> <!-- Renglón -->
    <td class="text-center"> <!-- Columna para mostrar fecha y sucursal de la compra -->
      {{\Carbon\Carbon::parse($compra->fecha_compra)->format('d-m-Y')}} <br>
       <span>Sucursal: <strong>{{ucwords($compra->sucursal->nombre)}}</strong></span>
    </td>
    <td class="text-center"> <!-- Columna para mostrar al proveedor -->
        {{ucfirst($compra->proveedor->nombre)}}
    </td>
    <td class="text-center"> <!-- Columna para mostrar los productos de la compra -->
        <table class="table table-striped">
            <thead >
                <tr class="text-center">
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @foreach(explode(',',$compra->detalle_compra->productos_nombres) as $i=>$producto)
                <tr class="text-center">
                    <th>{{explode(',',$compra->detalle_compra->productos_ids)[$i]}}-{{explode(',',$compra->detalle_compra->categorias_productos)[$i]}}-{{ucwords($producto)}}</th>
                    <td>{{explode(',',$compra->detalle_compra->cantidad)[$i]}}</td>
                    <td>{{explode(',',$compra->detalle_compra->costo_unitario)[$i] }} $</td>
                    <th>{{number_format((float)explode(',',$compra->detalle_compra->subtotal)[$i] ,2,',','.')}} $</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </td>

    <td class="text-center"> <!-- Columna para mostrar los botones de exportar, editar y eliminar la compra -->
        <div>
        <a href="{{ route('compras.showpdf', $compra) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-break"> Exportar</i></a>
        </div>
        <div>
        <a href="{{ route('compras.edit', $compra) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"> Editar</i></a>
        </div>
        <div>
        <button type="button" class="btn btn-outline-danger btn-sm" @click="deletecompra({{$compra->id}})"><i class="bi bi-trash3-fill"> Eliminar</i></button>
        </div>
    </td>
</tr>
