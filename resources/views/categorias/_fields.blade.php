@csrf

<!-- Bloque de nombre de la categoría -->

<div class="row "> <!-- Nombre de la categoría -->
    <div class="col-md-6">
        <div class="form-group">
            <span class="note info text-white" v-if="showinfo" >Ingrese el nombre de la categoría a registrar</span>
            <label for="nombre">* Nombre de la Categoría: <button @click.prevent="verificarinfo()" id="nombre" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
            <textarea type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Ej: Audífonos" value="{{ old('nombre', $categoria->nombre) }}" autocomplete="off" minlength="5" title="Debe ser mayor o igual a 5 caracteres"></textarea>
        </div>
    </div>
    <div class="col-md-6"> <!-- Estado de la categoría -->
        <h5 class="mt-3">* Estado</h5>
        @foreach(trans('users.states') as $state=>$text)
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                       type="radio"
                       name="state"
                       id="role_{{ $state }}"
                       value="{{$state}}"
                       @if($state == 'active') checked @endif
                    {{ old('status', $categoria->status) == $state ? 'checked' : '' }}>
                <label class="form-check-label" for="state_{{ $state }}">{{ $text }}</label>
            </div>
        @endforeach
    </div>
    <div class="row pt-3">
    <label>* Campos obligatorios</label>
    </div>
</div>



<hr>




