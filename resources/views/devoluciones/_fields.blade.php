@csrf
<div class="row">
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
               Datos del Cliente
            </div>
            <div class="card-body">
                <h5 class="card-title">Datos del Cliente # {{ $venta->cliente->id }}</h5>
                <div class="card-text">
                    <p><strong>Nombre</strong>: {{ucwords( $venta->cliente->nombre) }}</p>
                    <p><strong>Documento</strong>: {{ucwords( $venta->cliente->tipo_documento)  }}-{{$venta->cliente->num_documento}}</p>
                    <p><strong>Telefono</strong>: {{ $venta->cliente->telefono  }}</p>
                    <p><strong>Direccion</strong>: {{ ucfirst($venta->cliente->direccion)}}</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-header">
                Datos de la Venta
            </div>
            <div class="card-body">
                <h5 class="card-title">Venta # {{ $venta->id }}</h5>
                <div class="card-text">
                    <p><strong>Fecha</strong>: {{\Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y')}}</p>
                    <p><strong>Subtotales</strong>: {{ $venta->subtotal_dolar }}$ ({{round(($venta->subtotal_dolar * $venta->tasa_bcv),2)}} Bs)</p>
                    <p><strong>Iva</strong>: {{ $venta->iva_dolar }}$ ({{round(($venta->iva_dolar * $venta->tasa_bcv),2)}} Bs)</p>
                    <p><strong>Total</strong>: {{ $venta->total_dolar}}$ ({{round(($venta->total_dolar * $venta->tasa_bcv),2)}} Bs)</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
               Detalles de la Venta
            </div>
            <div class="card-body">
                <h5 class="card-title">Productos</h5>
                <div class="card-text">
                    <ol class="list-group-item">
                        @foreach($productos as $i=>$producto)
                            <li class="">
                                <span><strong>{{strtoupper($categorias[$i])}} - {{strtoupper($producto)}}</strong></span> Cantidad (#): <strong>{{$cantidad[$i]}}</strong>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-check">
        <input class="form-check-input ml-4" type="checkbox"  v-model="devolucion" @click="config()" id="devolucion">
        <label class="form-check-label ml-5" for="flexCheckDefault">
            Devolver Producto(s)
        </label>
        </div>
        <hr>
        <div v-if="devolucion">
            <label for="bio">Indique la razon por la que deseas Devolver el (los) Producto(s):</label>
            <textarea v-model="razon" name="razon_devolucion" class="form-control " id="razon_devolucion" ></textarea>
            <input type="hidden" value="{{$venta->id}}" name="venta_id">
        </div>

    </div>
</div>



