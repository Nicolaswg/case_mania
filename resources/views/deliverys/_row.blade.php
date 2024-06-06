<tr class="">
    <td>{{$i + 1}}</td>
    <th>
        {{ucwords( $delivery->venta->cliente->nombre )}} <br>
        {{ $delivery->venta->cliente->tipo_documento}}-{{ $delivery->venta->cliente->num_documento}} <br>
        <span class="">Cel : {{ $delivery->venta->cliente->telefono }}</span>
    </th>
    <td>
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
    <td class="text-center">
        <p>
            {{ucfirst($delivery->direccion)}} <br>
            Referencia: {{ucfirst($delivery->referencia)}} <br>
        </p>
    </td>
    <td class="text-center">
        @if($delivery->user_id != null)
           <strong>{{ucwords($delivery->user->name)}} </strong>
        @else
            No Asignado
        @endif
        <br>
        <span class="card">Costo:<strong>{{$delivery->costo_delivery}} $ </strong></span>
    </td>
    <td size=""  class="@if($delivery->status === 'pendiente') text-danger @endif @if($delivery->status === 'proceso') text-info @endif @if($delivery->status === 'entregado') text-success @endif  text-center">
        <strong>{{ucfirst($delivery->status)}}</strong> <br>
        @if($delivery->status == 'proceso' && auth()->user()->isDelivery())
            <button class="btn btn-outline-info" @click="registrarentrega({{auth()->user()->id}},{{$delivery->id}})">Registrar Entrega</button>
        @endif
        @if($delivery->status == 'entregado')
            <span>{{ucwords($delivery->detalles_entrega)}}</span><br>
            <span>{{ucwords($delivery->fecha_entrega)}}</span>
        @endif

    </td>
    <td class="text-right">
        @if($delivery->status != 'entregado')
            @if(auth()->user()->isDelivery())
                <button class="btn btn-outline-primary" @click="asignarrepartidor({{$delivery->id}})"><i class="bi bi-send-plus-fill"></i> </button>
            @else
                <button class="btn btn-outline-primary" @click="asignarrepartidor({{$delivery->id}})"><i class="bi bi-send-plus-fill"></i> </button>
                <a href="{{ route('delivery.edit', $delivery) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deletedelivery({{$delivery->id}})"><i class="bi bi-trash3-fill"></i></button>
            @endif
        @endif


    </td>
</tr>
