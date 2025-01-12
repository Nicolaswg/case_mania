@csrf

<!-- Bloque de nombre, código, estado, ciudad y actividad de la sucursal -->

<div class="row ">
    <div class="col-md-6">
        <div class="form-group"> <!-- Nombre de la sucursal -->
            <label for="nombre">* Nombre de la Sucursal:</label> 
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre"  value="{{ old('nombre', $sucursal->nombre) }}" placeholder="EJ: Principal">
        </div>
    </div>
    <div class="col-md-6"> <!-- Código de la sucursal -->
        <label for="codigo">* Código de la Sucursal:</label>
        <input type="text" class="form-control @if( $errors->get('codigo')) field-error @endif" name="codigo" id="codigo"  value="{{ old('nombre', $sucursal->codigo) }}" placeholder="EJ: PRI01">
    </div>
    <div class="row">
        <div class="col-md-4"> <!-- Estado de ubicación -->
            <label for="estado">* Estado:</label>
            <input type="text" class="form-control @if( $errors->get('estado')) field-error @endif" name="estado" id="estado"  value="{{ old('estado', $sucursal->estado) }}" placeholder="EJ: Aragua">
        </div>
        <div class="col-md-4"> <!-- Ciudad de ubicación -->
            <label for="ciudad">* Ciudad:</label>
            <input type="text" class="form-control @if( $errors->get('ciudad')) field-error @endif" name="ciudad" id="ciudad"  value="{{ old('ciudad', $sucursal->ciudad) }}" placeholder="EJ: Maracay">
        </div>
        <div class="col-md-4"> <!-- Estado de actividad -->
            <h5 class="mt-3">* Estado de Actividad</h5>
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
        <div class="row pt-3">
        <label>* Campos obligatorios</label>
        </div>
    </div>
</div>
<hr>




