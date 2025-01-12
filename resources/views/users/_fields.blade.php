@csrf

<!-- Bloque de nombre y apellido, correo electrónico y fecha de nacimeinto -->
<div class="row">
    <div class="form-group col-md-4"> <!-- Nombre y apellido -->
        <span class="note info text-white" v-if="showinfo" >Ingrese el nombre y apellido del empleado a registrar</span>
       <label for="name">* Nombre y Apellido: <button @click.prevent="verificarinfo()" id="name" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <input type="text" class="form-control @if( $errors->get('name')) field-error @endif" name="name" id="name" placeholder="Ej: Pedro Perez" value="{{ old('name', $user->name) }}" autocomplete="off" minlength="4" title="Debe ser mayor o igual a 4 caracteres">
    </div>
    <div class="form-group col-md-4"> <!-- Correo electrónico -->
        <span class="note info text-white" v-if="showinfo" >Ingrese el correo electrónico del empleado a registrar</span>
        <label for="email">* Correo Electrónico: <button @click.prevent="verificarinfo()" id="email" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <input type="email" class="form-control @if( $errors->get('email')) field-error @endif" name="email" id="email" placeholder="Ej: pedro@example.com" value="{{ old('email', $user->email) }}" autocomplete="off">
    </div>
    <div class="form-group col-md-4"> <!-- Fecha de nacimiento -->
            <span class="note info text-white" v-if="showinfo" >Ingrese la fecha de nacimiento del empleado a registrar (debe ser mayor a 18 años)</span>
            <label for="fecha_nacimiento">* Fecha de Nacimiento: <button @click.prevent="verificarinfo()" id="fecha_nacimiento" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <!-- <input type="date" class="form-control @if( $errors->get('email')) field-error @endif" name="email" id="email" placeholder="Ej: pedro@example.com" value="{{ old('email', $user->email) }}" autocomplete="off"> -->
    </div>
</div>

<!-- Bloque de tipo de documento, número de documento y número de teléfono -->

<div class="row">
    <div class="form-group col-md-4 "> <!-- tipo de documento -->
        <span class="note info text-white" v-if="showinfo" >Seleccione un tipo de documento del empleado a registrar</span>
        <label for="tipo_documento">* Tipo de Documento: <button @click.prevent="verificarinfo()" id="tipo_documento" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select class="form-control @if( $errors->get('tipo_documento')) field-error @endif text-center" name="tipo_documento" id="tipo_documento">
            <option value="">-- Seleccionar Documento --</option>
            <option value="V" @if($user->profile->tipo_documento=='V') selected @endif>Venezolano</option>
            <option value="E" @if($user->profile->tipo_documento=='E') selected @endif>Extranjero</option>
            <option value="J" @if($user->profile->tipo_documento=='J') selected @endif>Jurídico</option>
            <option value="P" @if($user->profile->tipo_documento=='P') selected @endif>Pasaporte</option>
            <option value="G" @if($user->profile->tipo_documento=='G') selected @endif>Gubernamental</option>
        </select>
    </div>
    <div class="form-group col-md-4"> <!-- Número de documento -->
        <span class="note info text-white" v-if="showinfo" >Ingrese el número de documento del empleado (mínimo 7 dígitos)</span>
        <label for="num_documento">* Número de Documento: <button @click.prevent="verificarinfo()" id="num_documento" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="text" class="form-control @if( $errors->get('num_documento')) field-error @endif" name="num_documento" id="num_documento" placeholder="Ej: 14820336" value="{{ old('num_documento', $user->profile->num_documento) }}" autocomplete="off" minlength="7" maxlength="10" title="Debe estar comprendido entre 7 y 10 caracteres">
    </div>
    <div class="form-group col-md-4"> <!-- Número de teléfono -->
        <span class="note info text-white" v-if="showinfo" >El formato debe coincidir con la siguiente manera:  Los 4 primeros dígitos separados por un guion y luego los 7 digitos restantes  </span>
        <label for="num_cel">* Número de Teléfono: <button @click.prevent="verificarinfo()" id="info_cel" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button> </label>
        <input type="tel" class="form-control @if( $errors->get('num_cel')) field-error @endif" name="num_cel" id="num_cel" placeholder="Ej: 0276-3431103" minlength="12" maxlength="12"
               value="{{ old('num_cel', $user->profile->num_cel) }}"
               pattern="[0-9]{4}-[0-9]{7}"
               title=" Los 4 primeros digítos separados por un guion y luego los 7 digítos restantes" autocomplete="off">
    </div>
