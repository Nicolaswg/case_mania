<tr class="" style="vertical-align: center">
    <!-- <td>{{$i + 1}}</td> -->
    <th>
        {{ucwords( $categoria->nombre )}} <!-- Columna del nombre de la categoría -->
        <span class="status st-{{$categoria->active == true   ? 'active' : 'inactive'}}"></span>
    </th>
    <td>
        <div class="form-group text-center"> <!-- Productos de la categoría -->
            @foreach($categoria->productos as $i=>$producto)
                <ul class="list-unstyled m-0">
                    <li>{{$i+1}}. {{ucwords($producto->nombre)}} / {{ucfirst($producto->descripcion)}}</li>
                </ul>
            @endforeach
        </div>

    </td>
    <td> <!-- Columna de la fecha de registro -->
        <span class="note text-center">Registro: {{ $categoria->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-center"> <!-- Botones de editar y desactivar la categoría -->
        <div class=>
        <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"> Editar</i></a>
        </div>
        <div>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deletecategoria({{$categoria->id}})"><i class="bi bi-x-circle-fill"> Desactivar</i></button>
        </div>
    </td>
</tr>
