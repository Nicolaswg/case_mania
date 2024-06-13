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
    <td>
        <li class="list-group-item"> <strong>{{$producto->precio_compra}} $</strong></li>
    </td>
    <td>
        <li class="list-group-item"> <strong> {{$producto->porcentaje_ganancia}} % ->({{$producto->precio_compra * ($producto->porcentaje_ganancia)/100}} $)</strong> </li>
    </td>
    <td>
        <li class="text-success list-group-item"> <strong>{{$producto->precio_venta == null ? 'No disponible' : $producto->precio_venta . '$'}} </strong></li>
    </td>
    <td class="text-right">
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
    </td>
</tr>
