<?php

namespace App\Http\Controllers;

use App\Configuracion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ConfiguracionRequest;
use App\Http\Controllers\Controller;
use Flash;

class Configuracion_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = Configuracion::all()->first();
        return (view('configuracion')->with('config', $config));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConfiguracionRequest $request, $id)
    {
        $config = Configuracion::find($id);
        $config->fill($request->all());
        $config->save();
        Flash::success('Configuración modificada con éxito!');
        return (redirect()->route('configuracion'));
    }
}

?>