@csrf
<div class="row ">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre"  value="{{ old('nombre', $sucursal->nombre) }}">
        </div>
    </div>
    <div class="col-md-6">
        <label for="codigo">Codigo:</label>
        <input type="text" class="form-control @if( $errors->get('codigo')) field-error @endif" name="codigo" id="codigo"  value="{{ old('nombre', $sucursal->codigo) }}">
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control @if( $errors->get('estado')) field-error @endif" name="estado" id="estado"  value="{{ old('estado', $sucursal->estado) }}">
        </div>
        <div class="col-md-4">
            <label for="ciudad">Ciudad:</label>
            <input type="text" class="form-control @if( $errors->get('ciudad')) field-error @endif" name="ciudad" id="ciudad"  value="{{ old('ciudad', $sucursal->ciudad) }}">
        </div>
        <div class="col-md-4">
            <h5 class="mt-3">Estado</h5>
            @foreach(trans('users.states') as $state=>$text)
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                           type="radio"
                           name="state"
                           id="role_{{ $state }}"
                           value="{{$state}}"
                           @if($state == 'active') checked @endif
                        {{ old('status', $sucursal->status) == $state ? 'checked' : '' }}>
                    <label class="form-check-label" for="state_{{ $state }}">{{ $text }}</label>
                </div>
            @endforeach
        </div>
    </div>

</div>



<hr>




