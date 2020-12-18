<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Configuracion;
use App\Menu;
use App\Producto;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CrearPedidoRequest;
use App\Http\Requests\ModificarPedidoRequest;
use App\Http\Controllers\Controller;
use Session;
use Flash;
use DateTime;

class Pedido_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCliente(Request $request) {
        $config = Configuracion::all()->first();
        $pedidos = Pedido::obtenerPedidosUsuario(Auth::user()->id);
        $hoy = (new DateTime())->format('d-m-Y H:i:s');
        foreach ($pedidos as &$pedido) { // Se agrega un & para entrar por referencia al valor del array y poder modificarlo
            if(date('Y-m-d', strtotime($pedido->created_at)) == date('Y-m-d', strtotime($hoy)) && (round(abs(strtotime($hoy) - strtotime($pedido->created_at)) / 60,2) <= 30) && $pedido->estado == "Pendiente")
                $pedido->cancelable = 'Si';
            else
                $pedido->cancelable = 'No';
        }
        if(!isset($request->fechaFiltro)) {
            $fechaFiltro = NULL;
            return (view('pedido.listadoPedidosCliente')->with('config', $config)->with('pedidos', $pedidos)->with('fechaFiltro', $fechaFiltro));
        }
        else {
            $fechaFiltro = (new DateTime($request->fechaFiltro))->format("d-m-Y") ;
            $filtrado = array();
            foreach($pedidos as $pedido) {
                $fechaPedido = (new DateTime($pedido->created_at))->format("d-m-Y");
                if($fechaPedido == $fechaFiltro)
                    array_push($filtrado, $pedido);
            }
            return (view('pedido.listadoPedidosCliente')->with('config', $config)->with('pedidos', $filtrado)->with('fechaFiltro', $fechaFiltro));
        }
    }

    public function indexAdministrativo(Request $request)
    {
        $config = Configuracion::all()->first();
        $pedidos = Pedido::obtenerPedidos();
        if(!isset($request->fechaFiltro)) {
            $fechaFiltro = NULL;
            return (view('pedido.listadoPedidosAdministrativo')->with('config', $config)->with('pedidos', $pedidos)->with('fechaFiltro', $fechaFiltro));
        }
        else {
            $fechaFiltro = (new DateTime($request->fechaFiltro))->format("d-m-Y") ;
            $filtrado = array();
            foreach($pedidos as $pedido) {
                $fechaPedido = (new DateTime($pedido->created_at))->format("d-m-Y");
                if($fechaPedido == $fechaFiltro)
                    array_push($filtrado, $pedido);
            }
            return (view('pedido.listadoPedidosAdministrativo')->with('config', $config)->with('pedidos', $filtrado)->with('fechaFiltro', $fechaFiltro));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCliente()
    {
        $hoy = (new DateTime())->format('Y-m-d H:i:s');
        $datos['menu'] = Menu::obtenerMenu($hoy);
        $datos['productos'] = Producto::obtenerProductosConStock();
        if(Session::has('productosPedido')) {
            $datos['productosPedido'] = Session::get('productosPedido');
            $datos['total'] = Session::get('total');
        }
        return (view('pedido.crearPedido')->with('datos', $datos));
    }

    public function agregarProductoAPedido(Request $request)
    {
        $idProducto = $request->id;
        $cantidad = $request->cantidad;
        $producto = Producto::find($idProducto);
        if($producto) { // Esto es porque en el input hidden del producto a comprar puede poner cualquier cosa
            if(!Session::has('total'))
                Session::set('total', 0);
            if(($producto->stock - intval($cantidad)) >= intval($producto->stock_minimo)) { // Si el producto pedido tiene stock
                if(!Session::has('productosPedido')) {
                    $subtotal = (floatval($producto->precio_venta_unitario) * intval($cantidad));
                    // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                    $producto->cantidad = $cantidad;
                    $producto->subtotal = $subtotal;
                    $pedidos = array();
                    $productosPedido[$idProducto] = $producto;
                    Session::set('productosPedido', $productosPedido);
                    Session::set('total', Session::get('total') + $subtotal);
                }
                // Caso en el que ya existan productos en la compra
                else {
                    $subtotal = (floatval($producto['precio_venta_unitario']) * intval($cantidad));
                    // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                    $producto->cantidad = $cantidad;
                    $producto->subtotal = $subtotal;
                    $productosPedido = Session::get('productosPedido');
                    $productosPedido[$idProducto] = $producto;
                    Session::set('productosPedido', $productosPedido);
                    Session::set('total', Session::get('total') + $subtotal);
                }
            }
            else
                Flash::warning('No hay stock de este producto');
        }
        return (redirect()->route('pedidos-cliente.vista-crear'));
    }

    public function quitarProductoDePedido($idProducto) {
        if(Session::has('productosPedido')) {
            if(array_key_exists($idProducto, Session::get('productosPedido'))) { // Preguntamos si el producto a borrar está en el arreglo de productos del pedido
                $subtotal = Session::get('productosPedido')[$idProducto]->subtotal;
                Session::set('total', Session::get('total') - $subtotal);
                // Elimina un producto del arreglo de pedidos que esta en la sesion, se pasa la posicion del arreglo donde se encuentra el producto eliminar. Los indices estan dados por los id de los productos agregados al pedido
                $productosPedido = Session::get('productosPedido');
                array_forget($productosPedido, $idProducto);
                Session::set('productosPedido', $productosPedido);
            }
        }
        return (redirect()->route('pedidos-cliente.vista-crear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearPedidoRequest $request)
    {
        if(Session::has('productosPedido')) {
            Pedido::generarPedido(Session::get('productosPedido'));
            Session::forget('productosPedido');
            Session::forget('total');
            Flash::success('Pedido realizado con éxito!');
            return (redirect()->route('pedidos-cliente.vista-crear'));;
        }
        else {
            return (redirect()->route('pedidos-cliente.vista-crear'));;
        }
    }

    public function cancelar() {
        Session::forget('productosPedido');
        Session::forget('total');
        return (redirect()->route('pedidos-cliente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido_detalle = Pedido::obtenerDetallesDePedido($id);
        $config = Configuracion::all()->first();
        return (view('pedido.detallePedido')->with('pedido_detalle', $pedido_detalle)->with('config', $config));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedido = Pedido::find($id);
        if(!empty($pedido) && $pedido->estado == "Pendiente") {
            return (view('pedido.modificarPedido')->with('pedido', $pedido));
        }
        else {
            Flash::error('El pedido ya fué procesado');
            return (redirect()->route('pedidos-administrativo'));
        }
    }

    public function aceptarPedido($id) {
        $pedido  = Pedido::find($id);
        if(!empty($pedido) && $pedido->estado == "Pendiente") {
            Pedido::aceptarPedido($id);
            Flash::success('Operación exitosa!');
        }
        else {
            Flash::error('El pedido no existe o ya fue procesado');
        }
        return (redirect()->route('pedidos-administrativo'));
    }

    public function rechazarPedido(ModificarPedidoRequest $request, $id) {
        $pedido  = Pedido::find($id);
        if(!empty($pedido) && $pedido->estado == "Pendiente") {
            if(isset($request->observacion) && !empty($request->observacion)) {
                Pedido::rechazarPedido($id, $request->observacion);
                Flash::success('Operación exitosa!');

            }
        }
        else {
            Flash::error('El pedido no existe o ya fue procesado');
        }
        return (redirect()->route('pedidos-administrativo'));
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
        $pedido = Pedido::find($id);
        $hoy = (new DateTime())->format('d-m-Y H:i:s');
        $fechaPedido = date("d-m-Y H:i:s", strtotime($pedido->created_at));
        if(date('Y-m-d', strtotime($fechaPedido)) == date('Y-m-d', strtotime($hoy)) && (round(abs(strtotime($hoy) - strtotime($fechaPedido)) / 60,2) <= 30) && $pedido->estado == "Pendiente") {
            $pedido->eliminar($id);
            Flash::success('Pedido eliminado con éxito!');
        }
        return (redirect()->route('pedidos-cliente'));
    }
}

?>