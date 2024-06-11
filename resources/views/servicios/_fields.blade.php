@csrf
<div class="row ">
    <div class="col-md-12">
        <label>Cliente</label>
        <div class="input-group">
            <select name="cliente_id"  id="cliente_id" v-model="cliente_id" class="form-control text-center" :readonly="datos">
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
</div>
<hr>
<div class="row">
    <div class="form-group col-md-4">
        <label for="producto">Producto</label>
        <input type="text" class="form-control" name="producto" placeholder="Marca, Modelo" id="producto" v-model="producto">
    </div>
    <div class="form-group col-md-4">
        <label for="rif">Cantidad</label>
        <input type="number" min="1" class="form-control" v-model="cantidad">
    </div>
    <div class="form-group col-md-4">
        <label for="rif">Placa / Serial</label>
        <input type="text"  class="form-control" v-model="serial">
    </div>
</div>
<div class="row">
    <div class="col-md-4 ">
        <label for="bio">Descripcion de Falla:</label>
        <textarea name="falla" class="form-control" v-model="falla" id="falla"></textarea>
    </div>
    <div class="col-md-4">
        <p class="text-info text-center mt-5"><strong>Fecha de Entrega: {{\Carbon\Carbon::now()->format('d-m-Y h:i A')}}</strong></p>
    </div>

</div>
<hr>
<div class="row">
    <div class="col-md-12 text-center" >
        <button class="btn btn-outline-primary"  @click.prevent="agregarfila()"><i class="bi bi-plus-circle-fill"></i> Agregar</button>
    </div>

</div>
<hr>
<div v-if="datos">
    <h5 class="text-center">Datos del Servicio</h5>
    <table class="table align-items-center mb-0" id="tabla_datos">
        <thead>
        <tr>
            <th class="">#</th>
            <th class="">Producto</th>
            <th class="">Cantidad</th>
            <th>Descripcion de la Falla</th>
            <th class="">Serial</th>
            <th>Fecha Recepcion</th>
            <th class="">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(producto,index) in lista_servicio.productos ">
            <td class="align-middle text-center text-sm">@{{ index +1 }}</td>
            <td class="align-middle text-center text-sm">@{{ lista_servicio.productos[index]}}</td>
            <td class="align-middle text-center text-sm"> @{{ lista_servicio.cantidad[index]}}</td>
            <td class="align-middle text-center text-sm"> @{{ lista_servicio.falla[index] }} </td>
            <td class="align-middle text-center text-sm"> @{{ lista_servicio.serial[index] }}</td>
            <td class="align-middle text-center text-sm"> {{\Carbon\Carbon::now()->format('d-m-Y')}} </td>
            <td align=middle>
                <a class="btn btn-outline-danger btn-sm" type="button" @click.prevent="deletefila(index)"><i class="bi bi-trash3-fill"></i></a>
            </td>
        </tr>

        </tbody>
    </table>
    <div class="row">
        <div class="col-md-4">
            <label class="mt-1"> <strong>COSTO</strong></label>
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
                    <label for="rif">Costo Mano Obra</label>
                    <input type="number" min="1" class="form-control text-center" v-model="costo_unitario" @keyup="setcostobs()">
                </div>
                <div class="form-group col-md-4">
                    <label for="rif">Costo Mano Obra (Bs)</label>
                    <input type="number" readonly class="form-control text-center" v-model="costo_unitario_bs">
                </div>
                <div class="form-group col-md-4 text-center card">
                    <label for="" class="text-center"><strong>TOTALES</strong></label>
                    <hr class="mt-0 mb-0">
                    <ul class="list-unstyled text-center">
                        <li>Total $ : <strong> @{{ costo_unitario }} </strong></li>
                        <li>Total Bs : <strong> @{{ costo_unitario_bs }} </strong></li>
                    </ul>



                </div>
            </div>

        </div>
    </div>

</div>




