<form method="get" action="{{ url('servicio') }}">
    <div class="row row-filters"> <!-- Filtro de Búsqueda -->
        <div class="col-md-10">
            <div class="form-inline form-search"> <!-- Cuadro de texto para la búsqueda -->
                <input type="search" name="search" value="{{ request('search') }}" size="80" class="form-control form-control-sm" placeholder="Buscar servicio técnico...">
                <button type="submit" class="btn btn-md btn-primary">Buscar</button>
            </div>
        </div>
    </div>
</form>

