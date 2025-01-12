@csrf

<!-- Bloque de nombre y apellido, tipo de documento y número de documento -->

<div class="row"> 
    <div class="col-md-4">
        <div class="form-group"> <!-- Nombre y Apellido -->
            <span class="note info text-white" v-if="showinfo" >Ingrese el nombre y apellido del cliente</span>
            <label for="nombre">* Nombre y Apellido: <button @click.prevent="verificarinfo()" id="nombre" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Ej: Pedro Perez" value="{{ old('nombre', $cliente->nombre) }}" autocomplete="off" minlength="4" title="Debe ser mayor o igual a 4 caracteres">
        </div>
    </div>
    <div class="form-group col-md-4"> <!-- Tipo de documento -->
        <span class="note info text-white" v-if="showinfo" >Ingrese el tipo de documento del cliente</span>
        <label for="tipo" class="text-center">* Tipo de Documento: <button @click.prevent="verificarinfo()" id="tipo" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select class="form-control @if( $errors->get('tipo_documento')) field-error @endif text-center" name="tipo_documento" id="tipo">
            <option value="">-- Seleccionar Documneto --</option>
            <option value="V" @if($cliente->tipo_documento=='V') selected @endif>Venezolano</option>
            <option value="E" @if($cliente->tipo_documento=='E') selected @endif>Extranjero</option>
            <option value="J"  @if($cliente->tipo_documento=='J') selected @endif>Jurídico</option>
            <option value="P" @if($cliente->tipo_documento=='P') selected @endif>Pasaporte</option>
            <option value="G" @if($cliente->tipo_documento=='G') selected @endif>Gubernamental</option>
        </select>
    </div>
    <div class="form-group col-md-4"> <!-- Número de documento -->
        <span class="note info text-white" v-if="showinfo" >Ingrese el número de documento del cliente (mínimo 6 dígitos)</span>
        <label for="rif">* Número de Documento: <button @click.prevent="verificarinfo()" id="rif" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="text" class="form-control @if( $errors->get('num_documento')) field-error @endif" name="num_documento" id="rif" placeholder="Ej: 14820336" value="{{ old('num_documento', $cliente->num_documento) }}" autocomplete="off" minlength="6" maxlength="10" title="Debe estar comprendido entre 6 a 10 caracteres">
    </div>
</div>

<!-- Bloque de número de teléfono y dirección -->

<div class="row"> 
    <div class="form-group col-md-4"> <!-- Número de teléfono  -->
        <span class="note info text-white" v-if="showinfo" >El formato debe coincidir con la siguiente manera: Los 4 primeros dígitos separados por un guion y luego los 7 dígitos restantes</span>
        <label for="num_cel">* Número de Teléfono: <button @click.prevent="verificarinfo()" id="num_cel" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="tel" class="form-control @if( $errors->get('telefono')) field-error @endif" name="telefono" id="num_cel" placeholder="Ej: 0276-3431103" autocomplete="off" minlength="12" maxlength="12" 
               value="{{ old('telefono', $cliente->telefono) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros digitos separados por un guion y luego los 7 digitos restantes" >
    </div>
    <div class="col-md-8"> <!-- Dirección del cliente -->
        <span class="note info text-white" v-if="showinfo" >Ingrese la dirección del cliente</span>
        <label for="ubicacion">Dirección de Domicilio (opcional): <button @click.prevent="verificarinfo()" id="ubicacion" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="text" class="form-control @if( $errors->get('direccion')) field-error @endif" name="direccion" id="direccion" placeholder="Ej: Urb. Andrés Bello casa #120" value="{{ old('direccion', $cliente->direccion) }}" minlength="10" maxlength="100" autocomplete="off" title="Debe ser mayor o igual a 10 caracteres">
    </div>
    
</div>

<!-- Bloque de correo electrónico y estado del cliente -->

<div class="row">
    <div class="col-md-4"> <!-- Correo electrónico -->
        <div class="form-group">
        <span class="note info text-white" v-if="showinfo" >Ingrese el correo electrónico del cliente</span>
            <label for="email">Correo Electrónico (opcional): <button @click.prevent="verificarinfo()" id="email" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <input type="email" class="form-control @if( $errors->get('email')) field-error @endif" name="email" id="email" placeholder="pedro@example.com" value="{{ old('email', $cliente->email) }}" autocomplete="off">
        </div>
    </div>
    <div class="col-md-3 card ml-2">
        <h5 class="mt-3">* Estado</h5>
        @foreach(trans('users.states') as $state=>$text)
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                       type="radio"
                       name="state"
                       id="role_{{ $state }}"
                       value="{{$state}}"
                       @if($state == 'active') checked @endif
                    {{ old('status', $cliente->status) == $state ? 'checked' : '' }}>
                <label class="form-check-label" for="state_{{ $state }}">{{ $text }}</label>
            </div>
        @endforeach
    </div>
</div>
<div class="row pt-3">
    <label>* Campos obligatorios</label>
</div>
<hr>




