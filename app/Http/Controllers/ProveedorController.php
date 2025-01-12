<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\filters\ProveedorFilter;
use App\Models\Proveedor;
use App\Models\Sortable;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request, ProveedorFilter $filters,Sortable $sortable)
    {
        $proveedores = Proveedor::query() //Función para la cantidad de registros por página
            ->filterBy($filters,$request->only(['status','search','order']))
            ->orderByDesc('created_at')
            ->paginate(10); //Cantidad de registros por página

        $proveedores->appends($filters->valid());//para concatenar a la paginación en búsqueda
        $sortable->appends($filters->valid());


        return view('proveedores.index', [
            'proveedores' => $proveedores,
            'sortable'=>$sortable,
        ]);
    }
    public function create(){ //Función para crear los proveedores
        return $this->form('proveedores.create', new Proveedor(),'create');
    }
    private function form(string $view, Proveedor $proveedor,$vista)
    {
        return view($view, [
            'proveedor' => $proveedor,
            'categorias'=>Categoria::query()->orderBy('nombre')->get(),
            'vista'=>$vista
        ]);
    }
    public function store(Request $request)
    {
       $request->validate([
           'rif'=>'required',
           'num_cel'=>'required',
           'tipo'=>'required',
           'nombre'=>'required',
           'categoria_id'=>'required'

       ]);
        Proveedor::create([
            'nombre'=>$request->nombre,
            'num_cel'=>$request->num_cel,
            'tipo'=>$request->tipo,
            'rif'=>$request->rif,
            'status'=>$request->state,
            'categoria_id'=>$request->categoria_id,
        ]);

        return redirect()->route('proveedores.index')->with('success','Proveedor Creado Exitosamente');
    }
    public function edit(Proveedor $proveedor) //Función para editar los proveedores
    {
        return $this->form('proveedores.edit', $proveedor,'editar');
    }
    public function update(Request $request, Proveedor $proveedor) //Función para actualizar los proveedores
    {
        $request->validate([ //Función para validar los campos solicitados
            'rif'=>'required',
            'num_cel'=>'required',
            'tipo'=>'required',
            'nombre'=>'required',
            'categoria_id'=>'required'

        ]);
        $proveedor->update([
            'nombre'=>$request->nombre,
            'num_cel'=>$request->num_cel,
            'tipo'=>$request->tipo,
            'rif'=>$request->rif,
            'status'=>$request->state,
            'categoria_id'=>$request->categoria_id,
        ]);
        $proveedor->save();

        return redirect()->route('proveedores.index')->with('success','Proveedor Actualizado Exitosamente');
    }
    public function delete(Request $request) //Función para inactivar a los proveedores
    {
        $proveedor = Proveedor::query()->where('id', $request->proveedor_id)->first();
        $proveedor->status = 'inactive';
        $proveedor->save();
        return [
            'status'=>true,
        ];
    }
}
