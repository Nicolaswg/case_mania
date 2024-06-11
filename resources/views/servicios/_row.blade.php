<tr class="">
    <td>{{$i + 1}}</td>
    <th>
        {{ucwords( $servicio->cliente->nombre)}} <br>
        <span class="note">{{  $servicio->cliente->tipo_documento }} - {{  $servicio->cliente->num_documento }}</span>
        <span class="note">Cel : {{  $servicio->cliente->telefono }}</span>
        <span class="note">Email : {{  $servicio->cliente->email == null ?: 'Sin Email' }}</span>
    </th>
    <td class="text-center">
        {{ucwords($servicio->user)}} <br>
       {{ \Carbon\Carbon::parse($servicio->fecha_recibido)->format('d-m-y h:i A') }}
    </td>
    <td class="text-center">

        @foreach(explode(',',$servicio->productos) as $i=>$producto)
            <ul class="list-unstyled m-0">
                <li>{{$producto}}</li>
            </ul>
        @endforeach
    </td>
    <td class="text-center">
        @foreach(explode(',',$servicio->cantidad) as $i=>$cantidad)
            <ul class="list-unstyled m-0">
                <li>{{$cantidad}}</li>
            </ul>
        @endforeach
    </td>
    <td class="text-center">
        @foreach(explode(',',$servicio->falla) as $i=>$falla)
            <ul class="list-unstyled m-0">
                <li>{{$falla}}</li>
            </ul>
        @endforeach
    </td>
    @if($servicio->status == 'entregado')
        <th class="text-success">
            @foreach(explode(',',$servicio->falla) as $i=>$falla)
                <ul class="list-unstyled m-0">
                    <li>Corregido</li>
                </ul>
            @endforeach
        </th>
    @else
        <th class="text-danger">
            @foreach(explode(',',$servicio->falla) as $i=>$falla)
                <ul class="list-unstyled m-0">
                    <li>Pendiente</li>
                </ul>
            @endforeach
        </th>
    @endif
    <td>
        <p class="@if($servicio->status == 'recibido') text-info @else text-success  @endif" ><strong>{{ucwords( $servicio->status)}}</strong></p>
    </td>
    <td class="text-center">
        @if($servicio->costo_dolar != null)
            <p class="mb-0">Costo $: <strong>{{$servicio->costo_dolar }}</strong> </p>
            <p class="mt-0 mb-0">Costo Bs: <strong>{{$servicio->costo_bolivar }}</strong> </p>
        @else
            <button class="btn btn-sm btn-outline-dark" @click="setcosto({{$servicio->id}})">Registrar Costo</button>
        @endif

    </td>

    <td class="text-right">
        @if( $servicio->status == 'recibido' && $servicio->costo_dolar != null)
            <button class="btn btn-outline-info btn-sm" @click="changestatus({{$servicio->id}})"><i class="bi bi-send-fill"></i></button>
        @endif
        <a href="{{ route('servicio.showpdf', $servicio) }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-break"></i></a>
        <a href="{{ route('servicio.edit', $servicio) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deleteservicio({{$servicio->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
