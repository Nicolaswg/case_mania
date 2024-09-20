<?php

namespace App\Http\Controllers;

use App\Charts\HomeCharts;
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
    public function index(HomeCharts $charts)
    {
        $sucursales=Sucursal::query()->get();
        $nombre_sucur=[];
        $montos=[];
        $acum_sucur=[];
        $num_ventas=[];
        $devo=[];
        foreach ($sucursales as $i=>$sucursal){
            $nombre_sucur[$i]=$sucursal->nombre;
            if(count($sucursal->ventas) != 0){
                foreach ($sucursal->ventas as $x=>$venta){
                    if($venta->status != 'devuelto'){
                        $num_ventas[$i]=$x + 1;
                        $montos[$i][$x]=round($venta->subtotal_dolar,2);
                    }
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
        if(count($deliveris)!= 0){
            foreach ($deliveris as $i=>$deliveri){
                $pendientes=$deliveri->where('status','pendiente')->get();
                $proceso=$deliveri->where('status','proceso')->get();
                $entregadas=$deliveri->where('status','entregado')->get();
            }
        }else{
            $pendientes=[];
            $proceso=[];
            $entregadas=[];
        }

        //SERVICIO TECNICO

        $servicios=ServicioTecnico::query()->get();
        if(count($servicios)!= 0) {
            foreach ($servicios as $i => $servicio) {
                $pendie = $servicio->where('status', 'recibido')->get();
                $entregados = $servicio->where('status', 'entregado')->get();

            }
        }else{
            $pendie=[];
            $entregados=[];
        }

        //Productos
        $productos=Producto::query()->where('cantidad','<=',10)->orderBy('nombre')->get();
        $canti=[];
        $nombre_su=[];
        $nombre_producto=[];
        $array=[];
        $categorias=[];
        $tot_devoluciones=[];
        foreach ($productos as $x=>$producto){
            $nombre_producto[$x]=$producto->nombre;
            foreach ($sucursales as $i=>$sucursal){
                $nombre_su[$i]=$sucursal->nombre;
                if(count($producto->almacen) != 0){
                    $produc=$sucursal->almacen()->where('sucursal_id',$sucursal->id )->where('producto_id',$producto->id)->orderBy('created_at')->first();
                    if($produc != null){
                        $canti[$x][$i]=$produc->cantidad_acumulada;
                    }else{
                        $prod=$sucursal->productos->where('sucursal_id',$sucursal->id)->where('id',$producto->id)->first();
                        $canti[$x][$i]=$prod->cantidad;
                    }
                }else{
                    $prod=$sucursal->productos->where('sucursal_id',$sucursal->id)->where('id',$producto->id)->first();
                    if($prod != null){
                        $canti[$x][$i]=$prod->cantidad;
                    }else{
                        $canti[$x][$i]=0;
                    }
                }

            }
            $tot_devoluciones[$producto->nombre]=$producto->cantidad_devueltos;
            $tot_produc=array_sum($canti[$x]);
            $array[$producto->nombre]=$tot_produc;
            $categorias[$producto->nombre]=$producto->categoria->nombre;

        }
       // dd($tot_devoluciones);


        return view('home',[
            //VENTAS
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
            'productos'=>$array,
            'categorias'=>$categorias,
            'devoluciones'=>$tot_devoluciones,
            //GRAFICOS
            'chart'=>$charts->build_deliveris(count($pendientes),count($proceso),count($entregadas)),
            'chart1'=>$charts->build_servicio(count($pendie),count($entregados)),
            'chart_ventas'=>$charts->build_ventas($nombre_sucur,$acum_sucur),
            'chart_productos'=>$charts->build_productos($array,$categorias,$tot_devoluciones),

        ]);
    }
}
