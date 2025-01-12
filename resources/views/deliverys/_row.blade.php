<tr class="">
    <!-- <td>{{$i + 1}}</td> -->
    <th> <!-- Columna para ver el nombre del cliente, número de cédula y número de teléfono -->
        {{ucwords( $delivery->venta->cliente->nombre )}} <br>
        <span class="note">{{ $delivery->venta->cliente->tipo_documento}}-{{ $delivery->venta->cliente->num_documento}}</span>
        <span class="note">Teléfono: {{ $delivery->venta->cliente->telefono }}</span>
    </th>
    <td> <!-- Columna para ver los detalles del servicio a domicilio -->
        <div class="form-group">
            @foreach(explode(',',$delivery->venta->detalle_venta->productos_nombres) as $i=>$producto)
                <?php
                    $categorias=explode(',',$delivery->venta->detalle_venta->categorias_productos);
                    $cantidad=explode(',',$delivery->venta->detalle_venta->cantidad) ;
                    ?>
                <ul class="list-group-item-dark m-0">
                    <li> {{$categorias[$i]}} -> {{ucwords($producto)}} -> <strong>Cantidad:  {{$cantidad[$i]}}</strong></li>
                </ul>
            @endforeach
        </div>
    </td>
    <td class="text-center"> <!-- Columna para ver la dirección del servicio a domicilio -->
        <p>
            {{ucfirst($delivery->direccion)}} <br>
            Punto de Referencia: {{ucfirst($delivery->referencia)}} <br>
        </p>
    </td>
    <td class="text-center"> <!-- Columna para ver el repartidor y el costo del servicio a domicilio -->
        @if($delivery->user_id != null)
           <strong>{{ucwords($delivery->user->name)}} </strong>
        @else
            No Asignado
        @endif
        <br>
        <span class="card">Costo:<strong>{{$delivery->costo_delivery}} $ </strong></span>
    </td>
    <td size=""  class="@if($delivery->status === 'pendiente') text-danger @endif @if($delivery->status === 'proceso') text-info @endif @if($delivery->status === 'entregado') text-success @endif  text-center"> <!-- Columna para ver el estado del servicio a domicilio -->
        <strong>{{ucfirst($delivery->status)}}</strong> <br>
        @if($delivery->status == 'proceso' && auth()->user()->isDelivery())
            <button class="btn btn-outline-info" @click="registrarentrega({{auth()->user()->id}},{{$delivery->id}})">Registrar Entrega</button>
        @endif
        @if($delivery->status == 'entregado')
            <span>{{ucwords($delivery->detalles_entrega)}}</span><br>
            <span>{{ucwords($delivery->fecha_entrega)}}</span>
        @endif
    </td>
    <td class="text-center"> <!-- Columna para ver los botones de asignar repartidor y eliminar -->
        @if($delivery->status != 'entregado')
            @if(auth()->user()->isDelivery())
                
            @else
                <div> <!-- Botón de asignar repartidor desde el lado de los otros usuarios -->
                <button class="btn btn-outline-primary" @click="asignarrepartidor({{$delivery->id}})"><i class="bi bi-send-plus-fill"> Repartidor</i></button>
                </div>
                <div>
                <button type="button" class="btn btn-outline-danger" @click.prevent="deletedelivery({{$delivery->id}})"><i class="bi bi-trash3-fill"> Eliminar</i></button>
                </div>
            @endif
        @endif
    </td>
</tr>
