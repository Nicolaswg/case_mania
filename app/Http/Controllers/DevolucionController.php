<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DevolucionController extends Controller
{
    public function create(Venta $venta){
        $productos=explode(',',$venta->detalle_venta->productos_nombres);
        $categorias=explode(',',$venta->detalle_venta->categorias_productos);
        $ids=explode(',',$venta->detalle_venta->ids);
        $cantidad=explode(',',$venta->detalle_venta->cantidad);
         return view('devoluciones.create',[
             'productos'=>$productos,
             'categorias'=>$categorias,
             'ids'=>$ids,
             'cantidad'=>$cantidad,
             'venta'=>$venta,
         ]);
    }
    public function store(Request $request){
      Devolucion::create([ //Función para crear la devolución
          'fecha_devolucion'=>Carbon::now(),
          'user'=>auth()->user()->name,
          'motivo_devolucion'=>$request->razon_devolucion,
          'venta_id'=>$request->venta_id,
      ]);
      $venta=Venta::query()->where('id',$request->venta_id)->first(); //Función para el estado de la devolución
      $venta->update([
          'status'=>'devuelto',
          'total_dolar'=>0,
          'subtotal_dolar'=>0,
          'iva_dolar'=>0,
      ]);

      if($venta->delivery){
          $venta->delivery->forceDelete();
      }

      foreach (explode(',',$venta->detalle_venta->productos_ids) as $i=>$producto){ //Cantidad de devueltos
          $producto_id=(int)$producto;
          $cantidad=explode(',',$venta->detalle_venta->cantidad);
          $prod=Producto::query()->where('id',$producto_id)->first();
          $prod->update([
              'cantidad_devueltos'=>$cantidad[$i]
          ]);
          $prod->save();
      }
      $venta->save();

      return redirect()->route('ventas.index')->with('success','Devolución Realizada Exitosamente');


    }
}
