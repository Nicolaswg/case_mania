<form method="get" action="{{ url('compras') }}">
    <div class="row row-filters">
        <div class="col-md-10">
            <div class="form-inline form-search">
                <input type="search" name="search" value="{{ request('search') }}" size="80" class="form-control form-control-sm" placeholder="Buscar por producto...">
                <button type="submit" class="btn btn-md btn-primary">Filtrar</button>
            </div>
        </div>
    </div>
    <div class="row row-filters">
        <div class="col-md-6">
            <div class="form-check-inline">
            <div class="form-inline form-search">
                <div class="btn-group ">
                    <select name="proveedor" id="proveedor" class="select-field">
                        <option value="">--Buscar por Proveedor--</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}"{{ request('proveedor') == $proveedor->id ? ' selected' : '' }}>{{ ucwords($proveedor->nombre) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div class="form-inline form-search ml-3">
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
    </div>
</form>
