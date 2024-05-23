@csrf
<div class="row">
    <div class="col-md-6">
        <label for="sucursal_id">Categoria</label>
        <select name="categoria_id" id="categoria_id" class="form-control text-center @if( $errors->get('categoria_id')) field-error @endif">
            <option value="">--SELECCIONA--</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id',$producto->categoria_id)==$categoria->id ? ' selected' : '' }}>
                    {{ ucwords($categoria->nombre) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="nombre" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}">
        </div>
    </div>

</div>
<div class="row">
    <div class="form-group col-md-4">
        <label for="cantidad">Cantidad</label>
        <input type="number" class="form-control text-center @if( $errors->get('cantidad')) field-error @endif" name="cantidad" id="cantidad"  value="{{ old('cantidad',$producto->cantidad) }}">
    </div>

    <div class="form-group col-md-8">
        <label for="descripcion">Descripcion</label>
        <input type="text" class="form-control @if( $errors->get('descripcion')) field-error @endif" name="descripcion" id="descripcion" value="{{ old('descripcion', $producto->descripcion) }}">
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label for="">Imagen</label>
        <input style="background-color: #0dcaf0 " type="file" name="photo" class="form-input-file" accept="image/*" >
        @if($producto->photo)
            <div class="container mt-2" style="display: flex; justify-content: center">
                <p><strong>Imagen Actual</strong></p>
                <img src="{{asset('storage/productos/'. $producto->photo)}}" class="card-img" height="200" width="200" alt="producto">
            </div>
        @endif
    </div>

</div>

<hr>



