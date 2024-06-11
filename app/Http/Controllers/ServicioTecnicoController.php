<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\filters\ProveedorFilter;
use App\Models\filters\ServicioFilter;
use App\Models\Proveedor;
use App\Models\ServicioTecnico;
use App\Models\Sortable;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServicioTecnicoController extends Controller
{
    public function index(Request $request,ServicioFilter $filters)
    {
        $servicios = ServicioTecnico::query()
            ->filterBy($filters,$request->only(['search']))
            ->orderByDesc('created_at')
            ->paginate(5);

        $servicios->appends($filters->valid());//para concatenar a la paginacion en busqueda


        return view('servicios.index', [
            'servicios' => $servicios,
        ]);
    }
    public function create(){
        return $this->form('servicios.create', new ServicioTecnico(),'create');
    }
    public function edit(ServicioTecnico $servicioTecnico){
        return $this->formedit('servicios.edit',$servicioTecnico,'editar');
    }

    private function form(string $view, ServicioTecnico $servicioTecnico,$vista)
    {
        return view($view, [
            'clientes'=>Cliente::query()->where('status','active')->orderBy('nombre')->get(),
            'servicio' => $servicioTecnico,
            'vista'=>$vista
        ]);
    }
    public function store(Request $request){
        ServicioTecnico::create([
            'fecha_recibido'=>Carbon::now(),
            'falla'=>implode(',',$request->falla),
            'productos'=>implode(',',$request->productos),
            'cantidad'=>implode(',',$request->cantidad),
            'cliente_id'=>(int)$request->cliente_id,
            'user'=>auth()->user()->name,
            'status'=>'recibido',
            'serial'=>implode(',',$request->serial),
            'costo_dolar'=>$request->total_bs,
            'costo_bolivar'=>$request->total_dolar,
        ]);
        return [
            'status'=>true,
        ];
    }
    public function updaterecibo(Request $request){
        $servicio=ServicioTecnico::query()->where('id','=',(int)$request->servicio_id)->first();
        $servicio->update([
            'costo_dolar'=>$request->total_dolar,
            'costo_bolivar'=>$request->total_bs
        ]);
        $servicio->save();
        return [
            'status'=>true
        ];
    }
    public function showpdf(ServicioTecnico $servicioTecnico){
        $cliente=$servicioTecnico->cliente->nombre;
        $productos=explode(',',$servicioTecnico->productos);
        $cantidad=explode(',',$servicioTecnico->cantidad);
        $falla=explode(',',$servicioTecnico->falla);
        $serial=explode(',',$servicioTecnico->serial);


        $pdf= Pdf::loadView('servicios.recibo',[
            'servicio'=>$servicioTecnico,
            'productos'=>$productos,
            'cantidad'=>$cantidad,
            'falla'=>$falla,
            'serial'=>$serial,
        ]);
        return $pdf->stream('servicio' . $servicioTecnico->id . $cliente. '.pdf');
    }
    public function updatestatus(Request $request){
        $servicio=ServicioTecnico::query()->where('id','=',(int)$request->servicio_id)->first();
        $servicio->update([
            'status'=>'entregado',
        ]);
        $servicio->save();
        return [
            'status'=>true
        ];
    }

    private function formedit(string $view, ServicioTecnico $servicioTecnico,$vista)
    {
        $cantidad=explode(',',$servicioTecnico->cantidad);
        $productos=explode(',',$servicioTecnico->productos);
        $fallas=explode(',',$servicioTecnico->falla);
        $serial=explode(',',$servicioTecnico->serial);
       // $status=$servicioTecnico->status;
        $cont=count($productos);
        if($servicioTecnico->costo_dolar != null){
            $costo='true';
        }else{
            $costo='false';
        }


        return view($view, [
            'clientes'=>Cliente::query()->where('status','active')->orderBy('nombre')->get(),
            'servicio' => $servicioTecnico,
            'vista'=>$vista,
            'cantidad'=>json_encode($cantidad),
            'productos'=>json_encode($productos),
            'fallas'=>json_encode($fallas),
            'serial'=>json_encode($serial),
            'cont'=>$cont,
            'costo'=>$costo,

        ]);

    }
    public function update(Request $request){
        $servicio=ServicioTecnico::query()->where('id','=',(int)$request->servicio_id)->first();
        $servicio->update([
            'falla'=>implode(',',$request->falla),
            'productos'=>implode(',',$request->productos),
            'cantidad'=>implode(',',$request->cantidad),
            'cliente_id'=>(int)$request->cliente_id,
            'user'=>auth()->user()->name,
            'status'=>'recibido',
            'serial'=>implode(',',$request->serial),
            'costo_dolar'=>(float)$request->total_dolar,
            'costo_bolivar'=>(float)$request->total_bs,
        ]);
        $servicio->save();
        return [
            'status'=>true
        ];
    }
    public function delete(Request $request){
        $servicio=ServicioTecnico::query()->where('id','=',(int)$request->servicio_id)->first();
        $servicio->forceDelete();
        return [
            'status'=>true
        ];
    }
}
