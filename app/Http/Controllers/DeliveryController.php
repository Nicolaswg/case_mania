<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\filters\DeliveryFilter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
        public function index(Request $request, DeliveryFilter $filters){
            $deliverys=Delivery::query()
                ->with('venta','venta.detalle_venta','venta.cliente')
                ->filterBy($filters,$request->only(['status','search']))
                ->orderBy('created_at')
                ->paginate(5);

            $deliverys->appends($filters->valid());

            return view('deliverys.index', [
                'deliverys' => $deliverys,
            ]);
        }
        public function selecrepartidores(){


            $repartidores=User::query()
                ->where('role','=','delivery')
                ->unless(!auth()->user()->isDelivery(),function ($q){
                    $q->where('id',auth()->user()->id);
                })
              /*  ->whereHas('delivery',function ($q){
                    $q->where('status','=',null)
                        ->orWhere('status','=','entregado');
                })*/
                ->get();

            $nombres=[];
            $ids=[];
            foreach ($repartidores as $i=>$repartidor){
                if(count($repartidor->delivery)==0){
                    $nombres[]=$repartidor->name;
                    $ids[]=$repartidor->id;
                }
            }
            return [
                'nombres'=>$nombres,
                'ids'=>$ids,
            ];


        }
        public function updaterepartidor(Request $request){
            $delivery=Delivery::query()->where('id',$request->delivery_id)->first();
            $delivery->update([
                'user_id'=>$request->user_id,
                'status'=>'proceso'
            ]);
            $delivery->save();
            return [
                'status'=>true
            ];
        }
        public function update(Request $request){
            $delivery=Delivery::query()->where('id',$request->delivery_id)->first();
            $user=User::query()->where('id',$request->user_id)->first();
            $delivery->update([
                'user_id'=>null,
                'status'=>'entregado',
                'detalles_entrega'=>ucwords($user->name),
                'fecha_entrega'=>Carbon::now()->format('d-m-Y h:i A'),
            ]);
            $delivery->save();
            return [
                'status'=>true
            ];
        }

}
