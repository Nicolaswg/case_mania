<tr class="" style="vertical-align: center">
    <td>{{$i + 1}}</td>
    <th>
        {{ucwords( $categoria->nombre )}}
        <span class="status st-{{$categoria->active == true   ? 'active' : 'inactive'}}"></span>
    </th>
    <td>
        <div class="form-group">
            @foreach($categoria->productos as $i=>$producto)
                <ul class="list-unstyled m-0">
                    <li>{{$i+1}}. {{ucwords($producto->nombre)}} / {{ucfirst($producto->descripcion)}}</li>
                </ul>
            @endforeach
        </div>

    </td>
    <td>
        <span class="note">Registro: {{ $categoria->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-right">
        <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
        <button type="button"  class="btn btn-outline-danger btn-sm" @click.prevent="deletecategoria({{$categoria->id}})"><i class="bi bi-trash3-fill"></i></button>
    </td>
</tr>
