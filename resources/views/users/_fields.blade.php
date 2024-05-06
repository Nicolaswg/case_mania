@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nombre y Apellido:</label>
            <input type="text" class="form-control @if( $errors->get('name')) field-error @endif" name="name" id="name" placeholder="Pedro Perez" value="{{ old('name', $user->name) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" class="form-control @if( $errors->get('email')) field-error @endif" name="email" id="email" placeholder="pedro@example.com" value="{{ old('email', $user->email) }}">
        </div>
    </div>

</div>
<div class="row">
    <div class="form-group col-md-4">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control @if( $errors->get('password')) field-error @endif" name="password" id="password" placeholder="Mayor a 6 caracteres" value="{{ old('password') }}">
    </div>

    <div class="form-group col-md-8">
        <label for="ubicacion">Direccion/Ubicacion:</label>
        <input type="text" class="form-control @if( $errors->get('ubicacion')) field-error @endif" name="ubicacion" id="ubicacion" placeholder="San cristobal-Tachira" value="{{ old('ubicacion', $user->profile->ubicacion) }}">
    </div>
</div>
<div class="row">
    <div class="form-group col-md-5">
        <label for="bio">Bio:</label>
        <textarea name="bio" class="form-control @if( $errors->get('bio')) field-error @endif" id="bio">{{ old('bio', $user->profile->bio) }}</textarea>
    </div>
    <div class="form-group col-md-3">
        <label for="tipo_documento">Tipo de Documento</label>
        <select class="form-control @if( $errors->get('tipo_documento')) field-error @endif" name="tipo_documento" id="tipo_documento">
            <option value="">--SELECCIONA--</option>
            <option value="V" @if($user->profile->tipo_documento=='V') selected @endif>V</option>
            <option value="J"  @if($user->profile->tipo_documento=='J') selected @endif>J</option>
            <option value="P"  @if($user->profile->tipo_documento=='P') selected @endif>P</option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="num_documento">Numero de Documento</label>
        <input type="text" class="form-control @if( $errors->get('num_documento')) field-error @endif" name="num_documento" id="num_documento" placeholder="14820336" value="{{ old('num_documento', $user->profile->num_documento) }}">
    </div>

</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="profesion">Profesión</label>
        <input type="text" class="form-control @if( $errors->get('profesion')) field-error @endif" name="profesion" id="profesion" value="{{ old('profesion', $user->profile->profesion) }}">
    </div>
    <div class="form-group col-md-4">
        <label for="num_cel">Numero de Telefono</label>
        <input type="tel" class="form-control @if( $errors->get('num_cel')) field-error @endif" name="num_cel" id="num_cel" placeholder="0276-3431103"
               value="{{ old('num_cel', $user->profile->num_cel) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros digitos separados por un guion y luego los 7 digitos restantes" >
    </div>
    <div class="form-group col-md-4">
        <label for="sucursal_id">Sucursal</label>
        <select name="sucursal_id" id="sucursal_id" class="form-control @if( $errors->get('sucursal_id')) field-error @endif">
            <option value="">--Selecciona una Sucursal Asociada--</option>
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}"{{ old('sucursal_id', $user->profile->sucursal_id) == $sucursal->id ? ' selected' : '' }}>
                    {{ ucwords($sucursal->nombre) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h5 class="mt-3">Rol</h5>
        @foreach(trans('users.rol') as $role=>$name)
            <div class="form-check form-check-inline">
                <input class="form-check-input "
                       type="radio"
                       name="role"
                       id="role_{{ $role }}"
                       value="{{ $role }}"
                    {{ old('role', $user->role) == $role ? 'checked' : '' }}>
                <label class="form-check-label" for="role_{{ $role }}">{{ $name }}</label>
            </div>
        @endforeach
    </div>
    @if($vista === 'create')
    <div :class="{ 'col-md-2': empleado , 'col-md-6': !empleado }" class="card">
        <label class="mt-1"> <strong>EMPLEADOS</strong></label>
        <div class="form-check" >
            <input class="form-check-input" type="checkbox" value="{{old('empleado')}}" v-model="empleado" @click="config()" name="empleado" id="empleado">
            <label class="form-check-label" for="flexCheckDefault">
               Agregar a Empleados
            </label>
        </div>

    </div>
    <div v-if="empleado" class="col-md-3 card">
        <label for="cargo"><strong>Cargo Laboral</strong></label>
        <input value="{{old('cargo')}}" type="text" class="form-control" :class="{'field-error': empleado === true && cargo === ''}" v-model="cargo" name="cargo">
        <p class="note">Debes Añadir un Cargo para el empleado</p>
    </div>
    @endif

</div>
<hr>




