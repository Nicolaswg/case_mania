<form method="get" action="{{ url('proveedores') }}">
    <div class="row row-filters">
        <div class="col-md-6">
            @foreach (trans('users.filters.states') as $value => $text)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status"
                           id="state_{{ $value }}" value="{{ $value }}" {{ $value == request('status') ? 'checked' : '' }}>
                    <label class="form-check-label" for="state_{{ $value }}">{{ $text }}</label>
                </div>
            @endforeach
        </div>

    </div>
    <div class="row row-filters">
        <div class="col-md-10">
            <div class="form-inline form-search">
                <input type="search" name="search" value="{{ request('search') }}" size="80" class="form-control form-control-sm" placeholder="Buscar...">
                <button type="submit" class="btn btn-md btn-primary">Filtrar</button>
            </div>
        </div>
    </div>
</form>

