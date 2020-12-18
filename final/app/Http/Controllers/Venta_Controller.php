<?php

namespace App\Http\Controllers;

use App\Venta;
use App\Configuracion;
use App\Producto;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\VentaRequest;
use App\Http\Controllers\Controller;
use Session;
use Flash;
use Exception;

class Venta_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Venta::obtenerVentas();
        $config = Configuracion::all()->first();
        return (view('venta.listadoVentas')->with('ventas', $ventas)->with('config', $config));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datos['productos'] = Producto::obtenerProductos();
        if(Session::has('productosVenta')) {
            $datos['productosVenta'] = Session::get('productosVenta');
            $datos['total'] = Session::get('total');
        }
        return (view('venta.crearVenta')->with('datos', $datos));
    }

    public function agregarProductoAVenta(Request $request)
    {
        $idProducto = $request->id;
        $cantidad = $request->cantidad;
        $producto = Producto::find($idProducto);
        if($producto) { // Esto es porque en el input hidden del producto a vender puede poner cualquier cosa
            if(!Session::has('total'))
                Session::set('total', 0);
            if(($producto->stock - intval($cantidad)) >= intval($producto->stock_minimo)) { // Si el producto pedido tiene stock
                if(!Session::has('productosVenta')) {
                    $subtotal = (floatval($producto->precio_venta_unitario) * intval($cantidad));
                    // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                    $producto->cantidad = $cantidad;
                    $producto->subtotal = $subtotal;
                    $productosVenta = array();
                    $productosVenta[$idProducto] = $producto;
                    Session::set('productosVenta', $productosVenta);
                    Session::set('total', Session::get('total') + $subtotal);
                }
                // Caso en el que ya existan productos en la venta
                else {
                    $subtotal = (floatval($producto['precio_venta_unitario']) * intval($cantidad));
                    // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                    $producto->cantidad = $cantidad;
                    $producto->subtotal = $subtotal;
                    $productosVenta = Session::get('productosVenta');
                    $productosVenta[$idProducto] = $producto;
                    Session::set('productosVenta', $productosVenta);
                    Session::set('total', Session::get('total') + $subtotal);
                }
            }
            else
                Flash::warning('No hay stock de este producto');
        }
        return (redirect()->route('ventas.vista-crear'));
    }

    public function quitarProductoDeVenta($idProducto) {
        if(Session::has('productosVenta')) {
            if(array_key_exists($idProducto, Session::get('productosVenta'))) { // Preguntamos si el producto a borrar está en el arreglo de productos de la venta
                $subtotal = Session::get('productosVenta')[$idProducto]->subtotal;
                Session::set('total', Session::get('total') - $subtotal);
                // Elimina un producto del arreglo de ventas que esta en la sesion, se pasa la posicion del arreglo donde se encuentra el producto eliminar. Los indices estan dados por los id de los productos agregados a la venta
                $productosVenta = Session::get('productosVenta');
                array_forget($productosVenta, $idProducto);
                Session::set('productosVenta', $productosVenta);
            }
        }
        return (redirect()->route('ventas.vista-crear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VentaRequest $request)
    {
        if(Session::has('productosVenta')) {
            Venta::generarVenta(Session::get('productosVenta'));
            Session::forget('productosVenta');
            Session::forget('total');
            Flash::success('Venta realizada con éxito!');
            return (redirect()->route('ventas.vista-crear'));;
        }
        else {
            return (redirect()->route('ventas.vista-crear'));;
        }
    }

    public function cancelar() {
        Session::forget('productosVenta');
        Session::forget('total');
        return (redirect()->route('ventas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta_detalle = Venta::obtenerDetallesDeVenta($id);
        $config = Configuracion::all()->first();
        return (view('venta.detalleVenta')->with('venta_detalle', $venta_detalle)->with('config', $config));
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
    public function update(VentaRequest $request, $id)
    {
        //
    }

    public function viewDestroy($id) {
        $venta = Venta::find($id);
        return (view('venta.eliminarVenta')->with('venta', $venta));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Venta::eliminar($id);
        Flash::success('Compra eliminada con éxito!');
        return (redirect()->route('ventas'));
    }
}

?>