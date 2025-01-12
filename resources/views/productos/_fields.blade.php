@csrf

<!-- Bloque de categoría, sucursal y nombre del producto -->

<div class="row">
    <div class="col-md-3"> <!-- Categoría -->
        <span class="note info text-white" v-if="showinfo" >Seleccione la categoría a la que pertenece el producto</span>
        <label for="sucursal_id">* Categoría: <button @click.prevent="verificarinfo()" id="sucursal_id" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select name="categoria_id" id="categoria_id" class="form-control text-center @if( $errors->get('categoria_id')) field-error @endif"> 
            <option value="">-- Seleccionar Categoría --</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id',$producto->categoria_id)==$categoria->id ? ' selected' : '' }}>
                    {{ ucwords($categoria->nombre) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3"> <!-- Sucursal -->
        <span class="note info text-white" v-if="showinfo" >Seleccione la sucursal a la que pertenece el producto</span>
        <label for="sucursal">* Sucursal: <button @click.prevent="verificarinfo()" id="sucursal" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select name="sucursal_id"  id="sucursal_id" class="form-control text-center">
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}"{{ old('sucursal_id'.$producto->sucursal_id) == $sucursal->id ? 'selected' : ''}} >
                    {{ ucwords($sucursal->nombre)}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6"> <!-- Nombre del producto -->
        <div class="form-group">
            <span class="note info text-white" v-if="showinfo" >Ingrese el nombre del producto</span>
            <label for="nombre">* Nombre del Producto: <button @click.prevent="verificarinfo()" id="nombre" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <textarea type="nombre" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" placeholder="Ej: Audífonos Samsung" autocomplete="off" minlength="5" title="Debe ser mayor o igual a 5 caracteres"></textarea>
        </div>
    </div>

</div>

<!-- Bloque de imagen referencial y descripcion -->

<div class="row"> 
<!--    <div class="form-group col-md-4">
        <label for="cantidad">Cantidad</label>
        <input type="number" min="0" class="form-control text-center @if( $errors->get('cantidad')) field-error @endif" name="cantidad" id="cantidad"  value="{{ old('cantidad',$producto->cantidad) }}">
    </div>-->
    <div class="col-md-4"> <!-- Imagen del producto -->
        <span class="note info text-white" v-if="showinfo" >Debe agregar una imagen que sea del producto a registrar y solo se admite formato PNG, JPG y JEPG</span>
        <p>* Imagen Referencial del Producto</p>
        <input style="background-color: #0dcaf0 " type="file" name="photo" class="form-input-file @if( $errors->get('photo')) field-error @endif" accept="image/*" >
        @if($producto->photo)
            <div class="container mt-2" style="display: flex; justify-content: center">
                <p><strong>Imagen Actual</strong></p>
                <img src="{{asset('storage/productos/'. $producto->photo)}}" class="card-img" height="200" width="200" alt="producto">
            </div>
        @endif
    </div>

    <div class="form-group col-md-7 ml-5"> <!-- Descrición del producto -->
        <span class="note info text-white" v-if="showinfo" >Descripción adicional del producto</span>
        <label for="descripcion">* Descripción del Producto: <button @click.prevent="verificarinfo()" id="descripcion" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <textarea type="text" class="form-control @if( $errors->get('descripcion')) field-error @endif" name="descripcion" id="descripcion" value="{{ old('descripcion',$producto->descripcion) }}" placeholder="Ej: Audífonos Samsung Galaxy Buds - Negro" minlength="10" title="Debe ser mayor o igual a 10 caracteres"></textarea>
    </div>
</div>
<div class="row pt-3">
    <label>* Campos obligatorios</label>
</div>
@if(auth()->user()->isAdmin())

<!--<div class="row card-header">
    <div class="col-md-4 text-center">
        <label for="precio_compra"> <strong>Precio Compra ($)</strong></label>
        <input type="number" min="0" class="form-control text-center @if( $errors->get('precio_compra')) field-error @endif" name="precio_compra" id="precio_compra" @keyup="setprecio()" v-model="precio_compra"  value="{{ old('precio_compra',$producto->precio_compra) }}">
        <input type="hidden" :value="tasa_dolar.price" name="tasa_bcv">
        <label for="precio_compra"> <strong>Precio Compra (Bs)</strong></label>
        <input type="number" readonly :value="precio_bs" class="form-control text-center" >
    </div>

</div>-->

@endif
<hr>



