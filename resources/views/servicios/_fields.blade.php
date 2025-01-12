@csrf

<!-- Bloque de cliente -->

<div class="row ">
    <span class="note info text-white" v-if="showinfo" >Escoja un cliente</span>
    <div class="col-md-12"> <!-- Cliente -->
        <label>* Cliente:</label>
        <div class="input-group">
            <select name="cliente_id"  id="cliente_id" v-model="cliente_id" class="form-control text-center" :readonly="datos">
                <option value="">-- Seleccionar Cliente --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}"{{ old('cliente_id')}}>
                        {{ ucwords($cliente->nombre)}} / {{$cliente->tipo_documento}}-{{$cliente->num_documento}}
                    </option>
                @endforeach
            </select>
            <!-- Botón para registrar un nuevo cliente -->
            <a class="btn btn-outline-danger" href="{{route('clientes.create')}}" target="_blank" type="button" id="button-addon2">Nuevo Cliente</a> 
        </div>
    </div>
</div>
<hr>

<!-- Bloque para producto, cantidad y serial del producto -->

<div class="row">
    <span class="note info text-white" v-if="showinfo" >Ingrese el nombre del producto</span>
    <div class="form-group col-md-4"> <!-- Nombre del producto -->
        <label for="producto">* Producto: <button @click.prevent="verificarinfo()" id="producto" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="text" class="form-control" name="producto" placeholder="Ej: Samsung A30" id="producto" v-model="producto" minlength="5" title="Debe ser mayor o igual a 5 caracteres">
    </div>
    <div class="form-group col-md-4"> <!-- Cantidad del producto -->
        <span class="note info text-white" v-if="showinfo" >Ingrese la cantidad del producto</span>
        <label for="rif">* Cantidad: <button @click.prevent="verificarinfo()" id="rif" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="number" min="1" step="1" class="form-control" v-model="cantidad" placeholder="Ingresar la cantidad" onkeypress="De1enadelante(event)" name="cantidad" autocomplete="off">
    </div>
    <div class="form-group col-md-4"> <!-- Serial del producto -->
        <span class="note info text-white" v-if="showinfo" >Ingrese el registro del producto</span>
        <label for="rif">* Placa / Serial / IMEI del Producto <button @click.prevent="verificarinfo()" id="rif" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="text" class="form-control" v-model="serial" placeholder="Ej: DKGHDFJGH8956" minlength="5" title="Debe ser mayor o igual a 5 caracteres">
    </div>
</div>

<!-- Bloque para descripción de la falla, posible fecha de entrega y garantía del servicio -->

<div class="row">
    <div class="col-md-4 "> <!-- Descrición de la falla -->
        <span class="note info text-white" v-if="showinfo" >Ingrese una descripción detallada de la falla</span>
        <label for="bio">* Descripción de la Falla: <button @click.prevent="verificarinfo()" id="falla" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <textarea name="falla" class="form-control" v-model="falla" id="falla" placeholder="Ej: Especificar la falla del equipo" minlength="10" title="Debe ser mayor o igual a 10 caracteres"></textarea>
    </div>
    <div class="col-md-4 "> <!-- Fecha de entrega -->
        <span class="note info text-white" v-if="showinfo" >Establesca una posible fecha de entrega</span>
        <label for="bio">* Posible Fecha de Entrega: <button @click.prevent="verificarinfo()" id="falla" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <!-- <input type="date" name="pfentrega" class="form-control" v-model="pfentrega" id="pfentrega"> -->
    </div>
    <div class="col-md-4 "> <!-- Garantía del servicio -->
        <span class="note info text-white" v-if="showinfo" >Ingrese la garantía del servicio a realizar</span>
        <label for="bio">* Garantía del Servicio Técnico: <button @click.prevent="verificarinfo()" id="falla" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <!-- <input name="falla" class="form-control" v-model="falla" id="falla" placeholder="Ej: 24 horas"> -->
    </div>
</div>

<!-- Bloque para fecha de recepción -->

<div class="row">
    <div class="col-md-4">
        <p class="text-info text-center mt-5"><strong>Fecha de Recepción: {{\Carbon\Carbon::now()->format('d-m-Y h:i A')}}</strong></p>
    </div>
</div>
<div class="row pt-3">
    <label>* Campos obligatorios</label>
</div>
<hr>
<div class="row">
    <div class="col-md-12 text-center" > <!-- Botón para agregra fila -->
        <button class="btn btn-outline-danger btn-lg"  @click.prevent="agregarfila()"><i class="bi bi-plus-circle-fill"></i> Agregar Servicio Técnico</button>
    </div>

</div>
<hr>
<div v-if="datos"> <!-- Subtítulos de la tabla -->
    <h5 class="text-center">Datos del Servicio Técnico</h5>
    <table class="table align-items-center mb-0" id="tabla_datos">
        <thead>
        <tr>
            <th class="">Renglón</th>
            <th class="">Producto</th>
            <th class="">Cantidad</th>
            <th>Descripción de la Falla</th>
            <th class="">Serial del Equipo</th>
            <th>Fecha de Recepción</th>
            <th class="">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(producto,index) in lista_servicio.productos "> <!-- Detalles de los datos ingresados -->
            <td class="align-middle text-center text-sm">@{{ index +1 }}</td>
            <td class="align-middle text-center text-sm">@{{ lista_servicio.productos[index]}}</td>
            <td class="align-middle text-center text-sm"> @{{ lista_servicio.cantidad[index]}}</td>
            <td class="align-middle text-center text-sm"> @{{ lista_servicio.falla[index] }} </td>
            <td class="align-middle text-center text-sm"> @{{ lista_servicio.serial[index] }}</td>
            <td class="align-middle text-center text-sm"> {{\Carbon\Carbon::now()->format('d-m-Y')}} </td>
            <td align=middle>
                <a class="btn btn-outline-danger btn-sm" type="button" @click.prevent="deletefila(index)"><i class="bi bi-trash3-fill"> Eliminar</i></a>
            </td>
        </tr>

        </tbody>
    </table>
    <div class="row">
        <div class="col-md-4">
            <label class="mt-1"> <strong>Costo del Servicio Técnico</strong></label>
            <div class="form-check" >
                <input :disabled="datos=== false" class="form-check-input" type="checkbox" :value="costo" v-model="costo" @click="config()" name="costo" id="costo">
                <label class="form-check-label" for="flexCheckDefault">
                    Establecer Costo
                </label>
            </div>
        </div>
        <div v-if="costo">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="rif">Costo Mano Obra ($):</label>
                    <input type="number" min="1" class="form-control text-center" v-model="costo_unitario" @keyup="setcostobs()">
                </div>
                <div class="form-group col-md-4">
                    <label for="rif">Costo Mano Obra (Bs):</label>
                    <input type="number" readonly class="form-control text-center" v-model="costo_unitario_bs">
                </div>
                <div class="form-group col-md-4 text-center card">
                    <label for="" class="text-center"><strong>TOTALES</strong></label>
                    <hr class="mt-0 mb-0">
                    <ul class="list-unstyled text-center">
                        <li>Total en Dólares : <strong> @{{ costo_unitario }} </strong></li>
                        <li>Total en Bolívares : <strong> @{{ costo_unitario_bs }} </strong></li>
                    </ul>



                </div>
            </div>

        </div>
    </div>

</div>
