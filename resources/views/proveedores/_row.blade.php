<tr class="container">
    <!-- <td>{{$i + 1}}</td> -->
    <th>
        {{ucwords( $proveedor->nombre )}}
        <span class="status st-{{$proveedor->status}}"></span>
        <span class="note">Rif: {{ $proveedor->tipo}}-{{ $proveedor->rif}}</span>
    </th>
    <td>
        <span class="text-center">{{ $proveedor->num_cel }}</span>
    </td>
    <td>
        <span class="note text-center">Registro: {{ $proveedor->created_at->format('d/m/Y') }}</span>
    </td>
    <td>
        <span class="note text-center">{{strtoupper( $proveedor->categoria->nombre)}}</span>
    </td>
    <td class="text-right">
        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar" href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Desactivar" class="btn btn-outline-danger btn-sm" @click.prevent="deleteproveedor({{$proveedor->id}})"><i class="bi bi-x-circle-fill"></i></button>
    </td>
</tr>