</div>

<!-- Bloque de contraseña y dirección -->

<div class="row">
    <div class="form-group col-md-4"> <!-- Contraseña -->
    <span class="note info text-white" v-if="showinfo" >La contraseña debe ser entre 6 a 12 caracteres</span>
        <label for="password">* Contraseña: <button @click.prevent="verificarinfo()" id="password" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="password" class="form-control @if( $errors->get('password')) field-error @endif" name="password" id="password" placeholder="Ej: Mayor a 6 caracteres" value="{{ old('password') }}" minlength="6" maxlength="12" title="Debe estar comprendido entre 6 y 12 caracteres">
    </div>
    <div class="form-group col-md-8"> <!-- Dirección -->
    <span class="note info text-white" v-if="showinfo" >Ingrese la dirección del empleado a registrar</span>
        <label for="ubicacion">* Dirección de Domicilio: <button @click.prevent="verificarinfo()" id="ubicacion" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <input type="text" class="form-control @if( $errors->get('ubicacion')) field-error @endif" name="ubicacion" id="ubicacion" placeholder="Ej: Urb. Andrés Bello casa #120" value="{{ old('ubicacion', $user->profile->ubicacion) }}" autocomplete="off" maxlength="100" minlength="10" title="Debe ser mayor o igual a 10 caracteres">
    </div>
</div>

<!-- Bloque de Sucursal y Rol del usuario -->

