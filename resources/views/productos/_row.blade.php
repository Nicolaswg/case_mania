<tr class="" align="center">
<!--     <td>{{$i + 1}}</td> -->
    <td> <!-- Columna de imagen del producto -->
        <div style="display: flex; justify-content: center">
            <img src="{{asset('storage/productos/'.$producto->photo)}}" class="img-thumbnail" width="100" height="100" alt="{{'Foto'.$producto->photo}}">
        </div>
    </td>
    <th class="text-center"> <!-- Columna de nombre y estado de actividad del producto -->
        {{ucwords($producto->nombre)}}<br>
       <span class="@if(strtolower($producto->status) == 'inactivo') text-danger @endif @if(strtolower($producto->status) == 'activo') text-success @endif">{{ucwords($producto->status)}} </span>
    </th>
    <td class="text-center"> <!-- Columna de descripción del producto -->
        {{ucfirst($producto->descripcion)}}
    </td>
    <td class="text-center"> <!-- Columna de categoría del producto -->
        {{ucwords($producto->categoria->nombre)}}
    </td>
    <td class="text-center"> <!-- Columna de sucursal del producto -->
        {{ucwords($producto->sucursal_id)}}
    </td>
<!--    <td>
        <li class="list-group-item"> <strong>{{$producto->precio_compra}} $</strong></li>
    </td>
    <td>
        <li class="list-group-item"> <strong> {{$producto->porcentaje_ganancia}} % ->({{$producto->precio_compra * ($producto->porcentaje_ganancia)/100}} $)</strong> </li>
    </td>
    <td>
        <li class="text-success list-group-item"> <strong>{{$producto->precio_venta == null ? 'No disponible' : $producto->precio_venta . '$'}} </strong></li>
    </td>-->
    <td class="text-center"> <!-- Botones de editar y eliminar -->
        <div>
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i> Editar</a>
        </div>
        <div>
        <button  type="button" class="btn btn-outline-danger btn-sm"  @click="deleteproducto({{$producto->id}})"><i class="bi bi-trash3-fill"> Eliminar</i></button>
        </div>
    </td>
</tr>
