@csrf

<div class="row">
    <div class="form-group col-md-3 ">
        <label for="tipo_documento">* Tipo de Documento:</label>
        <select class="form-control text-center @if( $errors->get('tipo_documento')) field-error @endif" name="tipo_documento" id="tipo_documento">
            <option value="">-- Seleccionar Documento --</option>
            <option value="V" {{ old('tipo_documento') == 'V' ? 'selected' : '' }}>V</option>
            <option value="E"  {{ old('tipo_documento') == 'E' ? 'selected' : '' }}>E</option>
            <option value="J"  {{ old('tipo_documento') == 'J' ? 'selected' : '' }}>J</option>
            <option value="P"  {{ old('tipo_documento') == 'P' ? 'selected' : '' }}>P</option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="num_documento">* Número de Documento:</label>
        <input type="number" class="form-control @if( $errors->get('num_documento')) field-error @endif" name="num_documento" id="num_documento" placeholder="Ej: 14820336" value="{{ old('num_documento', $user->profile->num_documento) }}" autocomplete="off" minlength="7" maxlength="10" step="1">
    </div>
    <div class="form-group col-md-4">
        <a href="" class="btn btn-primary mt-2 text-center align-content-center">
            <i class="bi bi-search"></i>
            Buscar Empleado
        </a>
    </div>
</div>
<h2 class="pb-2 border-bottom border-secondary"> </h2>

<div class="row">
    <div class="form-group col-md-4">
        <label for="name">* Nombre y Apellido:</label>
        <input type="text" class="form-control @if( $errors->get('name')) field-error @endif" name="name" id="name" placeholder="Ej: Pedro Perez" value="{{ old('name', $user->name) }}" autocomplete="off" oninput="Sololetras(this)" minlength="4">
    </div>
    <div class="form-group col-md-4">
        <label for="email">* Correo Electrónico:</label>
        <input type="email" class="form-control @if( $errors->get('email')) field-error @endif" name="email" id="email" placeholder="Ej: pedro@example.com" value="{{ old('email', $user->email) }}" autocomplete="off">
    </div>
    <!-- <div class="form-group col-md-4">
            <label for="email">* Fecha de Nacimiento:</label>
            <input type="date" class="form-control @if( $errors->get('email')) field-error @endif" name="email" id="email" placeholder="Ej: pedro@example.com" value="{{ old('email', $user->email) }}" autocomplete="off">
    </div> -->
</div>


