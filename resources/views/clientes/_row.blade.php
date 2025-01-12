<tr class="">
    <!-- <td>{{$i + 1}}</td> -->
    <th> <!-- Columna para mostrar el nombre, estado de actividad y el documento de identidad -->
        {{ucwords( $cliente->nombre )}}
        <span class="status st-{{$cliente->status}}"></span>
        <span class="note">Documento: {{ucwords( $cliente->tipo_documento )}}-{{$cliente->num_documento}}</span>
    </th>
    <td class="text-center"> <!-- Columna para mostrar el número de teléfono y el correo electrónico -->
        <span class="">{{ $cliente->telefono }}</span>
        <span class="note text-info"><strong>{{ucfirst($cliente->email)}}</strong></span>
    </td>
    <td class="text-center"> <!-- Columna para mostrar la dirección -->
        {{ucfirst($cliente->direccion)}}
    </td>
    <td class="text-center"> <!-- Columna para mostrar la fecha de registro -->
        <span class="note">Registro: {{ $cliente->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-center"> <!-- Columna para mostrar los botones de editar y desactivar -->
        <div>
        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i> Editar</a>
        </div>
        <div>
        <button type="button" class="btn btn-outline-danger btn-sm" @click.prevent="deletecliente({{$cliente->id}})"><i class="bi bi-x-circle-fill"> Desactivar</i></button>
        </div>
    </td>
</tr>
