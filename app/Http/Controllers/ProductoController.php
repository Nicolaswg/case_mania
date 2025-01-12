<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\filters\ProductoFilter;
use App\Models\Producto;
use App\Models\Proveedor;
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

        $productos = Producto::query() //Función para la cantidad de registros por página
            ->with( 'categoria')
            ->filterBy($filters,$request->only(['search','order','categoria','state','sucursal']))
            ->orderByDesc('created_at')
            ->paginate(10); //Cantidad de registros por página
        $this->updadestateofproduct($productos);
        $productos->appends($filters->valid());//para concatenar a la paginación en búsqueda
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
    public function create(){ //Función para crear los productos
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
    public function store(CreateProductoRequest $request,Producto $producto){ //Función para crear el producto
       if($request->hasFile('photo')){
           $photo=$request->file('photo');
           $nombreimg=\Illuminate\Support\Str::slug($request->nombre).".".$photo->guessExtension();
           $ruta=public_path("storage/productos");
           $photo->move($ruta,$nombreimg);
        }else {
           $nombreimg = $producto->photo;
       }
        $producto=Producto::create([ //Función para validar los que los campos no estén vacíos
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

        return redirect()->route('productos.index')->with('success','Producto Creado Exitosamente');
    }
    public function edit(Producto $producto)
    {
        return $this->form('productos.edit', $producto,'editar'); //Función para editar el producto
    }
    public function update(UpdateProductoRequest $request, Producto $producto) //Función para actualizar el producto
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

        return redirect()->route('productos.index')->with('success','Producto Actualizado Exitosamente');
    }
    private function updadestateofproduct($productos)
    {
        foreach ($productos as $i=>$producto){
            if($producto->precio_compra || $producto->precio_venta == null){
                $producto->status='activo';
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
    public function selecproducto(Request $request){ //Función para el producto
        if($request->tipo == 'compras'){
            $proveedor_id=$request->proveedor_id;
            $prove=Proveedor::query()->where('id',$proveedor_id)->first();
            $categoria_id=$prove->categoria->id;
            $productos= Producto::query()
                ->where('status','activo')
                ->whereHas('categoria',function ($q) use ($categoria_id){
                    $q->where('id',$categoria_id);
                })->orderBy('nombre')->get();
        }else{
            $categoria_id=$request->categoria_id;
            $productos= Producto::query()
                ->where('status','activo')
                ->where('cantidad','!=',null)
                ->where('porcentaje_ganancia','!=',null)
                ->whereHas('categoria',function ($q) use ($categoria_id){
                    $q->where('id',$categoria_id);
                })
                ->where(function ($q) use ($request){
                    $q->whereHas('sucursal',function ($q) use ($request){
                        $q->where('id',$request->sucursal_id);
                    })
                        ->orwhereHas('almacen',function ($q) use ($request){
                            $q->where('sucursal_id',$request->sucursal_id);
                        });
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
    public function selecmaxproducto(Request $request){ //Función para registrar la cantidad total del producto
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
    public function delete(Request $request){ //Función para eliminar el producto
        $producto = Producto::query()->where('id', $request->producto_id)->first();
        $producto->forceDelete();
            return [
                'status'=>true,
            ];
    }
    //APARTADO DEL ALMACÉN
    public function index_almacen(Request $request,ProductoFilter $filters,Sortable $sortable)
    {

        $productos = Producto::query() //Función para la cantidad de productos por página
            ->with( 'categoria')
            ->filterBy($filters,$request->only(['search','order','categoria','state','sucursal']))
            ->orderByDesc('created_at')
            ->paginate(10); //Cantidad de productos por página

        $this->updadestateofproduct($productos);
        $productos->appends($filters->valid());//para concatenar a la paginación en búsqueda
        $sortable->appends($filters->valid());
        $sucursales=Sucursal::query()
        ->orderBy('nombre')->get();

        return view('productos.index_almacen', [ //Función para el producto en el almacén
            'productos' => $productos,
            'sucursales'=>$sucursales,
            'sortable'=>$sortable,
            'categorias'=>Categoria::query()->orderBy('nombre')->get()
        ]);
    }
    public function update_productos(Request $request){ //Función para que el estado del producto sea "activo" cuando se agregue el producto al almacén y se le coloque el precio de venta
        foreach ($request->ids_productos as $i=>$id) {
            $producto = Producto::query()->where('id', $id)->first();
            $producto->update([
                'precio_compra' => (float)$request->precio_productos[$i],
                'cantidad' => $producto->cantidad + (int)$request->cantidad_productos[$i]
            ]);
        }
        $compra=Compra::query()->where('id',$request->compra_id)->first();
        $compra->update([
            'status_carga'=>true,
        ]);
       return [
           'status'=>true
       ];
    }
    public function update_venta(Request $request){
        $producto = Producto::query()->where('id', $request->producto_id)->first();
        $producto->update([
            'porcentaje_ganancia'=>(int)$request->porcentaje_ganancia,
            'precio_venta'=>(int)$request->precio_venta
        ]);
        $producto->save();

        return[
            'status'=>true,
        ];

    }
    public function traslados_almacen(Producto $producto){ //Función para el traslado de los productos
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
                  if($prod != null){
                      $canti[$i]=$prod->cantidad;
                  }else{
                      $canti[$i]=0;
                  }
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
    public function config_venta(Producto $producto){
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
                    if($prod != null){
                        $canti[$i]=$prod->cantidad;
                    }else{
                        $canti[$i]=0;
                    }
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
        return view('productos.configurar_venta',[
            'producto'=>$producto,
            'sucursales'=>$sucursales,
            'cantidad'=>json_encode($canti),
            'nombre_sucur'=>json_encode($nombre_sucur),
        ]);
    }

}
