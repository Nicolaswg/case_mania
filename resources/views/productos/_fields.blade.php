@csrf
<div class="row">
    <div class="col-md-3">
        <label for="sucursal_id">* Categoría:</label>
        <select name="categoria_id" id="categoria_id" class="form-control text-center @if( $errors->get('categoria_id')) field-error @endif">
            <option value="">-- Seleccionar Categoría --</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id',$producto->categoria_id)==$categoria->id ? ' selected' : '' }}>
                    {{ ucwords($categoria->nombre) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label for="sucursal">* Sucursal:</label>
        <select name="sucursal_id"  id="sucursal_id" class="form-control text-center">
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}"{{ old('sucursal_id'.$producto->sucursal_id) == $sucursal->id ? 'selected' : ''}} >
                    {{ ucwords($sucursal->nombre)}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre">* Nombre del Producto:</label>
            <input type="nombre" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" placeholder="Ej: Audífonos Samsung" autocomplete="off">
        </div>
    </div>

</div>
<div class="row">
<!--    <div class="form-group col-md-4">
        <label for="cantidad">Cantidad</label>
        <input type="number" min="0" class="form-control text-center @if( $errors->get('cantidad')) field-error @endif" name="cantidad" id="cantidad"  value="{{ old('cantidad',$producto->cantidad) }}">
    </div>-->
    <div class="col-md-4">
        <p>* Imagen referencial del Producto</p>
        <input style="background-color: #0dcaf0 " type="file" name="photo" class="form-input-file @if( $errors->get('photo')) field-error @endif" accept="image/*" >
        @if($producto->photo)
            <div class="container mt-2" style="display: flex; justify-content: center">
                <p><strong>Imagen Actual</strong></p>
                <img src="{{asset('storage/productos/'. $producto->photo)}}" class="card-img" height="200" width="200" alt="producto">
            </div>
        @endif
    </div>

    <div class="form-group col-md-7 ml-5">
        <label for="descripcion">* Descripción del Producto:</label>
        <textarea type="text" class="form-control @if( $errors->get('descripcion')) field-error @endif" name="descripcion" id="descripcion" value="{{ old('descripcion',$producto->descripcion) }}" placeholder="Ej: Audífonos Samsung Galaxy Buds - Negro"></textarea>
    </div>
</div>
@if(auth()->user()->isAdmin())
    <hr>
<!--<div class="row card-header">
    <div class="col-md-4 text-center">
        <label for="precio_compra"> <strong>Precio Compra ($)</strong></label>
        <input type="number" min="0" class="form-control text-center @if( $errors->get('precio_compra')) field-error @endif" name="precio_compra" id="precio_compra" @keyup="setprecio()" v-model="precio_compra"  value="{{ old('precio_compra',$producto->precio_compra) }}">
        <input type="hidden" :value="tasa_dolar.price" name="tasa_bcv">
        <label for="precio_compra"> <strong>Precio Compra (Bs)</strong></label>
        <input type="number" readonly :value="precio_bs" class="form-control text-center" >
    </div>
    <div class="col-md-4 text-center">
        <label for="porcentaje_ganancia"><strong>Porcentaje de Ganancia</strong></label>
        <input type="number" min="1" max="100" class="form-control text-center @if( $errors->get('porcentaje_ganancia')) field-error @endif" :readonly="precio_compra===''" v-model="porcentaje_ganancia" name="porcentaje_ganancia" id="porcentaje_ganancia" @keyup="setprecio()" placeholder="%"  value="{{ old('porcentaje_ganancia',$producto->porcentaje_ganancia) }}">
        <label for="precio_compra"> <strong>Ganancia en Bs</strong></label>
        <input type="number" readonly :value="ganancia_bs" class="form-control text-center" >
    </div>
    <div class="col-md-4 text-center">
        <label for="precio_venta"><strong>Precio de Venta ($)</strong></label>
        <input type="number" class="form-control text-center @if( $errors->get('precio_venta')) field-error @endif" name="precio_venta" id="precio_venta" v-model="precio_venta" readonly value="{{ old('precio_venta',$producto->precio_venta) }}">
        <label for="precio_compra"> <strong>Precio Venta (Bs)</strong></label>
        <input type="number" readonly :value="total_bs" class="form-control text-center"  >
    </div>
</div>-->
    <hr>
@endif
<hr>



