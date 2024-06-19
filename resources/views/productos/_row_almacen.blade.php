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
        <?php
        $canti=[];
        $nombre_sucur=[];
        foreach ($sucursales as $i=>$sucursal){
            $nombre_sucur[$i]=$sucursal->nombre;
            if(count($producto->almacen) != 0){
                $produc=$sucursal->almacen()->where('sucursal_id',$sucursal->id )->where('producto_id',$producto->id)->orderBy('created_at')->first();
                if($produc != null){
                    $canti[$i]=$produc->cantidad_acumulada;
                }else{
                    $prod=$sucursal->productos->where('sucursal_id',$sucursal->id)->where('id',$producto->id)->first();
                    $canti[$i]=$prod->cantidad;
                }
            }else{
                $prod=$sucursal->productos->where('sucursal_id',$sucursal->id)->where('id',$producto->id)->first();
                if($prod != null){
                    $canti[$i]=$prod->cantidad;
                }else{
                    $canti[$i]=0;
                }
            }

        }
            $tot=array_sum($canti);
        ?>
        <table>
            <thead>
                <tr class="text-center">
                    <th rowspan="">Cantidad Total</th>
                    <th colspan="4" class="text-center">Distribucion</th>
                </tr>
            </thead>
            <tbody>

                <tr class="text-center">
                    <th rowspan="{{count($nombre_sucur) + 1}}">{{$tot}}</th>
                    @foreach($nombre_sucur as $i=>$sucur)
                        <tr class="text-center">
                            <td>{{$sucur}} : {{$canti[$i]}}</td>
                        </tr>

                    @endforeach
                </tr>
            </tbody>
        </table>
    </td>

    <td>
        @if($producto->cantidad_devueltos != null)
            <li class=" text-danger"> <strong> {{$producto->cantidad_devueltos}} </strong> </li>
        @else
            <p class="text-success">Sin Existencia</p>
        @endif
    </td>
<td>
    <a href="{{ route('almacen.traslados', $producto) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-truck"></i></a>
</td>
</tr>
