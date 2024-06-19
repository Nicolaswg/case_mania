<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\filters\VentaFilter;
use App\Models\Producto;
use App\Models\Sortable;
use App\Models\Sucursal;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request,VentaFilter $filters,Sortable $sortable)
    {
        $ventas = Venta::query()
            ->with( 'cliente')
            ->filterBy($filters,$request->only(['search','order','sucursal','delivery']))
            ->orderByDesc('created_at')
            ->paginate(5);

        $ventas->appends($filters->valid());
        $sortable->appends($filters->valid());

        return view('ventas.index', [
            'ventas' => $ventas,
            'sucursales'=>Sucursal::query()->orderBy('nombre')->get(),
            'sortable'=>$sortable,
        ]);
    }
    public function create(){
        return $this->form('ventas.create', new Venta,'create');
    }
    private function form(string $view, Venta $venta,$vista)
    {
        $sucursales=Sucursal::query()
            ->unless(auth()->user()->isAdmin(),function ($q){
                $q->where('id',auth()->user()->profile->sucursal->id);
            })->where('active',true)->orderBy('nombre')->get();
        return view($view, [
            'venta' => $venta,
            'categorias'=>Categoria::query()->orderBy('nombre')->get(),
            'vista'=>$vista,
            'sucursales'=>$sucursales,
            'clientes'=>Cliente::query()->where('status','active')->orderBy('nombre')->get(),
        ]);
    }
    public function store(Request $request){
        DB::transaction(function () use ($request) {
            $venta = Venta::create([
                'cliente_id' => (int) $request->cliente_id,
                'fecha_venta' => Carbon::now()->setTimezone('America/Caracas'),
                'subtotal_dolar' => $request->subtotal_factura,
                'iva_dolar' => $request->iva_factura,
                'total_dolar' => $request->total_factura,
                'sucursal_id'=>$request->sucursal_id,
                'tasa_bcv'=>$request->tasa,
            ]);

            DetalleVenta::create([
                'venta_id' => $venta->id,
                'productos_nombres' => implode(',', $request->nombre_productos),
                'categorias_productos' => implode(',', $request->categoria_productos),
                'productos_ids' => implode(',', $request->ids_productos),
                'cantidad' => implode(',', $request->cantidad_productos),
                'costo_unitario' => implode(',', $request->precio_productos),
                'photos' => implode(',', $request->photos_productos),
                'subtotal' => implode(',', $request->subtotal_productos),
            ]);
            if($request->delivery == 'true'){
                $venta->delivery->create([
                    'venta_id'=>$venta->id,
                    'direccion'=>$request->direccion_delivery,
                    'referencia'=>$request->referencia_delivery,
                    'costo_delivery'=>(float)$request->costo_delivery,
                    'status'=>'pendiente',
                ]);
            }
        });
        foreach ($request->ids_productos as $i=>$id){
            $producto=Producto::query()->where('id',$id)->first();
            if($producto->almacen != null ){
                $almacen= Almacen::query()->where('producto_id',$producto->id)->where('sucursal_id',$request->sucursal_id)->first();
                if($almacen == null){
                    $producto->update([
                        'cantidad'=>$producto->cantidad - (int) $request->cantidad_productos[$i]
                    ]);
                }else{
                    $almacen->update([
                        'cantidad_acumulada'=>$almacen->cantidad_acumulada - (int) $request->cantidad_productos[$i],
                    ]);
                }
            }
        }
        return [
            'status'=>true,
        ];
    }
    public function delete(Request $request){
        $venta=Venta::query()->where('id',$request->venta_id)->first();
        $productos_ids=explode(',',$venta->detalle_venta->productos_ids);
        $cantidad_ini=explode(',',$venta->detalle_venta->cantidad);
        foreach ($productos_ids as $i=>$id){
            $producto=Producto::query()->where('id',$id)->first();
            $producto->update([
                'cantidad'=>$producto->cantidad + (int) $cantidad_ini[$i]
            ]);
        }
        $venta->forceDelete();
        return [
            'status'=>true
        ];

    }
    public function showpdf(Venta $venta){
        $cliente=$venta->cliente->nombre;
        $nombre=explode(',',$venta->detalle_venta->productos_nombres);
        $cantidad=explode(',',$venta->detalle_venta->cantidad);
        $precio=explode(',',$venta->detalle_venta->costo_unitario);
        $subtotal=explode(',',$venta->detalle_venta->subtotal);
        $photos=explode(',',$venta->detalle_venta->photos);

        $pdf= Pdf::loadView('ventas.recibo',[
            'venta'=>$venta,
            'nombre'=>$nombre,
            'cantidad'=>$cantidad,
            'precio'=>$precio,
            'photos'=>$photos,
            'subtotal'=>$subtotal,
        ]);
        return $pdf->stream('venta' . $venta->id . $cliente. '.pdf');
    }
    public function edit(Venta $venta){
        return $this->formedit('ventas.edit',$venta,'editar');
    }
    private function formedit(string $view, Venta $venta,  $vista)
    {
        $ids=explode(',',$venta->detalle_venta->productos_ids);
        $cantidad=explode(',',$venta->detalle_venta->cantidad);
        $nombres=explode(',',$venta->detalle_venta->productos_nombres);
        $precio_unitario=explode(',',$venta->detalle_venta->costo_unitario);
        $subtotal=explode(',',$venta->detalle_venta->subtotal);
        $photos=explode(',',$venta->detalle_venta->photos);
        $categoria=explode(',',$venta->detalle_venta->categorias_productos);
        $sucursales=Sucursal::query()
            ->unless(auth()->user()->isAdmin(),function ($q){
                $q->where('id',auth()->user()->profile->sucursal->id);
            })->orderBy('nombre')->get();
        return view($view, [
            'venta' => $venta,
            'vista'=>$vista,
            'sucursales'=>$sucursales,
            'categorias'=>Categoria::query()->orderBy('nombre')->get(),
            'clientes'=>Cliente::query()->orderBy('nombre')->get(),
            'ids'=>json_encode($ids),
            'nombres'=>json_encode($nombres),
            'cantidad'=>json_encode($cantidad),
            'precio_unitario'=>json_encode($precio_unitario),
            'subtotal'=>json_encode($subtotal),
            'photos'=>json_encode($photos),
            'categorias_compra'=>json_encode($categoria),

        ]);

    }
    public function selecdata(Request $request){
        $id_venta=$request->venta_id;
        $venta=Venta::query()->where('id',$id_venta)->first();
        $ids=(explode(',',$venta->detalle_venta->productos_ids));
        $cantidad=(explode(',',$venta->detalle_venta->cantidad));
        $nombres=explode(',',$venta->detalle_venta->productos_nombres);
        $precio_unitario=explode(',',$venta->detalle_venta->costo_unitario);
        $subtotal=explode(',',$venta->detalle_venta->subtotal);
        $photos=explode(',',$venta->detalle_venta->photos);
        $categoria=explode(',',$venta->detalle_venta->categorias_productos);

        if($venta->delivery->id != null){
            $delivery=true;
            $costo_delivery=$venta->delivery->costo_delivery;
            $direccion_delivery=$venta->delivery->direccion;
            $referencia_delivery=$venta->delivery->referencia;
            $costo_delivery_bs=number_format((float)$venta->delivery->costo_delivery*(float) $venta->tasa_bcv,2,',','.');
        }else{
            $delivery=false;
            $referencia_delivery='';
            $costo_delivery='';
            $direccion_delivery='';
            $costo_delivery_bs='';
        }


        return[
            'venta_id'=>$venta,
            'ids'=>($ids),
            'cantidad'=>($cantidad),
            'nombres'=>($nombres),
            'precio_unitario'=>($precio_unitario),
            'subtotal'=>($subtotal),
            'photos'=>($photos),
            'categorias_venta'=>($categoria),
            'subtotal_factura'=>$venta->subtotal_dolar,
            'iva'=>$venta->iva_dolar,
            'total_factura'=>$venta->total_dolar,
            'cliente_id'=>$venta->cliente->id,
            //DELIVERY
            'delivery'=>$delivery,
            'referencia_delivery'=>$referencia_delivery,
            'direccion_delivery'=>$direccion_delivery,
            'costo_delivery'=>$costo_delivery,
            'costo_delivery_bs'=>$costo_delivery_bs,
        ];
    }
    public function update(Request $request){
        $venta=Venta::query()->where('id',$request->venta_id)->first();
        $productos_ids=explode(',',(int)$venta->detalle_venta->productos_ids);
        $cantidad_ini=explode(',',$venta->detalle_venta->cantidad);

        foreach ($productos_ids as $i=>$id){
            $producto=Producto::query()->where('id','=',$id)->first();
            $producto->update([
                'cantidad'=>$producto->cantidad + (int) $cantidad_ini[$i]
            ]);
        }
        $venta->update([
            'cliente_id' => (int) $request->cliente_id,
            'fecha_venta' => Carbon::now()->setTimezone('America/Caracas'),
            'subtotal_dolar' => $request->subtotal_factura,
            'iva_dolar' => $request->iva_factura,
            'sucursal_id'=>(int)$request->sucursal_id,
            'total_dolar' => $request->total_factura,
            'tasa_bcv'=>$request->tasa_bcv,
        ]);
        $venta->save();
        if($request->delivery == 'true'){
            if($venta->delivery->id == null){
                $venta->delivery->create([
                    'direccion'=>$request->direccion_delivery,
                    'referencia'=>$request->referencia_delivery,
                    'costo_delivery'=>(float)$request->costo_delivery,
                    'status'=>'pendiente',
                    'venta_id'=>$venta->id,
                ]);
            }else{
                $venta->delivery->update([
                    'direccion'=>$request->direccion_delivery,
                    'referencia'=>$request->referencia_delivery,
                    'costo_delivery'=>(float)$request->costo_delivery,
                    'status'=>'pendiente',
                ]);
            }

        }
        $venta->detalle_venta->update([
            'venta_id' => $venta->id,
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
                'cantidad'=>$producto->cantidad - (int) $request->cantidad_productos[$i]
            ]);
        }
        return [
            'status'=>true,
            'delivery'=>$request->delivery,
        ];

    }


}
