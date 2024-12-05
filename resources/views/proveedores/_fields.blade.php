@csrf
<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            <label for="nombre">* Razón Social:</label>
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Ej: IMPORTADORA OKLA S.A.S" value="{{ old('nombre', $proveedor->nombre) }}" autocomplete="off">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label for="tipo">* Tipo de Documento:</label>
        <select class="form-control @if( $errors->get('tipo')) field-error @endif" name="tipo" id="tipo">
            <option value="" class="text-center">-- Seleccionar Documento --</option>
            <option value="V" @if($proveedor->tipo=='V') selected @endif>V</option>
            <option value="J"  @if($proveedor->tipo=='J') selected @endif>J</option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="rif">* Número de Rif:</label>
        <input type="text" class="form-control @if( $errors->get('rif')) field-error @endif" name="rif" id="rif" placeholder="Ej: 148203364-9" value="{{ old('rif', $proveedor->rif) }}" autocomplete="off" pattern="[0-9]{8}-[0-9]{1}" minlength="10" maxlength="10" title=" Los 8 primeros dígitos separados por un guion y luego 1 dígito restante">
    </div>
    <div class="form-group col-md-4">
        <label for="tipo">* Categoria de producto Asociada:</label>
        <select class="form-control @if( $errors->get('categoria_id')) field-error @endif" name="categoria_id" id="categoria_id">
            <option value="">-- Seleccionar Categoría --</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"{{ old('categoria_id',$proveedor->categoria->id) == $categoria->id ? 'selected' : ''}}>
                    {{ ucwords($categoria->nombre)}}
                </option>
            @endforeach

        </select>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="num_cel">* Número de Teléfono:</label>
        <input type="tel" class="form-control @if( $errors->get('num_cel')) field-error @endif" name="num_cel" id="num_cel" placeholder="Ej: 0276-3431103"
               value="{{ old('num_cel', $proveedor->num_cel) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros dígitos separados por un guion y luego los 7 dígitos restantes" autocomplete="off" maxlength="12">
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




