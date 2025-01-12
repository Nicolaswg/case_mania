<tr class="container">
    <!-- <td>{{$i + 1}}</td> -->
    <th> <!-- Columna para mostar el nombre, el estado y el rif del proveedor -->
        {{ucwords( $proveedor->nombre )}}
        <span class="status st-{{$proveedor->status}}"></span>
        <span class="note">Rif: {{ $proveedor->tipo}}-{{ $proveedor->rif}}</span>
    </th>
    <td class="text-center"> <!-- Columna para mostrar el número de teléfono y el correo electrónico -->
        <span>{{ $proveedor->num_cel }}</span><br>
        <!-- <span class="text-info"><strong></strong></span> -->
    </td> <!-- Columna para mostrar la fecha de registro del proveedor -->
    <td class="text-center"> 
        <span class="note">Registro: {{ $proveedor->created_at->format('d/m/Y') }}</span>
    </td> <!-- Columna para mostrar la categoría asociada del proveedor -->
    <td class="text-center"> 
        <span class="note text-center">{{strtoupper( $proveedor->categoria->nombre)}}</span>
    </td>
    <td class="text-center"> <!-- Columna para mostrar los botones de editar y desactivar el proveedor -->
        <div>
        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"> Editar</i></a>
        </div>
        <div>
        <button type="button" class="btn btn-outline-danger btn-sm" @click.prevent="deleteproveedor({{$proveedor->id}})"><i class="bi bi-x-circle-fill"> Desactivar</i></button>
        </div>
    </td>
</tr>
