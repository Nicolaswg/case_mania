<tr class="" align="center">
    <td>{{$i + 1}}</td>
    <td>
        <div style="display: flex; justify-content: center">
            <img src="{{asset('storage/productos/'.$producto->photo)}}" class="img-thumbnail" width="100" height="100" alt="{{'Foto'.$producto->photo}}">
        </div>
    </td>
    <th>
        {{ucwords($producto->nombre)}}
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
    <td class="text-right">
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
    </td>
</tr>
