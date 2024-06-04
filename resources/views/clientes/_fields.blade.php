@csrf
<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            <label for="nombre">Nombre y Apellido:</label>
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Pedro Perez" value="{{ old('nombre', $cliente->nombre) }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label for="tipo">Tipo:</label>
        <select class="form-control @if( $errors->get('tipo_documento')) field-error @endif" name="tipo_documento" id="tipo">
            <option value="">--SELECCIONA--</option>
            <option value="V" @if($cliente->tipo_documento=='V') selected @endif>Venezolano</option>
            <option value="E" @if($cliente->tipo_documento=='E') selected @endif>Extranjero</option>
            <option value="J"  @if($cliente->tipo_documento=='J') selected @endif>Juridico</option>
        </select>
    </div>
    <div class="form-group col-md-8">
        <label for="rif">Numero de Documento:</label>
        <input type="text" class="form-control @if( $errors->get('num_documento')) field-error @endif" name="num_documento" id="rif" placeholder="14820336" value="{{ old('num_documento', $cliente->num_documento) }}">
    </div>

</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="num_cel">Numero de Telefono:</label>
        <input type="tel" class="form-control @if( $errors->get('telefono')) field-error @endif" name="telefono" id="num_cel" placeholder="0276-3431103"
               value="{{ old('telefono', $cliente->telefono) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros digitos separados por un guion y luego los 7 digitos restantes" >
    </div>
    <div class="col-md-4">
        <label for="ubicacion">Direccion/Ubicacion:</label>
        <input type="text" class="form-control @if( $errors->get('direccion')) field-error @endif" name="direccion" id="direccion" placeholder="" value="{{ old('direccion', $cliente->direccion) }}">
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" class="form-control @if( $errors->get('email')) field-error @endif" name="email" id="email" placeholder="pedro@example.com" value="{{ old('email', $cliente->email) }}">
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-3 card ml-2">
        <h5 class="mt-3">Estado</h5>
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

<hr>




