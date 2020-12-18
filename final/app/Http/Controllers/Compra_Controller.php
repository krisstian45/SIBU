<?php

namespace App\Http\Controllers;

use App\Compra;
use App\Configuracion;
use App\Producto;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CompraRequest;
use App\Http\Controllers\Controller;
use Session;
use Flash;
use Exception;
use DateTime;

class Compra_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras = Compra::all();
        $config = Configuracion::all()->first();
        return (view('compra.listadoCompras')->with('compras', $compras)->with('config', $config));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $error = '')
    {
        $datos['productos'] = Producto::obtenerProductos();
        if(Session::has('productosCompra')) {
            $datos['productosCompra'] = Session::get('productosCompra');
            $datos['total'] = Session::get('total');
        }
        return (view('compra.crearCompra')->with('datos', $datos)->with('request', $request)->with('error', $error));
    }

    public function agregarProductoACompra(Request $request)
    {
        $idProducto = $request->id;
        $cantidad = $request->cantidad;
        $producto = Producto::find($idProducto);
        if($producto) { // Esto es porque en el input hidden del producto a comprar puede poner cualquier cosa
            if(!Session::has('total'))
                Session::set('total', 0);
            if(!Session::has('productosCompra')) {
                $subtotal = (floatval($producto->precio_venta_unitario) * intval($cantidad));
                // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                $producto->cantidad = $cantidad;
                $producto->subtotal = $subtotal;
                $productosCompra = array();
                $productosCompra[$idProducto] = $producto;
                Session::set('productosCompra', $productosCompra);
                Session::set('total', Session::get('total') + $subtotal);
            }
            // Caso en el que ya existan productos en la compra
            else {
                $subtotal = (floatval($producto['precio_venta_unitario']) * intval($cantidad));
                // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                $producto->cantidad = $cantidad;
                $producto->subtotal = $subtotal;
                $productosCompra = Session::get('productosCompra');
                $productosCompra[$idProducto] = $producto;
                Session::set('productosCompra', $productosCompra);
                Session::set('total', Session::get('total') + $subtotal);
            }
        }
        return (redirect()->route('compras.vista-crear'));
    }

    public function quitarProductoDeCompra($idProducto) {
        if(Session::has('productosCompra')) {
            if(array_key_exists($idProducto, Session::get('productosCompra'))) { // Preguntamos si el producto a borrar está en el arreglo de productos de la compra
                $subtotal = Session::get('productosCompra')[$idProducto]->subtotal;
                Session::set('total', Session::get('total') - $subtotal);
                // Elimina un producto del arreglo de compras que esta en la sesion, se pasa la posicion del arreglo donde se encuentra el producto eliminar. Los indices estan dados por los id de los productos agregados a la compra
                $productosCompra = Session::get('productosCompra');
                array_forget($productosCompra, $idProducto);
                Session::set('productosCompra', $productosCompra);
            }
        }
        return (redirect()->route('compras.vista-crear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompraRequest $request)
    {
        try {
            if(Session::has('productosCompra')) {
                $error = '';
                $nombreFactura = $this->subirFactura($error);
                $datos = [
                'productosCompra' => Session::get('productosCompra'),
                'proveedor' => $request->proveedor,
                'proveedor_cuit' => $request->cuit,
                'nombreFactura' => $nombreFactura
                ];
                Compra::generarCompra($datos);
                Session::forget('productosCompra');
                Session::forget('total');
                Flash::success('Compra realizada con éxito!');
                return (redirect()->route('compras.vista-crear'));;
            }
            else {
                return (redirect()->route('compras.vista-crear'));
            }
        }
        catch(Exception $e) {
            $error = $e->getMessage();
            return($this->create($request, $error));
        }
    }

    public function subirFactura($error)
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["factura"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        // Esto es para chequear la extension
        if(file_exists($target_file))
            throw new Exception("Esta factura ya fue subida");
        if($_FILES["factura"]["size"] > 2000000)
            throw new Exception("El archivo que intenta subir no puede superar los 2MB");
        // Solo permitimos imagenes o pdf
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "pdf")
            throw new Exception("El archivo debe estar en formato imagen o PDF");
        if(!move_uploaded_file($_FILES["factura"]["tmp_name"], $target_file)) // Aca la sube y si hubo un error, tira excepcion
            throw new Exception("Hubo un problema al cargar el archivo. Asegurse que el archivo no supere los 2MB");
        else
            return $_FILES["factura"]["name"];
    }

    public function cancelar() {
        Session::forget('productosCompra');
        Session::forget('total');
        return (redirect()->route('compras'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $compra_detalle = Compra::obtenerDetallesDeCompra($id);
        $config = Configuracion::all()->first();
        return (view('compra.detalleCompra')->with('compra_detalle', $compra_detalle)->with('config', $config));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $compra = Compra::find($id);
        return (view('compra.modificarCompra')->with('compra', $compra));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompraRequest $request, $id)
    {
        $compra = Compra::find($id);
        $compra->proveedor = $request->proveedor;
        $compra->proveedor_cuit = $request->cuit;
        $compra->save();
        Flash::success('Compra modificada con éxito!');
        return (redirect()->route('compras'));
    }

    public function viewDestroy($id) {
        $compra = Compra::find($id);
        return (view('compra.eliminarCompra')->with('compra', $compra));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Compra::eliminar($id);
        Flash::success('Compra eliminada con éxito!');
        return (redirect()->route('compras'));
    }
}

?>