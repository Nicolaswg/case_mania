@csrf
<div class="row ">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control @if( $errors->get('nombre')) field-error @endif" name="nombre" id="nombre" placeholder="Pedro Perez" value="{{ old('nombre', $categoria->nombre) }}">
        </div>
    </div>
    <div class="col-md-6">
        <h5 class="mt-3">Estado</h5>
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
</div>



<hr>




