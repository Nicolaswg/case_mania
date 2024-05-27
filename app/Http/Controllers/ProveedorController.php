<?php

namespace App\Http\Controllers;

use App\Models\filters\ProveedorFilter;
use App\Models\Proveedor;
use App\Models\Sortable;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request, ProveedorFilter $filters,Sortable $sortable)
    {
        $proveedores = Proveedor::query()
            ->filterBy($filters,$request->only(['status','search','order']))
            ->orderByDesc('created_at')
            ->paginate(5);

        $proveedores->appends($filters->valid());//para concatenar a la paginacion en busqueda
        $sortable->appends($filters->valid());


        return view('proveedores.index', [
            'proveedores' => $proveedores,
            'sortable'=>$sortable,
        ]);
    }
    public function create(){
        return $this->form('proveedores.create', new Proveedor(),'create');
    }
    private function form(string $view, Proveedor $proveedor,$vista)
    {
        return view($view, [
            'proveedor' => $proveedor,
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

       ]);

        Proveedor::create([
            'nombre'=>$request->nombre,
            'num_cel'=>$request->num_cel,
            'tipo'=>$request->tipo,
            'rif'=>$request->rif,
            'status'=>$request->state,
        ]);

        return redirect()->route('proveedores.index')->with('success','Proveedor Guardado con Exito');
    }
    public function edit(Proveedor $proveedor)
    {
        return $this->form('proveedores.edit', $proveedor,'editar');
    }
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'rif'=>'required',
            'num_cel'=>'required',
            'tipo'=>'required',
            'nombre'=>'required',
        ]);
        $proveedor->update([
            'nombre'=>$request->nombre,
            'num_cel'=>$request->num_cel,
            'tipo'=>$request->tipo,
            'rif'=>$request->rif,
            'status'=>$request->state,
        ]);
        $proveedor->save();

        return redirect()->route('proveedores.index')->with('success','Proveedor actualizado con Exito');
    }
    public function delete(Request $request)
    {
        $proveedor = Proveedor::query()->where('id', $request->proveedor_id)->first();
        $proveedor->status = 'inactive';
        $proveedor->save();
        return [
            'status'=>true,
        ];
    }
}
