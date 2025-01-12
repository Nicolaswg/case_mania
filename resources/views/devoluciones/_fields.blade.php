@csrf
<div class="row">
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header"> <!-- Datos del cliente -->
               <h5>Datos del Cliente</h5>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <p><strong>Nombre:</strong> {{ucwords( $venta->cliente->nombre) }}</p>
                    <p><strong>Número de Documento:</strong> {{ucwords( $venta->cliente->tipo_documento)  }}-{{$venta->cliente->num_documento}}</p>
                    <p><strong>Número de Télefono:</strong> {{ $venta->cliente->telefono  }}</p>
                    <p><strong>Dirección:</strong> {{ ucfirst($venta->cliente->direccion)}}</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-header"> <!-- Datos de la venta -->
                <h5>Datos de la Venta</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Venta # {{ $venta->id }}</h5>
                <div class="card-text">
                    <p><strong>Fecha de la Venta:</strong> {{\Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y')}}</p>
                    <p><strong>Subtotales</strong>: {{ $venta->subtotal_dolar }}$ ({{round(($venta->subtotal_dolar * $venta->tasa_bcv),2)}} Bs)</p>
                    <p><strong>Iva</strong>: {{ $venta->iva_dolar }}$ ({{round(($venta->iva_dolar * $venta->tasa_bcv),2)}} Bs)</p>
                    <p><strong>Total</strong>: {{ $venta->total_dolar}}$ ({{round(($venta->total_dolar * $venta->tasa_bcv),2)}} Bs)</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header"> <!-- Detalles de la devolución -->
               <h5>Detalles de la Devolución</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Productos</h5>
                <div class="card-text">
                    <ol class="list-group-item">
                        @foreach($productos as $i=>$producto)
                            <li class="">
                                <span><strong>{{strtoupper($categorias[$i])}} - {{strtoupper($producto)}}</strong></span> Cantidad: <strong>{{$cantidad[$i]}}</strong>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-check"> <!-- Caja de marcado para realizar la devolución -->
        <input class="form-check-input ml-4" type="checkbox"  v-model="devolucion" @click="config()" id="devolucion">
        <label class="form-check-label ml-5" for="flexCheckDefault">
            Devolver Producto(s)
        </label>
        </div>
        <hr>
        <div v-if="devolucion">
            <label for="bio">Indique la razón por la que deseas Devolver el (los) Producto(s):</label>
            <textarea v-model="razon" name="razon_devolucion" class="form-control " id="razon_devolucion" ></textarea>
            <input type="hidden" value="{{$venta->id}}" name="venta_id">
        </div>
    </div>
</div>



