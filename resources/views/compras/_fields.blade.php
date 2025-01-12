@csrf

<!-- Bloque para proveedor -->

<div class="row">
    <div class="col-md-12">
    <span class="note info text-white" v-if="showinfo" >Debe seleccionar un proveedor</span>
        <h5 for="proveedor">* Proveedor: <button @click.prevent="verificarinfo()" id="proveedor" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></h5>
        <div class="input-group">
        <select name="proveedor_id" :disabled="datos" v-model="proveedor" id="proveedor_id" class="form-control text-center" :class="{'field-error': proveedor === ''  && error}" @change="selecproductos()">
            <option value="">-- Seleccionar Proveedor --</option>
            @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}"{{ old('proveedor_id')}}>
                    {{ ucwords($proveedor->nombre)}} / {{$proveedor->tipo}}-{{$proveedor->rif}}
                </option>
            @endforeach
        </select>

        <!-- Botón para registrar nuevo -->
        <a class="btn btn-outline-danger" href="{{route('proveedores.create')}}" target="_blank" type="button" id="button-addon2">Nuevo Proveedor</a>
        <input type="hidden" value="{{$sucursal->id}}" name="sucursal_id">
        </div>
    </div>
</div>
<hr>
<h5>* Características del Producto:</h5> <!-- Clasificación de los productos -->
<div class="card-header">
<div class="row">
    <div class="col-md-6"> <!-- Categoría asociada -->
        <label for="">Categoría Asociada</label>
        <input type="text" disabled v-model="productos.nombre_categoria">
    </div>
    <div class="col-md-6"> <!-- Seleccionar producto -->
        <select name="producto" v-model="index_producto"  id="index_producto"  @change="verificarproducto()"  class="form-control text-center"  :class="{'field-error': index_producto === '' && error}">
            <option value="" >-- Seleccionar Producto --</option>
            <option v-for="(producto,index) in productos.nombres" :value="index">@{{ producto | upper}}</option>
        </select>
    </div>
</div>
<div class="row mt-1"> <!-- Cantidad del producto-->
    <div class="col-md-6">
        <input type="number" min="1" step="1" placeholder="Ingresar la Cantidad del Producto" name="cantidad" v-model="cantidad" class="form-control text-center"  :class="{'field-error': cantidad === '' && error}" autocomplete="off" title="Solo números enteros">
    </div>
    <div class="col-md-6"> <!-- Precio por producto -->
        <div class="input-group mb-3">
                <input type="number" :readonly="disabledprecio" placeholder="Ingresar el Precio Unitario" name="precio_unitario" min="0.01" v-model="precio_unitario" class="form-control text-center"  :class="{'field-error': precio_unitario === ''  && error}" autocomplete="off" minlength="1" maxlength="4" step="0.01" title="Solo números con 2 decimales">
                <span class="input-group-text">$</span>
        </div>
    </div>
</div>
<label>* Campos Obligatorios</label>
<div class="row mt-2"> <!-- Botón para agregar fila de producto -->
    <div class="col-md-12 text-center" >
        <button class="btn btn-outline-danger btn-lg" @click.prevent="agregarfila()"><i class="bi bi-plus-circle-fill" ></i> Agregar Compra</button>
    </div>
</div>
</div>
<div v-if="datos"> <!-- Detalles de la tabla cuando se agrega un producto -->
    <hr>
    <h5 class="text-center">Detalles de la Compra</h5> <!-- Subtítulos de la tabla -->
    <table class="table align-items-center mb-0" id="tabla_datos">
        <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7" >Renglón</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Código del Producto</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Categoría del Producto</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Nombre del Producto</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2" >Cantidad</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio Unitario</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2" >Subtotal</th>
            <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" >Total a Pagar</th> -->
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="(compras,index) in lista_compras.nombres "> <!-- Datos ingresados de la tabla -->
                <td class="align-middle text-center text-sm">@{{ index +1 }}</td>
                <td class="align-middle text-center text-sm">00@{{ lista_compras.ids[index] }} </td>
                <td class="align-middle text-center text-sm">@{{ lista_compras.categoria[index] }} </td>
                <td class="align-middle text-center text-sm"> @{{ compras }}</td>
                <td class="align-middle text-center text-sm"> @{{ lista_compras.cantidad[index] }}</td>
                <td class="align-middle text-center text-sm"> @{{ lista_compras.precio_unitario[index] }} $</td>
                <td class="align-middle text-center text-sm"> @{{ lista_compras.subtotal[index] }} $</td>
                <td align=middle>
                    <a class="btn btn-outline-danger btn-sm" type="button" @click.prevent="deletefila(index)"><i class="bi bi-trash3-fill"> Eliminar</i></a>
                </td>
            </tr>

        </tbody>
    </table>
    <div class="row"> <!-- Tabla de cálculo de la factura -->
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <table class=" table table-striped table-hover table-responsive-md" align="right">
                <thead>
                <tr align="right">
                    <th colspan="5">Dólares ($)</th>
                    <th colspan="4">Bolívares (Bs.)</th>
                </tr>
                </thead>
                <tbody>
                <tr align="right" class="mt-2"> <!-- Subtotal -->
                    <td colspan="3">Subtotal a Pagar</td>
                    <td colspan="2"> @{{ lista_compras.subtotal_factura }} $ </td>
                    <td class="text-center">@{{  bs.subtotal }} Bs. D</td>
                </tr>
                <tr align="right">
                    <td colspan="3">I.V.A (16%)</td> <!-- I.V.A -->
                    <td colspan="2"> - </td>
                    <td class="text-center">@{{ bs.iva }} Bs. D</td>
                </tr>
                <tr align="right" class="" style=" border: double #051b11;" >
                    <th colspan="3">Total de la Factura </th> <!-- Total de la Factura -->
                    <th colspan="2">@{{ lista_compras.subtotal_factura }} $ </th>
                    <td class="text-center  fw-bold ">@{{  bs.total_factura }} Bs. D</td>
                </tr>
                <tr align="right" class="" style=" border: double #051b11;" >
                    <th colspan="3">I.G.T.F </th> <!-- IGTF -->
                    <th colspan="2">@{{ lista_compras.subtotal_factura }} $ </th>
                    <td class="text-center  fw-bold "> - </td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>

</div>

<hr>



