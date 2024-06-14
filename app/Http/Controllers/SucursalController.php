<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::query()
            ->orderBy('nombre')
            ->paginate(5);

        return view('sucursales.index', [
            'sucursales' => $sucursales,
        ]);
    }
    public function create(){
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
        $request->validate([
            'nombre'=>'required',
        ]);

        Sucursal::create([
            'nombre'=>$request->nombre,
            'active'=> $request->state== 'active',
        ]);
        return redirect()->route('sucursales.index')->with('success','Sucursal Guardado con Exito');

    }
    public function edit(Sucursal $sucursal)
    {
        return $this->form('sucursales.edit', $sucursal,'editar');
    }
    public function update(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'nombre'=>'required'

        ]);
        $sucursal->update([
            'nombre'=>$request->nombre,
            'active'=> $request->state == 'active',
        ]);
        $sucursal->save();

        return redirect()->route('sucursales.index')->with('success','Sucursal actualizado con Exito');
    }
    public function delete(Request $request)
    {
        $sucursal = Sucursal::query()->where('id', $request->sucursal_id)->first();
        $sucursal->active = false;
        $sucursal->save();
        return [
            'status'=>true,
        ];
    }
}
