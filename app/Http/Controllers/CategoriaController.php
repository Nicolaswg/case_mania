<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::query()
            ->with('productos')
            ->orderBy('nombre')
            ->paginate(5);

        return view('categorias.index', [
            'categorias' => $categorias,
        ]);
    }
    public function create(){
        return $this->form('categorias.create', new Categoria(),'create');
    }
    private function form(string $view, Categoria $categoria,$vista)
    {
        return view($view, [
            'categoria' => $categoria,
            'vista'=>$vista
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required',
        ]);

        Categoria::create([
            'nombre'=>$request->nombre,
            'active'=> $request->state== 'active',
        ]);

        return redirect()->route('categorias.index')->with('success','Categoria Guardado con Exito');
    }
    public function edit(Categoria $categoria)
    {
        return $this->form('categorias.edit', $categoria,'editar');
    }
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
          'nombre'=>'required'

        ]);
        $categoria->update([
            'nombre'=>$request->nombre,
            'active'=> $request->state == 'active',
        ]);
        $categoria->save();

        return redirect()->route('categorias.index')->with('success','Categoria actualizado con Exito');
    }
    public function delete(Request $request)
    {
        $categoria = Categoria::query()->where('id', $request->categoria_id)->first();
        $categoria->active = false;
        $categoria->save();
        return [
            'status'=>true,
        ];
    }
}
