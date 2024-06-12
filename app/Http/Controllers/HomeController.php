<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Producto;
use App\Models\ServicioTecnico;
use App\Models\Sucursal;
use App\Models\Venta;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sucursales=Sucursal::query()->get();
        $nombre_sucur=[];
        $montos=[];
        $acum_sucur=[];
        $num_ventas=[];
        foreach ($sucursales as $i=>$sucursal){
            $nombre_sucur[$i]=$sucursal->nombre;
            if(count($sucursal->ventas) != 0){
                foreach ($sucursal->ventas as $x=>$venta){
                    $num_ventas[$i]=$x + 1;
                    $montos[$i][$x]=round($venta->total_dolar,2);
                }
                $acum_sucur[$i]=array_sum($montos[$i]);
            }else{
                $montos[$i]=0;
                $acum_sucur[$i]=0;
                $num_ventas[$i]=0;
            }
        }
        $acum_total=array_sum($acum_sucur);

        //DELIVERIS
        $deliveris=Delivery::query()->get();
        foreach ($deliveris as $i=>$deliveri){
            $pendientes=$deliveri->where('status','pendiente')->get();
            $proceso=$deliveri->where('status','proceso')->get();
            $entregadas=$deliveri->where('status','entregado')->get();
        }
        //SERVICIO TECNICO
        $servicios=ServicioTecnico::query()->get();
        foreach ($servicios as $i=>$servicio) {
            $pendie = $servicio->where('status', 'recibido')->get();
            $entregados = $servicio->where('status', 'entregado')->get();

        }
        //Productos
        $productos=Producto::query()->where('cantidad','<=',5)->get();

        return view('home',[
            'nombre_sucur'=>$nombre_sucur,
            'acum_sucur'=>$acum_sucur,
            'acum_total'=>$acum_total,
            'num_ventas'=>$num_ventas,
            'sucursales'=>$sucursales,
            //DELIVERI
            'pendientes'=>count($pendientes),
            'proceso'=>count($proceso),
            'entregadas'=>count($entregadas),
            //SERVICIO TECNICO
            'pendi'=>count($pendie),
            'entregado'=>count($entregados),
            //PRODUCTOS
            'productos'=>$productos,
        ]);
    }
}