<div class="row">
    <div class="form-group col-md-4"> <!-- Sucursal -->
    <span class="note info text-white" v-if="showinfo" >Debe seleccionar una sucursal al que va a pertenecer el empleado a registrar</span>
        <label for="sucursal_id">* Sucursal: <button @click.prevent="verificarinfo()" id="sucursal_id" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select name="sucursal_id" id="sucursal_id" class="form-control @if( $errors->get('sucursal_id')) field-error @endif">
            <option value="">-- Seleccionar una Sucursal --</option>
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}"{{ old('sucursal_id', $user->profile->sucursal_id) == $sucursal->id ? ' selected' : '' }}>
                    {{ ucwords($sucursal->nombre) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4"> <!-- Rol -->
    <span class="note info text-white" v-if="showinfo" >Escoja un rol del empleado a registrar</span>
        <h5 class="mt-3">* Rol:</h5>
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
<hr>

<!-- Bloque de preguntas de seguridad -->

<div class="row mb-2">
    <h5 class="card-header">Preguntas de Seguridad</h5>
    <div class="col-6"> <!-- Pregunta 1 -->
        <span class="note info text-white" v-if="showinfo" >Escoja 1 pregunta de seguridad</span>
        <label for="tipo_documento">* Pregunta 1: <button @click.prevent="verificarinfo()" id="tipo_documento" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select class="form-control @if( $errors->get('pregunta_1')) field-error @endif" name="pregunta_1" id="pregunta_1" @change="delete_option_selected()">
            <option value="">-- Seleccionar una Pregunta --</option> <!-- Lista de preguntas de seguridad -->
            <option value="Nombre de la Primera Mascota" @if($user->seguridad->pregunta_1=='Nombre de la Primera Mascota') selected @endif>Nombre de la Primera Mascota</option>
            <option value="Nombre de la Escuela Secundaria" @if($user->seguridad->pregunta_1=='Nombre de la Escuela Secundaria') selected @endif>Nombre de la Escuela Secundaria</option>
            <option value="Lugar Nacimiento" @if($user->seguridad->pregunta_1=='Lugar de Nacimiento') selected @endif>Lugar de Nacimiento</option>
            <option value="deporte favorito" @if($user->seguridad->pregunta_1=='deporte favorito') selected @endif>Deporte Favorito</option>
            <option value="Tradicion Familiar" @if($user->seguridad->pregunta_1=='Tradicion Familiar') selected @endif>Nombra una Tradición Familiar</option>
            <option value="Nombre del Sitio Turistico Favorito" @if($user->seguridad->pregunta_1=='Nombre del Sitio Turistico Favorito') selected @endif>Nombra un Sitio Turístico Favorito</option>
        </select>
        <hr>
        <div class="form-group"> <!-- Respuesta 1 -->
            <span class="note info text-white" v-if="showinfo" >Ingrese la primera respuesta en función de la pregunta 1 seleccionada</span>
            <label for="ubicacion">* Respuesta: <button @click.prevent="verificarinfo()" id="ubicación" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <input type="text" class="form-control @if( $errors->get('respuesta_1')) field-error @endif" name="respuesta_1" id="respuesta_1" placeholder="Ingrese su respuesta" autocomplete="off" value="{{ old('respuesta_1', $user->seguridad->respuesta_1) }}" minlength="4" title="Debe ser mayor o igual a 4 caracteres">
        </div>

    </div>
    <div class="col-md-6"> <!-- Pregunta 2 -->
        <span class="note info text-white" v-if="showinfo" >Escoja 1 pregunta de seguridad</span>
        <label for="tipo_documento">* Pregunta 2: <button @click.prevent="verificarinfo()" id="tipo_documento" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
        <select class="form-control @if( $errors->get('pregunta_2')) field-error @endif" name="pregunta_2" id="pregunta_2">
            <option value="">-- Seleccionar una Pregunta --</option> <!-- Lista de preguntas de seguridad -->
            <option value="Nombre de la Primera Mascota" @if($user->seguridad->pregunta_2=='Nombre de la Primera Mascota') selected @endif>Nombre de la Primera Mascota</option>
            <option value="Nombre de la Escuela Secundaria" @if($user->seguridad->pregunta_2=='Nombre de la Escuela Secundaria') selected @endif>Nombre de la Escuela Secundaria</option>
            <option value="Lugar Nacimiento" @if($user->seguridad->pregunta_2=='Lugar de Nacimiento') selected @endif>Lugar de Nacimiento</option>
            <option value="deporte favorito" @if($user->seguridad->pregunta_2=='deporte favorito') selected @endif>Deporte Favorito</option>
            <option value="Tradicion Familiar" @if($user->seguridad->pregunta_2=='Tradicion Familiar') selected @endif>Nombra una Tradición Familiar</option>
            <option value="Nombre del Sitio Turistico Favorito" @if($user->seguridad->pregunta_2=='Nombre del Sitio Turistico Favorito') selected @endif>Nombra un Sitio Turístico Favorito</option>
        </select>
        <hr>
        <div class="form-group"> <!-- Respuesta 2 -->
            <span class="note info text-white" v-if="showinfo" >Ingrese la segunda respuesta en función de la pregunta 2 seleccionada</span>
            <label for="ubicacion">* Respuesta: <button @click.prevent="verificarinfo()" id="ubicacion" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <input type="text" class="form-control @if( $errors->get('respuesta_2')) field-error @endif" name="respuesta_2" id="respuesta_2" placeholder="Ingrese su respuesta" autocomplete="off" value="{{ old('respuesta_2', $user->seguridad->respuesta_2) }}" minlength="4" title="Debe ser mayor o igual a 4 caracteres">
        </div>
    </div>
    <h5 class="text-center">Estimado usuario, las respuestas que sean ingresadas deberán ser escritas exactamente igual al momento de verificar las preguntas de seguridad cuando se quiera recuperar la contraseña</h5>
</div>

<div class="row pt-3">
    <label>* Campos obligatorios</label>
</div>
<hr>





