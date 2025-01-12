<tr class="" align="center">
<!--     <td>{{$i + 1}}</td> -->
    <td> <!-- Columna de imagen del producto -->
        <div style="display: flex; justify-content: center">
            <img src="{{asset('storage/productos/'.$producto->photo)}}" class="img-thumbnail" width="100" height="100" alt="{{'Foto'.$producto->photo}}">
        </div>
    </td>
    <th> <!-- Columna de nombre y estado de actividad del producto -->
        {{ucwords($producto->nombre)}}<br>
       <span class="@if(strtolower($producto->status) == 'inactivo') text-danger @endif @if(strtolower($producto->status) == 'activo') text-success @endif">{{ucwords($producto->status)}} </span>
    </th>
    <td> <!-- Columna de descripción del producto -->
        {{ucfirst($producto->descripcion)}}
    </td>
    <td> <!-- Columna de nombre de la categoría -->
        {{ucwords($producto->categoria->nombre)}}
    </td>
        <?php //Función para la cantidad total del productos y cantidad por sucursal del producto
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
                    if($prod != null){
                        $canti[$i]=$prod->cantidad;
                    }else{
                        $canti[$i]=0;
                    }
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
        <th> <!-- Columna de cantidad total del producto -->
        {{$tot}}
        </th>
    <td> <!-- Columna que menciona si el producto se le ha configurado el precio de venta -->
        @if($producto->porcentaje_ganancia == null)
            <span class="text-danger">Por Configurar</span>
        @else
            <span class="text-success">Configurado</span>
        @endif
    </td>
        <td> <!-- Columna que visualiza la cantidad de los productos por sucursal -->
        <table>
            <tbody>
                <tr class="text-center">
                    <!-- <th rowspan="{{count($nombre_sucur) + 1}}">{{$tot}}</th> -->
                    @foreach($nombre_sucur as $i=>$sucur)
                        <tr class="text-center">
                            <td>{{$sucur}} : {{$canti[$i]}}</td>
                        </tr>

                    @endforeach
                </tr>
            </tbody>
        </table>
    </td>

    <td> <!-- Columna que menciona la cantidad de productos devueltos -->
        @if($producto->cantidad_devueltos != null)
            <li class=" text-danger"> <strong> {{$producto->cantidad_devueltos}} </strong> </li>
        @else
            <p class="text-success">Sin Existencia</p>
        @endif
    </td>
    <td class="text-center"> <!-- Columna que muestra los botones de precio de venta y traslado -->
    @if($producto->cantidad != 0)
        <div>
        <a href="{{ route('almacen.configurar_venta', $producto) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-currency-dollar"></i> Precio Venta</a>
        </div>
        <div>
        <a href="{{ route('almacen.traslados', $producto) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-truck"> Trasladar</i></a>
        </div>
    @endif
    </td>
</tr>
