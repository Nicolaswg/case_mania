<tr class="">
    <td>{{$i + 1}}</td>
    <th>
        {{ucwords( $proveedor->nombre )}}
        <span class="status st-{{$proveedor->status}}"></span>
        <span class="note">Cel : {{ $proveedor->num_cel }}</span>
    </th>
    <td>
        <span class="note">Registro: {{ $proveedor->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-right">
        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deleteproveedor({{$proveedor->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
