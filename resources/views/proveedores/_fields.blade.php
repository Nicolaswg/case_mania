@csrf
<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            <label for="nombre">Nombre y/o Razon Social:</label>
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Pedro Perez" value="{{ old('nombre', $proveedor->nombre) }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label for="tipo">Tipo:</label>
        <select class="form-control @if( $errors->get('tipo')) field-error @endif" name="tipo" id="tipo">
            <option value="">--SELECCIONA--</option>
            <option value="V" @if($proveedor->tipo=='V') selected @endif>Natural</option>
            <option value="J"  @if($proveedor->tipo=='J') selected @endif>Juridico</option>
        </select>
    </div>
    <div class="form-group col-md-8">
        <label for="rif">Numero de Rif:</label>
        <input type="text" class="form-control @if( $errors->get('rif')) field-error @endif" name="rif" id="rif" placeholder="14820336" value="{{ old('rif', $proveedor->rif) }}">
    </div>

</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="num_cel">Numero de Telefono:</label>
        <input type="tel" class="form-control @if( $errors->get('num_cel')) field-error @endif" name="num_cel" id="num_cel" placeholder="0276-3431103"
               value="{{ old('num_cel', $proveedor->num_cel) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros digitos separados por un guion y luego los 7 digitos restantes" >
    </div>
    <div class="col-md-3 card">
        <h5 class="mt-3">Estado</h5>
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

</div>

<hr>




