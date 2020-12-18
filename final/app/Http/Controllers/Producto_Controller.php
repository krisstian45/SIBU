<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Configuracion;
use App\Categoria;
use App\Venta_Detalle;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ProductoRequest;
use App\Http\Controllers\Controller;
use Flash;
use DateTime;

class Producto_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::obtenerProductos();
        $config = Configuracion::all()->first();
        return (view('producto.listadoProductos')->with('productos', $productos)->with('config', $config));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return (view('producto.crearProducto')->with('categorias', $categorias));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoRequest $request)
    {
        $producto = new Producto();
        $producto->nombre_producto = $request->nombre;
        $producto->marca = $request->marca;
        $producto->codigo_barra = $request->codigo_barra;
        if($request->stock)
            $producto->stock = $request->stock;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->fecha_alta = new DateTime();
        $producto->proveedor = $request->proveedor;
        $producto->proveedor = $request->proveedor;
        $producto->precio_venta_unitario = $request->precio_venta_unitario;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();
        Flash::success('Producto creado con éxito!');
        return (redirect()->route('productos'));
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
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        return (view('producto.modificarProducto')->with('producto', $producto)->with('categorias', $categorias));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductoRequest $request, $id)
    {
        $producto = Producto::find($id);
        $producto->nombre_producto = $request->nombre;
        $producto->marca = $request->marca;
        $producto->codigo_barra = $request->codigo_barra;
        if($request->stock)
            $producto->stock = $request->stock;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->fecha_alta = new DateTime();
        $producto->proveedor = $request->proveedor;
        $producto->proveedor = $request->proveedor;
        $producto->precio_venta_unitario = $request->precio_venta_unitario;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();
        Flash::warning('Producto modificado con éxito!');
        return (redirect()->route('productos'));
    }

    public function viewDestroy($id) {
        $producto = Producto::find($id);
        if($producto) {
            $ventas_detalle = Venta_Detalle::where('producto_id', '=', $id)->get();
            if(count($ventas_detalle) > 0) {
                $datos['existeProducto'] = true;
                $datos['existenVentas'] = true;
            }
            else {
                $datos['producto'] = $producto;
                $datos['existeProducto'] = true;
                $datos['existenVentas'] = false;
            }
        }
        else {
            $datos['existeProducto'] = false;
            $datos['existenVentas'] = false;
        }
        return (view('producto.eliminarProducto')->with('datos', $datos));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        $producto->delete();
        Flash::error('Producto eliminado con éxito!');
        return (redirect()->route('productos'));
    }
}

?>