<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Producto;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;

class Menu_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (view('menu.listadoMenuBuffet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($dia)
    {
        if($dia == "hoy") {
            $fecha = (new DateTime())->format('Y-m-d');
        }
        else {
            if($dia == "mañana") {
                $hoy = (new DateTime());
                $hoy->add(new DateInterval('P1D'));
                $fecha = date_format($hoy, 'Y-m-d');
            }
            else {
                return(redirect()->route('menu'));
            }
        }
        $menu = Menu::obtenerMenu($fecha);
        $productos = Producto::obtenerProductosConStock();
        if(!empty($menu)) {
            $menuArray = array();
            foreach($menu as $prodMenu) {
                array_push($menuArray, $prodMenu->producto_id);
            }
            foreach($productos as &$producto) {
                $producto->menu = NULL;
                if(in_array($producto->id, $menuArray))
                    $producto->menu = "Esta en el menu de " . $fecha;
            }
        }
        return (view('menu.crearMenuBuffet')->with('productos', $productos)->with('fecha', $fecha));
    }

    public function route(Request $request)
    {
        $verificar = $this->verificarId(json_decode($request->id)); // retorna true si esta en la BD ,false caso contrario
        $id = $request->id;
        if($verificar) { // existe el producto puedo operar con el
            $fecha = $request->fecha;
            $menu = $menu = Menu::obtenerMenu($fecha);
            if($menu) { // hay menus para ese dia debo verificar que ese producto no este en menu
                $result = Menu::obtenerProductoMenu($id, $fecha);
                if(!$result) { // no esta el producto en el menu debo agregarlo
                    $agregar = Menu::agregarProducto($id, $fecha);
                }
                else { // el producto esta en el menu debo eliminarlo
                    $eliminar = Menu::eliminarProducto($id, $fecha);
                }
            }
            else { // no hay  menus para ese dia  debo agregar el producto
                $agregar = Menu::agregarProducto($id, $fecha);
            }
        }
    }

    public function verificarId($id)
    {
        $producto = Producto::find($id);
        if(empty($producto)) { // no existe el producto quieren meter otra cosa que no existe
            return (false);
        }
        else { // existe el producto en la bd
            return (true);
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
