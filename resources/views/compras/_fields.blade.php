@csrf
<div class="row">
    <div class="col-md-12">
        <h5>Proveedor</h5>
        <select name="proveedor_id" :disabled="datos" v-model="proveedor" id="proveedor_id" class="form-control text-center" :class="{'field-error': proveedor === ''  && error}">
            <option value="">--SELECCIONA--</option>
            @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}"{{ old('proveedor_id')}}>
                    {{ ucwords($proveedor->nombre)}} / {{$proveedor->rif}}
                </option>
            @endforeach
        </select>
    </div>

</div>
<hr>
<h5>Producto</h5>
<div class="card-header">
<div class="row">
    <div class="col-md-6">
        <select name="categoria_id" id="categoria_id" v-model="categoria_id" @change="selecproductos()" class="form-control text-center "  :class="{'field-error': categoria_id === ''  && error}">
            <option value="">--SELECCIONA CATEGORIA--</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id')}}>
                    {{ ucwords($categoria->nombre)}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <select name="producto" v-model="index_producto"  id="index_producto"  @change="verificarproducto()"  class="form-control text-center"  :class="{'field-error': index_producto === '' && error}">
            <option value="" >--SELECCIONA PRODUCTO--</option>
            <option v-for="(producto,index) in productos.nombres" :value="index">@{{ producto | upper}}</option>
        </select>
    </div>

</div>
<div class="row mt-1">
    <div class="col-md-6">
        <input type="number" placeholder="CANTIDAD" name="cantidad" min="1" v-model="cantidad" class="form-control text-center"  :class="{'field-error': cantidad === '' && error}">
    </div>
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">$</span>
                <input type="number" :readonly="disabledprecio" placeholder="PRECIO UNITARIO" name="precio_unitario" min="1" v-model="precio_unitario" class="form-control text-center"  :class="{'field-error': precio_unitario === ''  && error}">
            <span class="input-group-text">.00</span>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12 text-center" >
        <button class="btn btn-outline-primary" @click.prevent="agregarfila()"><i class="bi bi-plus-circle-fill"></i> Agregar</button>
    </div>
</div>
</div>
<div v-if="datos">
    <hr>
    <h5 class="text-center">Datos de la Compra</h5>
    <table class="table align-items-center mb-0" id="tabla_datos">
        <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7">#</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Producto</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Cantidad</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio Unitario</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Costo</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="(compras,index) in lista_compras.nombres ">
                <td class="align-middle text-center text-sm">@{{ index +1 }}</td>
                <td class="align-middle text-center text-sm">@{{ lista_compras.categoria[index] }} - @{{ compras }}</td>
                <td class="align-middle text-center text-sm"> @{{ lista_compras.cantidad[index] }}</td>
                <td class="align-middle text-center text-sm"> @{{ lista_compras.precio_unitario[index] }} $</td>
                <td class="align-middle text-center text-sm"> @{{ lista_compras.subtotal[index] }} $</td>
                <td align=middle>
                    <a class="btn btn-outline-danger btn-sm" type="button" @click.prevent="deletefila(index)"><i class="bi bi-trash3-fill"></i></a>
                </td>
            </tr>

        </tbody>
    </table>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class=" table table-striped table-hover table-responsive-md" align="right">
                <tr align="right" class="mt-2">
                    <td colspan="4">SUBTOTAL A PAGAR</td>
                    <td colspan="2"> @{{ lista_compras.subtotal_factura }} $</td>
                </tr>
                <tr align="right">
                    <td colspan="4">IVA (19%)</td>
                    <td colspan="2"> @{{ lista_compras.iva }} $</td>
                </tr>
                <tr align="right">
                    <th colspan="4">TOTAL FACTURA </th>
                    <th colspan="2"> @{{ lista_compras.total_factura }} $</th>
                </tr>
            </table>
        </div>
    </div>

</div>


<hr>



