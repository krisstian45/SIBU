<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Producto;
use App\Estadistica;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;

class Listado_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productosFaltantes()
    {
        $config = Configuracion::all()->first();
        $productosFaltantes = Producto::obtenerProductosFaltantes();
        return (view('listado.productosFaltantes')->with('config', $config)->with('productosFaltantes', $productosFaltantes));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productosStockMinimo()
    {
        $config = Configuracion::all()->first();
        $productosStockMinimo = Producto::obtenerProductosStockMinimo();
        return (view('listado.productosStockMinimo')->with('config', $config)->with('productosStockMinimo', $productosStockMinimo));
    }

    public function balanceGanancias($mensaje = '')
    {
        return (view('listado.balanceGanancias')->with('mensaje', $mensaje));
    }

    public function balanceVentas($mensaje = '')
    {
        return (view('listado.balanceVentas')->with('mensaje', $mensaje));
    }

    public function calcularBalanceGanancias(Request $request)
    {
        $fechaInicio = (new DateTime($request->fechaInicio))->format("Y-m-d 00:00:00");
        $fechaFin = (new DateTime($request->fechaFin))->format("Y-m-d 23:59:59");
        if(($fechaInicio <= $fechaFin) && (($fechaFin - $fechaInicio) <= 1)) {
            $config = Configuracion::all()->first();
            $ganancias = Estadistica::obtenerGanancias($fechaInicio, $fechaFin);
            return (view('listado.listadoBalanceGanancias')->with('config', $config)->with('ganancias', $ganancias)->with('fechaInicio', date('d-m-Y', strtotime($fechaInicio)))->with('fechaFin', date('d-m-Y', strtotime($fechaFin))));
        }
        else {
            $mensaje = "Debe ingresar una fecha correcta, entre un rango de un año, y la primera debe ser menor o igual a la segunda";
            return($this->balanceGanancias($mensaje));
        }
    }

    public function calcularBalanceVentas(Request $request)
    {
        $fechaInicio = (new DateTime($request->fechaInicio))->format("Y-m-d 00:00:00");
        $fechaFin = (new DateTime($request->fechaFin))->format("Y-m-d 23:59:59");
        if(($fechaInicio <= $fechaFin) && (($fechaFin - $fechaInicio) <= 1)) {
            $config = Configuracion::all()->first();
            $ventas = Estadistica::obtenerCantidadDeVentasPorProducto($fechaInicio, $fechaFin);
            return (view('listado.listadoBalanceVentas')->with('config', $config)->with('ventas', $ventas)->with('fechaInicio', date('d-m-Y', strtotime($fechaInicio)))->with('fechaFin', date('d-m-Y', strtotime($fechaFin))));
        }
        else {
            $mensaje = "Debe ingresar una fecha correcta, entre un rango de un año, y la primera debe ser menor o igual a la segunda";
            return($this->balanceVentas($mensaje));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
