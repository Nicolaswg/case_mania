<form method="get" action="{{ url('ventas') }}">
    <div class="row row-filters">
        <div class="col-md-8"> <!-- Filtros de servicios a domicilios pendientes -->
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="pendiente" {{'pendiente' == request('delivery') ? 'checked' : ''}} id="" name="delivery">
                <label class="form-check-label" for="flexCheckDefault">
                Servicios a Domicilio Pendientes
                </label>
            </div>
        </div>
    </div>
    <div class="row row-filters"> <!-- Cuadro de texto para busca una venta -->
        <div class="col-md-10">
            <div class="form-inline form-search">
                <input type="search" name="search" value="{{ request('search') }}" size="80" class="form-control form-control-sm" placeholder="Buscar venta..." autocomplete="off">
                <button type="submit" class="btn btn-md btn-primary">Buscar</button>
            </div>
        </div>
    </div>
    <div class="row row-filters"> <!-- Filtro para buscar por sucursal -->
        <div class="col-md-6">
            <div class="form-inline form-search">
                <div class="btn-group ">
                    <select name="sucursal" id="sucursal" class="select-field">
                        <option value="">--Buscar por Sucursal--</option>
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}"{{ request('sucursal') == $sucursal->id ? ' selected' : '' }}>{{ ucwords($sucursal->nombre) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
