<tr class="" style="vertical-align: center">
    <td>{{$i + 1}}</td>
    <th>
        {{ucwords( $sucursal->nombre )}}
        <span class="status st-{{$sucursal->active == true   ? 'active' : 'inactive'}}"></span>
    </th>
    <td>
        {{strtoupper( $sucursal->codigo )}}
    </td>
    <td>
        {{ucwords($sucursal->estado)}}-{{ucwords($sucursal->ciudad)}}<br>

    </td>
    <td>
        <span class="note">Registro: {{ $sucursal->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-right">
        <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deletesucursal({{$sucursal->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