<div class="row">
    <div class="form-group col-md-4">
        <label for="password">* Contraseña:</label>
        <input type="password" class="form-control @if( $errors->get('password')) field-error @endif" name="password" id="password" placeholder="Ej: Mayor a 6 caracteres" value="{{ old('password') }}" minlength="6" maxlength="12">
    </div>
    <div class="form-group col-md-8">
        <label for="ubicacion">* Dirección de Domicilio:</label>
        <input type="text" class="form-control @if( $errors->get('ubicacion')) field-error @endif" name="ubicacion" id="ubicacion" placeholder="Ej: Urb. Andrés Bello casa #120" value="{{ old('ubicacion', $user->profile->ubicacion) }}" autocomplete="off">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="num_cel">* Número de Teléfono:</label>
        <input type="tel" class="form-control @if( $errors->get('num_cel')) field-error @endif" name="num_cel" id="num_cel" placeholder="Ej: 0276-3431103" oninput="NumTel(this)" minlength="12" maxlength="12"
               value="{{ old('num_cel', $user->profile->num_cel) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros digitos separados por un guion y luego los 7 digitos restantes" autocomplete="off">
    </div>
    <div class="form-group col-md-4">
        <label for="sucursal_id">* Sucursal:</label>
        <select name="sucursal_id" id="sucursal_id" class="form-control @if( $errors->get('sucursal_id')) field-error @endif">
            <option value="">--Selecciona una Sucursal Asociada--</option>
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}"{{ old('sucursal_id', $user->profile->sucursal_id) == $sucursal->id ? ' selected' : '' }}>
                    {{ ucwords($sucursal->nombre) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <h5 class="mt-3">* Rol</h5>
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
</div>

<!-- <div class="row">
        <div class="form-group col-md-4">
        <label for="num_cel">* Número de Teléfono:</label>
        <input type="tel" class="form-control @if( $errors->get('num_cel')) field-error @endif" name="num_cel" id="num_cel" placeholder="Ej: 0276-3431103" oninput="NumTel(this)" minlength="12" maxlength="12"
               value="{{ old('num_cel', $user->profile->num_cel) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros digitos separados por un guion y luego los 7 digitos restantes" autocomplete="off">
    </div>
    <div class="col-md-6 mt-3">
        <div class="form-check" >
                <input class="form-check-input" type="checkbox" :value="crearusuario" v-model="crearusuario" @click="configcrearusuario()" name="crearusuario" id="crearusuario">
                <label class="form-check-label" for="flexCheckDefault">
                    Agregar Servicio a Domicilio
                </label>
            </div>
                <div v-if="crearusuario">
                <div class="row">
                    <div class="col-md-6">
                        <label for="password">* Contraseña:</label>
                        <input type="password" class="form-control @if( $errors->get('password')) field-error @endif" name="password" id="password" placeholder="Ej: Mayor a 6 caracteres" value="{{ old('password') }}" minlength="6" maxlength="12">
                    </div>
                    <div class="col-md-6">
                        <label for="direccion">Punto de Referencia:</label>
                        <textarea type="text" class="form-control" name="referencia" v-model="referencia_delivery"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="costo_delivery">Costo del Servicio a Domicilio ($):</label>
                        <input type="number" class="form-control text-center" min="1"  name="costo_delivery" @keyup="setcostodelivery()" v-model="costo_delivery" minlength="1">
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
    </div>
    <div class="form-group col-md-4">
                <h5 class="mt-3">* Rol</h5>
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
</div> -->

<hr>



<div class="row mb-2">
    <h5 class="card-header">Preguntas de Seguridad</h5>
    <div class="col-6">
        <label for="tipo_documento">* Pregunta 1:</label>
        <select class="form-control @if( $errors->get('pregunta_1')) field-error @endif" name="pregunta_1" id="pregunta_1" @change="delete_option_selected()">
            <option value="">--Seleccionar una pregunta--</option>
            <option value="nombre primera mascota" @if($user->seguridad->pregunta_1=='nombre primera mascota') selected @endif>Nombre de la primera Mascota</option>
            <option value="nombre de la madre" @if($user->seguridad->pregunta_1=='nombre de la madre') selected @endif>Nombre de tu madre</option>
            <option value="comida favorita" @if($user->seguridad->pregunta_1=='comida favorita') selected @endif>Comida Favorita</option>
            <option value="deporte favorito" @if($user->seguridad->pregunta_1=='deporte favorito') selected @endif>Deporte Favorito</option>
        </select>
        <hr>
        <div class="form-group">
            <label for="ubicacion">* Respuesta:</label>
            <input type="text" class="form-control @if( $errors->get('respuesta_1')) field-error @endif" name="respuesta_1" id="respuesta_1" placeholder="Ingrese su respuesta" autocomplete="off" value="{{ old('respuesta_1', $user->seguridad->respuesta_1) }}" minlength="4">
        </div>

    </div>
    <div class="col-md-6">
        <label for="tipo_documento">* Pregunta 2:</label>
        <select class="form-control @if( $errors->get('pregunta_2')) field-error @endif" name="pregunta_2" id="pregunta_2">
            <option value="">--Seleccionar una pregunta--</option>
            <option value="nombre primera mascota" @if($user->seguridad->pregunta_2=='nombre primera mascota') selected @endif >Nombre de la primera Mascota</option>
            <option value="nombre de la madre" @if($user->seguridad->pregunta_2=='nombre de la madre') selected @endif>Nombre de tu madre</option>
            <option value="comida favorita" @if($user->seguridad->pregunta_2=='comida favorita') selected @endif>Comida Favorita</option>
            <option value="deporte favorito" @if($user->seguridad->pregunta_2=='deporte favorito') selected @endif>Deporte Favorito</option>
        </select>
        <hr>
        <div class="form-group">
            <label for="ubicacion">* Respuesta:</label>
            <input type="text" class="form-control @if( $errors->get('respuesta_2')) field-error @endif" name="respuesta_2" id="respuesta_2" placeholder="Ingrese su respuesta" autocomplete="off" value="{{ old('respuesta_2', $user->seguridad->respuesta_2) }}" minlength="4">
        </div>
    </div>
</div>

<div class="row pt-3">
    <label>* Campos obligatorios</label>
</div>
<hr>





