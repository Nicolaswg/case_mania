@csrf
<div class="row">
    <div class="col-md-8">
        <h5>Cliente</h5>
        <div class="input-group">
            <select name="cliente_id" :disabled="datos" v-model="cliente" id="cliente_id" class="form-control text-center" :class="{'field-error': cliente === ''  && error}">
                <option value="">--SELECCIONA--</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}"{{ old('cliente_id')}}>
                        {{ ucwords($cliente->nombre)}} / {{$cliente->num_documento}}
                    </option>
                @endforeach
            </select>
            <a class="btn btn-outline-primary" href="{{route('clientes.create')}}" target="_blank" type="button" id="button-addon2">Añadir</a>
        </div>

    </div>
    <div class="col-md-4">
        <h5>Sucursal</h5>
        <select name="sucursal" @change="selecproductos()" v-model="sucursal" :disabled="datos" v-model="sucursal" id="sucursal_id" class="form-control text-center" >
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}"{{ old('sucursal_id')}} >
                    {{ ucwords($sucursal->nombre)}}
                </option>
            @endforeach
        </select>
    </div>

</div>
<hr>
<h5>Seleccionar Productos</h5>
<div class="card-header">
<div class="row">
    <div class="col-md-4">
        <select name="categoria_id" id="categoria_id" v-model="categoria_id" @change="selecproductos()" class="form-control text-center "  :class="{'field-error': categoria_id === ''  && error}">
            <option value="">--SELECCIONA CATEGORIA--</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id')}}>
                    {{ ucwords($categoria->nombre)}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <select name="producto" v-model="index_producto"  id="index_producto"  @change="verificarproducto()"  class="form-control text-center"  :class="{'field-error': index_producto === '' && error}">
            <option value="" >--SELECCIONA PRODUCTO--</option>
            <option v-for="(producto,index) in productos.nombres" :value="index">@{{ producto | upper}} / @{{ productos.descripcion[index] | upper }}</option>
        </select>
    </div>
    <div class="col-md-4">
        <input type="number" placeholder="CANTIDAD" name="cantidad" :max="maximo_producto" v-model="cantidad" class="form-control text-center" @keyup="verifimax()" :class="{'field-error': cantidad === '' || errormax}">
        <p class="note text-danger" v-if="errormax">La maxima cantidad disponible para este producto es de @{{ maximo_producto }} unidades</p>
    </div>

</div>
<div class="row mt-2">
    <div class="col-md-12 text-center" >
        <button class="btn btn-outline-primary"  @click.prevent="agregarfila()"><i class="bi bi-plus-circle-fill"></i> Agregar</button>
    </div>
</div>
</div>
<div v-if="datos">
    <hr>
    <h5 class="text-center">Datos de la Venta</h5>
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
            <tr v-for="(venta,index) in lista_venta.nombres ">
                <td class="align-middle text-center text-sm">@{{ index +1 }}</td>
                <td class="align-middle text-center text-sm">@{{ lista_venta.categoria[index] }} - @{{ venta }}</td>
                <td class="align-middle text-center text-sm"> @{{ lista_venta.cantidad[index] }}</td>
                <td class="align-middle text-center text-sm"> @{{ lista_venta.precio_unitario[index] }} $</td>
                <td class="align-middle text-center text-sm"> @{{ lista_venta.subtotal[index] }} $</td>
                <td align=middle>
                    <a class="btn btn-outline-danger btn-sm" type="button" @click.prevent="deletefila(index)"><i class="bi bi-trash3-fill"></i></a>
                </td>
            </tr>

        </tbody>
    </table>
    <div class="row">
        <div class="col-md-6 mt-3">
            <label class="mt-1"> <strong>Delivery</strong></label>
            <div class="form-check" >
                <input class="form-check-input" type="checkbox" :value="delivery" v-model="delivery" @click="configdelivery()" name="delivery" id="delivery">
                <label class="form-check-label" for="flexCheckDefault">
                    Agregar Delivery
                </label>
            </div>
            <div v-if="delivery" class=" card">
                <div class="row">
                    <div class="col-md-6">
                        <label for="direccion">Direccion</label>
                        <input type="text" class="form-control" name="direccion" v-model="direccion_delivery">
                    </div>
                    <div class="col-md-6">
                        <label for="direccion">Referencia</label>
                        <input type="text" class="form-control" name="referencia" v-model="referencia_delivery">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="costo_delivery">Costo Delivery ($)</label>
                        <input type="number" class="form-control text-center" min="1"  name="costo_delivery" @keyup="setcostodelivery()" v-model="costo_delivery" >
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <table class=" table table-striped table-hover table-responsive-md" align="right">
                <thead>
                    <tr align="right">
                       <th colspan="5">Dolar ($)</th>
                        <th colspan="4">Bolivares (Bs)</th>
                    </tr>
                </thead>
                <tbody>
                <tr align="right" class="mt-2">
                    <td colspan="3">SUBTOTAL A PAGAR</td>
                    <td colspan="2"> @{{ lista_venta.subtotal_factura }} $ </td>
                    <td class="text-center">@{{  bs.subtotal }} </td>
                </tr>
                <tr align="right">
                    <td colspan="3">IVA (19%)</td>
                    <td colspan="2"> @{{ lista_venta.iva }} $</td>
                    <td class="text-center">@{{ bs.iva }} </td>
                </tr>
                <tr align="right" class="" style=" border: double #051b11;" >
                    <th colspan="3">TOTAL FACTURA </th>
                    <th colspan="2"> @{{ lista_venta.total_factura }} $</th>
                    <td class="text-center  fw-bold ">@{{  bs.total_factura }} </td>
                </tr>
                <tr align="right" v-if="delivery && checkdelivery()"style=" border: double #051b11;" >
                    <th colspan="3">COSTO DELIVERY</th>
                    <th colspan="2"> @{{ costo_delivery }} $</th>
                    <td class="text-center  fw-bold ">@{{  costo_delivery_bs }} </td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>

</div>


<hr>



