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
       {{$producto->cantidad}} <br>
        <span class="note">Sucursal : {{ucwords($producto->sucursal->nombre)}}</span>
    </td>

    <td>
        @if($producto->cantidad_devueltos != null)
            <li class=" text-danger"> <strong> {{$producto->cantidad_devueltos}} </strong> </li>
        @else
            <p class="text-success">Sin Existencia</p>
        @endif
    </td>

</tr>
