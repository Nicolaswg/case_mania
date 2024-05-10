<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\filters\ProductoFilter;
use App\Models\Producto;
use App\Models\Sortable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Psy\Util\Str;

class ProductoController extends Controller
{
    public function index(Request $request,ProductoFilter $filters,Sortable $sortable)
    {
        $productos = Producto::query()
            ->with( 'categoria')
            ->filterBy($filters,$request->only(['search','order','categoria']))
            ->orderByDesc('created_at')
            ->paginate(5);

        $productos->appends($filters->valid());//para concatenar a la paginacion en busqueda
        $sortable->appends($filters->valid());


        return view('productos.index', [
            'productos' => $productos,
            'sortable'=>$sortable,
            'categorias'=>Categoria::query()->orderBy('nombre')->get()
        ]);
    }
    public function create(){
        return $this->form('productos.create', new Producto,'create');
    }
    private function form(string $view, Producto $producto,$vista)
    {
        return view($view, [
            'producto' => $producto,
            'vista'=>$vista,
            'categorias'=>Categoria::query()->orderBy('nombre')->get(),
        ]);
    }
    public function store(CreateProductoRequest $request,Producto $producto){
       if($request->hasFile('photo')){
           $photo=$request->file('photo');
           $nombreimg=\Illuminate\Support\Str::slug($request->nombre).".".$photo->guessExtension();
           $ruta=public_path("storage/productos");
           $photo->move($ruta,$nombreimg);
        }else {
           $nombreimg = $producto->photo;
       }
        $producto=Producto::create([
            'nombre'=>$request->input('nombre'),
            'categoria_id'=>$request->input('categoria_id'),
            'cantidad'=>$request->input('cantidad'),
            'descripcion'=>$request->input('descripcion'),
            'photo'=>$nombreimg,
            'status'=>'Activo'
        ]);

        return redirect()->route('productos.index')->with('success','Producto Guardado de Forma Exitosa');
    }

    public function edit(Producto $producto)
    {
        return $this->form('productos.edit', $producto,'editar');
    }
    public function update(UpdateProductoRequest $request, Producto $producto)
    {

        if($request->hasFile('photo')){
            File::delete(public_path('storage/productos/' . $producto->photo));
            $photo=$request->file('photo');
            $nombreimg=\Illuminate\Support\Str::slug($request->nombre).".".$photo->guessExtension();
            $ruta=public_path("storage/productos");
            $photo->move($ruta,$nombreimg);
        }else{
            $nombreimg=$producto->photo;
        }
       $producto->update([
           'nombre'=>$request->nombre,
           'categoria_id'=>$request->categoria_id,
           'descripcion'=>$request->descripcion,
           'photo'=>$nombreimg,
           'cantidad'=>$request->cantidad,
       ]);

        return redirect()->route('productos.index')->with('success','Producto Actualizado de manera Exitosa');
    }
}
