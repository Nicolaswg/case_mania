<form method="get" action="{{ url('delivery') }}">
    <div class="row row-filters">
        <div class="col-md-6">
            <div class="btn-group ">
                <select name="status" id="status" class="select-field">
                    <option value="">--Estado de Servicio a Domicilo--</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="proceso">En proceso</option>
                    <option value="entregado">Entregados</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row row-filters">
        <div class="col-md-10">
        <div class="form-inline form-search">
                <input type="search" name="search" value="{{ request('search') }}" size="80" class="form-control form-control-sm" placeholder="Buscar servicio a domicilio..." autocomplete="off">
                <button type="submit" class="btn btn-md btn-primary">Buscar</button>
            </div>
        </div>
    </div>
</form>

