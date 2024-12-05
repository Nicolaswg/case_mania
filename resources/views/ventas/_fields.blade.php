@csrf
<div class="row">
    <div class="col-md-8">
        <h5>* Cliente:</h5>
        <div class="input-group">
            <select name="cliente_id" :disabled="datos" v-model="cliente" id="cliente_id" class="form-control text-center" :class="{'field-error': cliente === ''  && error}">
                <option value="">-- Seleccionar Cliente --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}"{{ old('cliente_id')}}>
                        {{ ucwords($cliente->nombre)}} / {{$cliente->tipo_documento}}-{{$cliente->num_documento}}
                    </option>
                @endforeach
            </select>
            <a class="btn btn-outline-danger" href="{{route('clientes.create')}}" target="_blank" type="button" id="button-addon2">Nuevo Cliente</a>
        </div>
    </div>
    <div class="col-md-4">
        <h5>* Sucursal:</h5>
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
<h5>* Seleccionar Productos:</h5>
<div class="card-header">
<div class="row">
    <div class="col-md-4">
        <select name="categoria_id" id="categoria_id" v-model="categoria_id" @change="selecproductos()" class="form-control text-center "  :class="{'field-error': categoria_id === ''  && error}">
            <option value="">-- Seleccionar Categoría --</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id')}}>
                    {{ ucwords($categoria->nombre)}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <select name="producto" v-model="index_producto"  id="index_producto"  @change="verificarproducto()"  class="form-control text-center"  :class="{'field-error': index_producto === '' && error}">
            <option value="" >-- Seleccionar Producto --</option>
            <option v-for="(producto,index) in productos.nombres" :value="index">@{{ producto | upper}} / @{{ productos.descripcion[index] | upper }}</option>
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" placeholder="Ingrese la Cantidad del Producto" name="cantidad" :max="maximo_producto" v-model="cantidad" class="form-control text-center" @keyup="verifimax()" :class="{'field-error': cantidad === '' || errormax}" autocomplete="off" minlength="1" min="1" step="1">
        <p class="note text-danger" v-if="errormax">Debe agregar al menos 1 unidad y la máxima cantidad disponible para este producto es de @{{ maximo_producto }} unidades</p>
    </div>

</div>
<div class="row mt-2">
    <div class="col-md-12 text-center" >
        <button class="btn btn-outline-danger btn-lg"  @click.prevent="agregarfila()"><i class="bi bi-plus-circle-fill" :disable="!validar"></i> Agregar Producto</button>
    </div>
</div>
</div>
* Campos Obligatorios
<div v-if="datos">
    <hr>
    <h5 class="text-center">Datos de la Venta</h5>
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
            <tr v-for="(venta,index) in lista_venta.nombres ">
                <td class="align-middle text-center text-sm">@{{ index +1 }}</td>
                <td class="align-middle text-center text-sm">00@{{ lista_venta.ids[index] }} </td>
                <td class="align-middle text-center text-sm">@{{ lista_venta.categoria[index] }}</td>
                <td class="align-middle text-center text-sm">@{{ venta }}</td>
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
            <label class="mt-1"> <strong>Servicio a Domicilio</strong></label>
            <div class="form-check" >
                <input class="form-check-input" type="checkbox" :value="delivery" v-model="delivery" @click="configdelivery()" name="delivery" id="delivery">
                <label class="form-check-label" for="flexCheckDefault">
                    Agregar Servicio a Domicilio
                </label>
            </div>
            <div v-if="delivery" class=" card">
                <div class="row">
                    <div class="col-md-6">
                        <label for="direccion">Dirección:</label>
                        <textarea type="text" class="form-control" name="direccion" v-model="direccion_delivery" autocomplete="off"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="direccion">Punto de Referencia:</label>
                        <textarea type="text" class="form-control" name="referencia" v-model="referencia_delivery"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="costo_delivery">Costo del Servicio a Domicilio ($):</label>
                        <input type="number" class="form-control text-center" min="1"  name="costo_delivery" @keyup="setcostodelivery()" v-model="costo_delivery" minlength="1">
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <table class=" table table-striped table-hover table-responsive-md" align="right">
                <thead>
                    <tr align="right">
                       <th colspan="5">Dólar ($)</th>
                        <th colspan="4">Bolívares (Bs.)</th>
                    </tr>
                </thead>
                <tbody>
                <tr align="right" class="mt-2" style=" border: double #051b11;">
                    <th colspan="3">Total a Pagar</th>
                    <th colspan="2"> @{{ lista_venta.subtotal_factura }} $ </th>
                    <th class="text-center">@{{  bs.subtotal }} </th>
                </tr>
                <!-- <tr align="right">
                    <td colspan="3">I.V.A (16%)</td>
                    <td colspan="2"> 0,00 $</td>
                    <td class="text-center">@{{ bs.iva }} </td>
                </tr> -->
                <!-- <tr align="right" class="" style=" border: double #051b11;" >
                    <th colspan="3">Total Nota de Entrega </th>
                    <th colspan="2"> @{{ lista_venta.subtotal_factura }}  $</th>
                    <td class="text-center  fw-bold ">@{{  bs.total_factura }} </td>
                </tr> -->
                <tr align="right" v-if="delivery && checkdelivery()"style=" border: double #051b11;" >
                    <th colspan="3">Costo del Servicio a Domicilio</th>
                    <th colspan="2"> @{{ costo_delivery }} $</th>
                    <td class="text-center  fw-bold ">@{{  costo_delivery_bs }} </td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>

</div>


<hr>