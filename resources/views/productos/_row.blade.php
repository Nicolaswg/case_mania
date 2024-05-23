<tr class="" align="center">
    <td>{{$i + 1}}</td>
    <td>
        <div style="display: flex; justify-content: center">
            <img src="{{asset('storage/productos/'.$producto->photo)}}" class="img-thumbnail" width="100" height="100" alt="{{'Foto'.$producto->photo}}">
        </div>
    </td>
    <th>
        {{ucwords($producto->nombre)}}<br>
       <span class="@if(strtolower($producto->status) == 'inactivo') text-danger @endif @if(strtolower($producto->status) == 'activo') text-success @endif">{{ucwords($producto->status)}} </span>
    </th>
    <td>
        {{ucfirst($producto->descripcion)}}
    </td>
    <td>
        {{ucwords($producto->categoria->nombre)}}
    </td>

    <td align="center">
        {{$producto->cantidad}}
    </td>
    <td>
        @if(auth()->user()->isAdmin())
            @if($producto->status != 'inactivo')
        <ul class="list-unstyled list-group-item ">
            <li>Precio de Compra: <strong>{{$producto->precio_compra}} $</strong></li>
            <li>% de Ganancia: <strong> {{$producto->porcentaje_ganancia}} % ->({{$producto->precio_compra * ($producto->porcentaje_ganancia)/100}} $)</strong> </li>
            <li class="text-success">Precio de Venta: <strong>{{$producto->precio_venta == null ? 'No disponible' : $producto->precio_venta . '$'}} </strong></li>
        </ul>
            @else
                <p class="text-danger"> Debes Ajustar <br>Precio de Compra y Venta <br>para el Producto</p>
            @endif
        @else
            <p class=" @if($producto->precio_venta == null) text-danger @else text-success @endif"><li>Precio de Venta: <strong>{{$producto->precio_venta == null ? 'No disponible' : $producto->precio_venta . '$'}} </strong></li></p>
        @endif
    </td>
    <td class="text-right">
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
    </td>
</tr>
