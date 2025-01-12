<tr class="" style="vertical-align: center">
    <!-- <td>{{$i + 1}}</td> -->
    <th> <!-- Columna para mostrar el nombre y actividad de la sucursal -->
        {{ucwords( $sucursal->nombre )}}
        <span class="status st-{{$sucursal->active == true   ? 'active' : 'inactive'}}"></span>
    </th>
    <td class="text-center"> <!-- Columna para mostrar el código de la sucursal -->
        {{strtoupper( $sucursal->codigo )}}
    </td>
    <td class="text-center"> <!-- Columna para mostrar la ubicación de la sucursal -->
        {{ucwords($sucursal->estado)}} - {{ucwords($sucursal->ciudad)}}<br>
    </td>
    <td class="text-center"> <!-- Columna para ver el registro al sistema -->
        <span>Registro al Sistema: {{ $sucursal->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-center"> <!-- Botones de editar y desactivar -->
        <div>
        <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"> Editar</i></a>
        </div>
        <div>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deletesucursal({{$sucursal->id}})"><i class="bi bi-x-circle-fill"> Desactivar</i></button>
        </div>
    </td>
</tr>
