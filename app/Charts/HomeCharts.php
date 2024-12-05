<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class HomeCharts
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build_deliveris($pendientes,$proceso,$entregadas): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        return $this->chart->donutChart()
            ->setTitle('Deliveris')
            ->setSubtitle('Estatus')
            ->setLabels(['Pendientes','En Proceso','Entregadas'])
            ->addPieces([$pendientes,$proceso,$entregadas])
            ->setColors(['#FF0000','#FFF000','#008000'])
            ->setHeight(200)
            ;
    }
    public function build_servicio($pendientes,$entregadas): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        return $this->chart->donutChart()
            ->setTitle('Servicios Técnicos')
            ->setSubtitle('Estatus')
            ->addPieces([$pendientes,$entregadas])
            ->setColors(['#FF0000','#008000'])
            ->setLabels(['Pendientes','Entregadas'])
            ->setHeight(200);
    }
    public function build_ventas($nombre_sucur,$acum_sucur): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $nom=[];
        $acum=[];
        foreach ($nombre_sucur as $i=>$nombre){
            $nom[]=$nombre;
            $acum[]=$acum_sucur[$i];
        }
        //dd($nombre_sucur);
        $var= $this->chart->pieChart()
                ->setTitle('Ventas por Sucursal')
                ->setSubtitle('Acumulado ($)')
                ->setLabels($nom)
                ->setHeight(250)
                ->addPieces($acum)
                ->setColors([ '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                    '#0077B5', '#ff6384', '#c9cbcf', '#0057ff', '00a9f4', '#2ccdc9', '#5e72e4'])
                ->setDataLabels();

        return $var;
    /*    return $this->chart->barChart()
            ->setTitle('Servicio Tecnico')
            ->setSubtitle('Estatus')
            ->setXAxis([$nom])
            ->addBar('Sucur 1',[$acum[0]])
            ->setColors(['#FF0000','#008000'])
            ->setHeight(200);*/
    }
    public function build_productos($producto,$categorias,$devoluciones){

        if($producto != null){


        $nombres=array_keys($producto);
        $cantidad=array_values($producto);
        //dd($categorias);
        $aux_nom=[];
        foreach ($nombres as $i=>$nom){
            $aux_nom[]=strtoupper($categorias[$nom].'-'.$nom);
        }
        //dd($aux_nom);
        foreach ($devoluciones as $dev){
            if($dev=== null){
                $num[]=0;
            }else{
                $num[]=$dev;
            }
        }
        $var= $this->chart->barChart()
            ->setTitle('Productos Bajo Stock')
            ->setSubtitle('Bajo Stock vs Devoluciones')
            ->setXAxis($aux_nom)
            ->setHeight(250)
            ->addBar('Cantidad disponible',$cantidad)
            ->addBar('Devoluciones',$num)
            ->setColors([ '#feb019', '#ff455f', '#775dd0', '#80effe',
                '#0077B5', '#ff6384', '#c9cbcf', '#0057ff', '00a9f4', '#2ccdc9', '#5e72e4'])
            ->setDataLabels();

        return $var;
        }

    }

}
