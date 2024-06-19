<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\filters\ProductoFilter;
use App\Models\Producto;
use App\Models\Sortable;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Psy\Util\Str;

class ProductoController extends Controller
{
    public function index(Request $request,ProductoFilter $filters,Sortable $sortable)
    {

        $productos = Producto::query()
            ->with( 'categoria')
            ->filterBy($filters,$request->only(['search','order','categoria','state','sucursal']))
            ->orderByDesc('created_at')
            ->paginate(5);
        $this->updadestateofproduct($productos);
        $productos->appends($filters->valid());//para concatenar a la paginacion en busqueda
        $sortable->appends($filters->valid());
        $sucursales=Sucursal::query()->unless(auth()->user()->isAdmin(),function ($q){
            $q->where('id',auth()->user()->profile->sucursal->id);
        })->orderBy('nombre')->get();
        return view('productos.index', [
            'productos' => $productos,
            'sucursales'=>$sucursales,
            'sortable'=>$sortable,
            'categorias'=>Categoria::query()->orderBy('nombre')->get()
        ]);
    }
    public function create(){
        return $this->form('productos.create', new Producto,'create');
    }
    private function form(string $view, Producto $producto,$vista)
    {
        $sucursales=Sucursal::query()->unless(auth()->user()->isAdmin(),function ($q){
        $q->where('id',auth()->user()->profile->sucursal->id);
    })->where('active',true)->orderBy('nombre')->get();

            $precio_venta=$producto->precio_venta == null ? 0 : $producto->precio_venta;
            $precio_compra=$producto->precio_compra == null ? 0 : $producto->precio_compra;
            $porcentaje_ganancia=$producto->porcentaje_ganancia == null ? 0 : $producto->porcentaje_ganancia;
            $tasa=$producto->tasa_bcv == null ? 0 : $producto->tasa_bcv;

        return view($view, [
            'producto' => $producto,
            'vista'=>$vista,
            'tasa'=>$tasa,
            'porcentaje_ganancia'=>$porcentaje_ganancia,
            'precio_venta'=>$precio_venta,
            'precio_compra'=>$precio_compra,
            'sucursales'=>$sucursales,
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
            'precio_compra'=>$request->input('precio_compra'),
            'porcentaje_ganancia'=>$request->input('porcentaje_ganancia'),
            'precio_venta'=>$request->input('precio_venta'),
            'sucursal_id'=>$request->sucursal_id,
            'photo'=>$nombreimg,
            'tasa_bcv'=>(float)$request->tasa_bcv,
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
           'porcentaje_ganancia'=>$request->porcentaje_ganancia,
           'precio_compra'=>$request->precio_compra,
           'precio_venta'=>$request->precio_venta,
           'sucursal_id'=>$request->sucursal_id,
       ]);

        return redirect()->route('productos.index')->with('success','Producto Actualizado de manera Exitosa');
    }
    private function updadestateofproduct($productos)
    {
        foreach ($productos as $i=>$producto){
            if($producto->precio_compra || $producto->precio_venta == null){
                $producto->status='inactivo';
            }
            if($producto->precio_compra != null){
                $producto->precio_venta=((float)$producto->precio_compra * ((int)$producto->porcentaje_ganancia/100))+$producto->precio_compra;
            }
            if($producto->precio_venta != null){
                $producto->status='activo';
            }
            $producto->save();
        }


    }
    public function selecproducto(Request $request){
        $categoria_id=$request->categoria_id;
        if($request->tipo == 'compras'){
            $productos= Producto::query()
                ->where('status','activo')
                ->whereHas('categoria',function ($q) use ($categoria_id){
                    $q->where('id',$categoria_id);
                })->orderBy('nombre')->get();
        }else{

            $productos= Producto::query()
                ->where('status','activo')
                ->whereHas('sucursal',function ($q) use ($request){
                    $q->where('id',$request->sucursal_id);
                })
                ->orwhereHas('almacen',function ($q) use ($request){
                    $q->where('sucursal_id',$request->sucursal_id);
                })
                ->whereHas('categoria',function ($q) use ($categoria_id){
                    $q->where('id',$categoria_id);
                })->orderBy('nombre')->get();
        }

        $nombres=[];
        $ids=[];
        $photos=[];
        $precio_venta=[];
        $descripcion=[];
        if (count($productos) != 0){
            foreach ($productos as $producto){
                $nombres[]=$producto->nombre;
                $ids[]=$producto->id;
                $photos[]=$producto->photo;
                $precio_venta[]=$producto->precio_venta;
                $descripcion[]=$producto->descripcion;

            }
            return[
                'nombres'=>$nombres,
                'ids'=>$ids,
                'photos'=>$photos,
                'nombre_categoria'=>ucwords($productos->first()->categoria->nombre),
                'precio_venta'=>$precio_venta,
                'descripcion'=>$descripcion,
            ];
        }else{
            return [
                'nombres'=>[],
                'ids'=>[],
                'photos'=>[],
                'nombre_categoria'=>'',
                'precio_venta'=>0,
            ];
        }

    }
    public function selecmaxproducto(Request $request){
        $producto_id=$request->producto_id;
        $producto= Producto::query()
            ->where('id',$producto_id)
            ->first();

        if($producto != null){
            if($producto->almacen != null ){
               $almacen= Almacen::query()->where('producto_id',$producto->id)->where('sucursal_id',$request->sucursal_id)->first();
               if($almacen == null){
                   $cantidad=$producto->cantidad;
               }else{
                   $cantidad=$almacen->cantidad_acumulada;
               }
            }

            return[
                'status'=>true,
                'maximo'=>$cantidad,
                'nombre'=>$producto->nombre,
            ];
        }else{
            return[
                'status'=>false
            ];
        }



    }
    public function delete(Request $request){
        $producto = Producto::query()->where('id', $request->producto_id)->first();
        $producto->forceDelete();
            return [
                'status'=>true,
            ];
    }
    //ALMACEN
    public function index_almacen(Request $request,ProductoFilter $filters,Sortable $sortable)
    {

        $productos = Producto::query()
            ->with( 'categoria')
            ->filterBy($filters,$request->only(['search','order','categoria','state','sucursal']))
            ->orderByDesc('created_at')
            ->paginate(5);

        $this->updadestateofproduct($productos);
        $productos->appends($filters->valid());//para concatenar a la paginacion en busqueda
        $sortable->appends($filters->valid());
        $sucursales=Sucursal::query()
        ->orderBy('nombre')->get();

        return view('productos.index_almacen', [
            'productos' => $productos,
            'sucursales'=>$sucursales,
            'sortable'=>$sortable,
            'categorias'=>Categoria::query()->orderBy('nombre')->get()
        ]);
    }
    public function traslados_almacen(Producto $producto){
        $sucursales=Sucursal::query()
            ->orderBy('nombre')->get();
      $canti=[];
      $nombre_sucur=[];

      //dd($producto->almacen);
      foreach ($sucursales as $i=>$sucursal){
          $nombre_sucur[$i]=$sucursal->nombre;
          if(count($producto->almacen) != 0){
              $produc=$sucursal->almacen()->where('sucursal_id',$sucursal->id )->where('producto_id',$producto->id)->orderBy('created_at')->first();
              if($produc != null){
                  $canti[$i]=$produc->cantidad_acumulada;
              }else{
                  $prod=$sucursal->productos->where('sucursal_id',$sucursal->id)->where('id',$producto->id)->first();
                  $canti[$i]=$prod->cantidad;
              }
          }else{
              $prod=$sucursal->productos->where('sucursal_id',$sucursal->id)->where('id',$producto->id)->first();
              if($prod != null){
                  $canti[$i]=$prod->cantidad;
              }else{
                  $canti[$i]=0;
              }
          }

      }
        return view('productos.traslados',[
            'producto'=>$producto,
            'sucursales'=>$sucursales,
            'cantidad'=>json_encode($canti),
            'nombre_sucur'=>json_encode($nombre_sucur),
        ]);
    }
    public function traslados_store(Request $request){
        $producto=Producto::query()->where('id',$request->producto_id)->first();
        $sucursal=strtolower($producto->sucursal->nombre);
        $hasta=$request->hasta;//para que sucursl va
        $desde=$request->desde;//de que sucursal viene
        $sucur_desde=Sucursal::query()->where('nombre',$desde)->first();
        $sucur_hasta=Sucursal::query()->where('nombre',$hasta)->first();
        $canti_traslado=$request->cantidad_traslado;

        if($producto->sucursal->id == $sucur_desde->id){
            $resta=(int) $producto->cantidad - (int)$canti_traslado;
            $producto->update([
                'cantidad'=>$resta
            ]);
            $producto->save();
        }
        if($producto->sucursal->id == $sucur_hasta->id){
            $suma=(int) $producto->cantidad + (int)$canti_traslado;
            $producto->update([
                'cantidad'=>$suma
            ]);
            $producto->save();
        }
        $almacen=Almacen::query()->where('producto_id',$producto->id)->where('sucursal_id',$sucur_hasta->id)->orderBy('created_at','desc')->first();
        if($almacen != null){
            $canti=$almacen->cantidad_acumulada + $canti_traslado;
            $almacen->update([
                'cantidad_acumulada'=>$canti,
                'created_at'=>Carbon::now(),
            ]);
            $almacen->save();
        }else{
            Almacen::create([
                'producto_id'=>$producto->id,
                'sucursal_id'=>$sucur_hasta->id,
                'cantidad'=>(int)$canti_traslado,
                'cantidad_acumulada'=>(int) $canti_traslado,
        ]);
        }
       return [
           'status'=>true,
       ];


    }

}
