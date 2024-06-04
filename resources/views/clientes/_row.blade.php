<tr class="">
    <td>{{$i + 1}}</td>
    <th>
        {{ucwords( $cliente->nombre )}}
        <span class="status st-{{$cliente->status}}"></span>
        <span class="note">Cel : {{ $cliente->telefono }}</span>
    </th>
    <td>
        {{ucwords( $cliente->tipo_documento )}}-{{$cliente->num_documento}}
    </td>
    <td class="text-center">
        {{ucfirst($cliente->direccion)}} <br>
        <span class="note text-info"><strong>{{ucfirst($cliente->email)}}</strong></span>
    </td>
    <td>
        <span class="note">Registro: {{ $cliente->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-right">
        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deletecliente({{$cliente->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
