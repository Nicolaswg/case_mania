<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::query() //Función para la cantidad de registros por página
            ->orderBy('nombre')
            ->paginate(10); //Cantidad de registros por página

        return view('sucursales.index', [
            'sucursales' => $sucursales,
        ]);
    }
    public function create(){ //Función para crear una sucursal
        return $this->form('sucursales.create', new Sucursal(),'create');
    }
    private function form(string $view, Sucursal $sucursal,$vista)
    {
        return view($view, [
            'sucursal' => $sucursal,
            'vista'=>$vista
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([ //Función para validar los campos solicitados
            'nombre'=>'required',
            'estado'=>'required',
            'ciudad'=>'required',
            'codigo'=>'required'
        ]);

        Sucursal::create([
            'nombre'=>$request->nombre,
            'active'=> $request->state== 'active',
            'codigo'=>$request->codigo,
            'estado'=>$request->estado,
            'ciudad'=>$request->ciudad,
        ]);
        return redirect()->route('sucursales.index')->with('success','Sucursal Creada Exitosamente');

    }
    public function edit(Sucursal $sucursal) //Función para editar la sucursal
    {
        return $this->form('sucursales.edit', $sucursal,'editar');
    }
    public function update(Request $request, Sucursal $sucursal) //Función para actualizar los datos
    {
        $request->validate([ //Función para validar los campos solicitados
            'nombre'=>'required',
            'estado'=>'required',
            'ciudad'=>'required',
            'codigo'=>'required'
        ]);
        $sucursal->update([
            'nombre'=>$request->nombre,
            'active'=> $request->state== 'active',
            'codigo'=>$request->codigo,
            'estado'=>$request->estado,
            'ciudad'=>$request->ciudad,
        ]);
        $sucursal->save();

        return redirect()->route('sucursales.index')->with('success','Sucursal Actualizada Exitosamente');
    }
    public function delete(Request $request) //Función para desactivar la sucursal
    {
        $sucursal = Sucursal::query()->where('id', $request->sucursal_id)->first();
        $sucursal->active = false;
        $sucursal->save();
        return [
            'status'=>true,
        ];
    }
}
