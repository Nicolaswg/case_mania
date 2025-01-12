<tr class="">
    <!-- <td>{{$i + 1}}</td> -->
    <th> <!-- Columna para mostrar nombre del cliente, cédula de identidad, número de teléfono y correo electrónico -->
        {{ucwords( $servicio->cliente->nombre)}} <br>
        <span class="note">{{  $servicio->cliente->tipo_documento }}-{{  $servicio->cliente->num_documento }}</span>
        <span class="note">Número de Teléfono: {{  $servicio->cliente->telefono }}</span>
        <span class="note">Correo Electrónico: {{  $servicio->cliente->email == null ?: 'Sin Email' }}</span>
    </th>
    <td class="text-center"> <!-- Columna para mostrar el usuario que recibe el servicio y la fecha -->
        {{ucwords($servicio->user)}} <br>
       {{ \Carbon\Carbon::parse($servicio->fecha_recibido)->format('d-m-y h:i A') }}
    </td>
    <td class="text-center"> <!-- Columna para mostrar el producto -->
        @foreach(explode(',',$servicio->productos) as $i=>$producto)
            <ul class="list-unstyled m-0">
                <li>{{$producto}}</li>
            </ul>
        @endforeach
    </td>
    <td class="text-center"> <!-- Columna para mostrar la cantidad del producto -->
        @foreach(explode(',',$servicio->cantidad) as $i=>$cantidad)
            <ul class="list-unstyled m-0">
                <li>{{$cantidad}}</li>
            </ul>
        @endforeach
    </td>
    <td class="text-center"> <!-- Columna para mostrar la falla registrada -->
        @foreach(explode(',',$servicio->falla) as $i=>$falla)
            <ul class="list-unstyled m-0">
                <li>{{$falla}}</li>
            </ul>
        @endforeach
    </td> <!-- Columna para mostrar el estado del servicio técnico -->
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
    <td> <!-- Columna para mostrar que ha sido recibido -->
        <p class="@if($servicio->status == 'recibido') text-info @else text-success  @endif" ><strong>{{ucwords( $servicio->status)}}</strong></p>
    </td>
    <td class="text-center"> <!-- Columna para mostrar el costo del servicio técnico -->
        @if($servicio->costo_dolar != null)
            <p class="mb-0">Costo $: <strong>{{$servicio->costo_dolar }}</strong> </p>
            <p class="mt-0 mb-0">Costo Bs: <strong>{{$servicio->costo_bolivar }}</strong> </p>
        @else
            <button class="btn btn-sm btn-outline-dark" @click="setcosto({{$servicio->id}})">Registrar Costo</button>
        @endif

    </td>

    <td class="text-center"> <!-- Columna para mostrar los botones de cambiar estado, exportar, editar y eliminar -->
        <div>
        @if( $servicio->status == 'recibido' && $servicio->costo_dolar != null)
            <button class="btn btn-outline-info btn-sm" @click="changestatus({{$servicio->id}})"><i class="bi bi-send-fill"> Entregar</i></button>
        @endif
        </div>
        <div>
        <a href="{{ route('servicio.showpdf', $servicio) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-break"> Exportar</i></a>
        </div>
        <div>
        <a href="{{ route('servicio.edit', $servicio) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"> Editar</i></a>
        </div>
        <div>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deleteservicio({{$servicio->id}})"><i class="bi bi-trash3-fill"> Eliminar</i></button>
        </div>
    </td>
</tr>
