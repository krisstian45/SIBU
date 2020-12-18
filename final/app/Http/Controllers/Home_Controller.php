<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Menu;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;

class Home_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontend()
    {
        $config = Configuracion::all()->first();
        $hoy = (new DateTime())->format('Y-m-d');
        $menu = Menu::obtenerMenu($hoy);
        if($config->habilitado)
            return (view('frontend')->with('config', $config)->with('menu', $menu));
        else
            return (view('sitioDeshabilitado')->with('config', $config));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function backend()
    {
        $hoy = (new DateTime())->format('Y-m-d');
        $menu = Menu::obtenerMenu($hoy);
        return (view('backend')->with('menu', $menu));
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

?>