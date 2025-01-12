@csrf

<!-- Bloque de razón social del proveedor  -->

<div class="row ">
    <div class="col-md-12"> <!-- Razón social -->
        <div class="form-group">
            <span class="note info text-white" v-if="showinfo" >Ingrese el nombre del proveedor</span>
            <label for="nombre">* Razón Social: <button @click.prevent="verificarinfo()" id="nombre" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Ej: IMPORTADORA OKLA S.A.S" value="{{ old('nombre', $proveedor->nombre) }}" autocomplete="off" minlenght="7" title="Debe ser mayor o igual a 7 caracteres">
        </div>
    </div>
</div>

<!-- Bloque de tipo de documento, rif y categoría asociada de proveedor -->

<div class="row">
    <div class="form-group col-md-4"> <!-- tipo de documento -->
        <span class="note info text-white" v-if="showinfo" >Tipo de documento del proveedor</span>
        <label for="tipo">* Tipo de Documento: <button @click.prevent="verificarinfo()" id="tipo" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select class="form-control @if( $errors->get('tipo')) field-error @endif text-center" name="tipo" id="tipo">
            <option value="" class="text-center">-- Seleccionar Documento --</option>
            <option value="V" @if($proveedor->tipo=='V') selected @endif>Firma Personal</option>
            <option value="J"  @if($proveedor->tipo=='J') selected @endif>Jurídico</option>
            <option value="G"  @if($proveedor->tipo=='G') selected @endif>Gubernamental</option>
        </select>
    </div>
    <div class="form-group col-md-4"> <!-- Número de rif -->
        <span class="note info text-white" v-if="showinfo" >Los 8 primeros dígitos separados por un guión y luego 1 dígito restante</span>
        <label for="rif">* Número de Rif: <button @click.prevent="verificarinfo()" id="rif" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="text" class="form-control @if( $errors->get('rif')) field-error @endif" name="rif" id="rif" placeholder="Ej: 14820336-9" value="{{ old('rif', $proveedor->rif) }}" autocomplete="off" pattern="[0-9]{8}-[0-9]{1}" minlength="10" maxlength="10" title=" Los 8 primeros dígitos separados por un guión y luego 1 dígito restante">
    </div>
    <div class="form-group col-md-4"> <!-- Categoría asociada -->
        <span class="note info text-white" v-if="showinfo" >Escoja una categoría a la que te suministra el proveedor</span>
        <label for="tipo">* Categoría del Producto Asociada: <button @click.prevent="verificarinfo()" id="tipo" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select class="form-control @if( $errors->get('categoria_id')) field-error @endif text-center" name="categoria_id" id="categoria_id">
            <option value="">-- Seleccionar Categoría --</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id',$proveedor->categoria->id) == $categoria->id ? 'selected' : ''}}>
                    {{ ucwords($categoria->nombre)}}
                </option>
            @endforeach
        </select>
    </div>
</div>

<!-- Bloque de número de teléfono, correo electrónico y estado de actividad -->

<div class="row">
    <div class="form-group col-md-4"> <!-- Número de teléfono -->
        <span class="note info text-white" v-if="showinfo" >Los 4 primeros dígitos separados por un guión y luego los 7 dígitos restantes</span>
        <label for="num_cel">* Número de Teléfono: <button @click.prevent="verificarinfo()" id="num_cel" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="tel" class="form-control @if( $errors->get('num_cel')) field-error @endif" name="num_cel" id="num_cel" placeholder="Ej: 0276-3431103"
               value="{{ old('num_cel', $proveedor->num_cel) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros dígitos separados por un guión y luego los 7 dígitos restantes" autocomplete="off" minlength="10" maxlength="12">
    </div>
    <div class="form-group col-md-4">
        <div class="form-group"> <!-- Correo Electrónico -->
            <span class="note info text-white" v-if="showinfo" >Ingrese el correo electrónico del proveedor</span>
            <label for="nombre">Correo Electrónico (opcional): <button @click.prevent="verificarinfo()" id="nombre" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <!-- <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Ej: IMPORTADORA OKLA S.A.S" value="{{ old('nombre', $proveedor->nombre) }}" autocomplete="off"> -->
        </div>
    </div>
    <div class="col-md-3 card"> 
        <h5 class="mt-3">* Estado</h5>
        @foreach(trans('users.states') as $state=>$text)
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                       type="radio"
                       name="state"
                       id="role_{{ $state }}"
                       value="{{$state}}"
                       @if($state == 'active') checked @endif
                    {{ old('status', $proveedor->status) == $state ? 'checked' : '' }}>
                <label class="form-check-label" for="state_{{ $state }}">{{ $text }}</label>
            </div>
        @endforeach
    </div>

</div><br>
* Campos Obligatorios
<hr>




