<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\filters\CompraFilter;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Sortable;
use App\Models\Sucursal;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index(Request $request,CompraFilter $filters,Sortable $sortable)
    {
        $compras = Compra::query()
            ->with( 'proveedor')
            ->filterBy($filters,$request->only(['search','proveedor','order','sucursal']))
            ->orderByDesc('created_at')
            ->paginate(5);

        $compras->appends($filters->valid());//para concatenar a la paginacion en busqueda
        $sortable->appends($filters->valid());

        $sucursales=Sucursal::query()
            ->unless(auth()->user()->isAdmin(),function ($q){
                $q->where('id',auth()->user()->profile->sucursal->id);
            })->orderBy('nombre')->get();

        return view('compras.index', [
            'compras' => $compras,
            'sucursales'=>$sucursales,
            'sortable'=>$sortable,
            'proveedores'=>Proveedor::query()->whereHas('compras')->orderBy('nombre')->get()
        ]);
    }
    public function create(){
        return $this->form('compras.create', new Compra,'create');
    }
    private function form(string $view, Compra $compra,$vista)
    {
        $sucursales=Sucursal::query()
            ->unless(auth()->user()->isAdmin(),function ($q){
                $q->where('id',auth()->user()->profile->sucursal->id);
            })->where('active',true)->orderBy('nombre')->get();
        return view($view, [
            'compra' => $compra,
            'vista'=>$vista,
            'sucursales'=>$sucursales,
            'categorias'=>Categoria::query()->orderBy('nombre')->get(),
            'proveedores'=>Proveedor::query()->where('status','active')->orderBy('nombre')->get(),
        ]);
    }
    public function edit(Compra $compra){
        return $this->formedit('compras.edit',$compra,'editar');
    }
    public function selecdata(Request $request){
        $id_compra=$request->compra_id;
        $compra=Compra::query()->where('id',$id_compra)->first();
        $ids=(explode(',',$compra->detalle_compra->productos_ids));
        $cantidad=(explode(',',$compra->detalle_compra->cantidad));
        $nombres=explode(',',$compra->detalle_compra->productos_nombres);
        $precio_unitario=explode(',',$compra->detalle_compra->costo_unitario);
        $subtotal=explode(',',$compra->detalle_compra->subtotal);
        $photos=explode(',',$compra->detalle_compra->photos);
        $categoria=explode(',',$compra->detalle_compra->categorias_productos);
        $tasa=$compra->tasa_bcv;

        return[
            'compra_id'=>$compra,
            'ids'=>($ids),
            'cantidad'=>($cantidad),
            'tasa'=>$tasa,
            'nombres'=>($nombres),
            'precio_unitario'=>($precio_unitario),
            'subtotal'=>$subtotal,
            'photos'=>($photos),
            'categorias_compra'=>($categoria),
            'subtotal_factura'=>$compra->subtotal,
            'iva'=>$compra->iva,
            'total_factura'=>$compra->total,
            'proveedor_id'=>$compra->proveedor->id
        ];
    }
    public function update(Request $request){
        $compra=Compra::query()->where('id',$request->compra_id)->first();
        $productos_ids=explode(',',$compra->detalle_compra->productos_ids);
        $cantidad_ini=explode(',',$compra->detalle_compra->cantidad);
        foreach ($productos_ids as $i=>$id){
            $producto=Producto::query()->where('id',$id)->first();
            $producto->update([
                'cantidad'=>$producto->cantidad - (int) $cantidad_ini[$i]
            ]);
        }
        $compra->update([
            'proveedor_id' => (int) $request->proveedor_id,
            'fecha_compra' => Carbon::now()->setTimezone('America/Caracas'),
            'subtotal' => $request->subtotal_factura,
            'iva' => $request->iva_factura,
            'sucursal_id'=>$request->sucursal_id,
            'total' => $request->total_factura,
        ]);
        $compra->save();
        $compra->detalle_compra->update([
            'compra_id' => $compra->id,
            'productos_nombres' => implode(',', $request->nombre_productos),
            'categorias_productos' => implode(',', $request->categoria_productos),
            'productos_ids' => implode(',', $request->ids_productos),
            'cantidad' => implode(',', $request->cantidad_productos),
            'costo_unitario' => implode(',', $request->precio_productos),
            'photos' => implode(',', $request->photos_productos),
            'subtotal' => implode(',', $request->subtotal_productos),
        ]);
        foreach ($request->ids_productos as $i=>$id){
            $producto=Producto::query()->where('id',$id)->first();
            $producto->update([
                'precio_compra'=>(float)$request->precio_productos[$i],
                'cantidad'=>$producto->cantidad + (int) $request->cantidad_productos[$i]
            ]);
        }
        return [
            'status'=>true
        ];

    }

    public function store(Request $request){
        DB::transaction(function () use ($request) {
            $compra = Compra::create([
                'proveedor_id' => (int) $request->proveedor_id,
                'fecha_compra' => Carbon::now()->setTimezone('America/Caracas'),
                'subtotal' => $request->subtotal_factura,
                'tasa_bcv'=>$request->tasa,
                'sucursal_id'=>$request->sucursal_id,
                'iva' => $request->iva_factura,
                'total' => $request->total_factura,
            ]);

            DetalleCompra::create([
                'compra_id' => $compra->id,
                'productos_nombres' => implode(',', $request->nombre_productos),
                'categorias_productos' => implode(',', $request->categoria_productos),
                'productos_ids' => implode(',', $request->ids_productos),
                'cantidad' => implode(',', $request->cantidad_productos),
                'costo_unitario' => implode(',', $request->precio_productos),
                'photos' => implode(',', $request->photos_productos),
                'subtotal' => implode(',', $request->subtotal_productos),
            ]);
        });
        foreach ($request->ids_productos as $i=>$id){
            $producto=Producto::query()->where('id',$id)->first();
            $producto->update([
                'precio_compra'=>(float)$request->precio_productos[$i],
                'cantidad'=>$producto->cantidad + (int) $request->cantidad_productos[$i]
            ]);
        }
        return [
          'status'=>true,
        ];
    }
    public function showpdf(Compra $compra){
        $proveedor=$compra->proveedor->nombre;
        $nombre=explode(',',$compra->detalle_compra->productos_nombres);
        $cantidad=explode(',',$compra->detalle_compra->cantidad);
        $precio=explode(',',$compra->detalle_compra->costo_unitario);
        $subtotal=explode(',',$compra->detalle_compra->subtotal);
        $photos=explode(',',$compra->detalle_compra->photos);

           $pdf= Pdf::loadView('compras.recibo',[
               'compra'=>$compra,
               'nombre'=>$nombre,
               'cantidad'=>$cantidad,
               'precio'=>$precio,
               'photos'=>$photos,
               'subtotal'=>$subtotal,
            ]);
        return $pdf->stream('compra' . $compra->id . $proveedor. '.pdf');
    }

    private function formedit(string $view, Compra $compra,  $vista)
    {
        $ids=explode(',',$compra->detalle_compra->productos_ids);
        $cantidad=explode(',',$compra->detalle_compra->cantidad);
        $nombres=explode(',',$compra->detalle_compra->productos_nombres);
        $precio_unitario=explode(',',$compra->detalle_compra->costo_unitario);
        $subtotal=explode(',',$compra->detalle_compra->subtotal);
        $photos=explode(',',$compra->detalle_compra->photos);
        $categoria=explode(',',$compra->detalle_compra->categorias_productos);
        $sucursales=Sucursal::query()
            ->unless(auth()->user()->isAdmin(),function ($q){
                $q->where('id',auth()->user()->profile->sucursal->id);
            })->orderBy('nombre')->get();
        $tasa=$compra->tasa_bcv;
        return view($view, [
            'compra' => $compra,
            'vista'=>$vista,
            'tasa'=>$tasa,
            'sucursales'=>$sucursales,
            'categorias'=>Categoria::query()->orderBy('nombre')->get(),
            'proveedores'=>Proveedor::query()->orderBy('nombre')->get(),
            'ids'=>json_encode($ids),
            'nombres'=>json_encode($nombres),
            'cantidad'=>json_encode($cantidad),
            'precio_unitario'=>json_encode($precio_unitario),
            'subtotal'=>json_encode($subtotal),
            'photos'=>json_encode($photos),
            'categorias_compra'=>json_encode($categoria),

        ]);

    }
    public function delete(Request $request){
        $compra=Compra::query()->where('id',$request->compra_id)->first();
        $productos_ids=explode(',',$compra->detalle_compra->productos_ids);
        $cantidad_ini=explode(',',$compra->detalle_compra->cantidad);
        foreach ($productos_ids as $i=>$id){
            $producto=Producto::query()->where('id',$id)->first();
            $producto->update([
                'cantidad'=>$producto->cantidad - (int) $cantidad_ini[$i]
            ]);
        }
        $compra->forceDelete();
        return [
            'status'=>true
        ];

    }
}
