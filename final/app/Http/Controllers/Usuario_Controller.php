<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Configuracion;
use App\Rol;
use App\Ubicacion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UsuarioRequest;
use App\Http\Controllers\Controller;
use Flash;

class Usuario_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::all();
        $config = Configuracion::all()->first();
        return (view('usuario.listadoUsuarios')->with('usuarios', $usuarios)->with('config', $config));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = Rol::all();
        $ubicaciones = Ubicacion::all();
        return (view('usuario.crearUsuario')->with('request', $request)->with('roles', $roles)->with('ubicaciones', $ubicaciones));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        $usuario = new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->password = bcrypt($request->password);
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->tipoDocumento = $request->tipoDocumento;
        $usuario->numeroDocumento = $request->numeroDocumento;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->rol_id = $request->rol;
        $usuario->ubicacion_id = $request->ubicacion;
        $usuario->habilitado = $request->habilitado;
        $usuario->save();
        Flash::success('Usuario creado con éxito!');
        return (redirect()->route('usuarios'));
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
        $usuario = Usuario::find($id);
        $roles = Rol::all();
        $ubicaciones = Ubicacion::all();
        //dd($usuario->rol->nombre);
        return (view('usuario.modificarUsuario')->with('usuario', $usuario)->with('roles', $roles)->with('ubicaciones', $ubicaciones));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $id)
    {
        $usuario = Usuario::find($id);
        $usuario->usuario = $request->usuario;
        $usuario->password = bcrypt($request->password);
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->tipoDocumento = $request->tipoDocumento;
        $usuario->numeroDocumento = $request->numeroDocumento;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->rol_id = $request->rol;
        $usuario->ubicacion_id = $request->ubicacion;
        $usuario->habilitado = $request->habilitado;
        $usuario->save();
        Flash::success('Usuario modificado con éxito!');
        return (redirect()->route('usuarios'));
    }

    public function viewDestroy($id) {
        $usuario = Usuario::find($id);
        return (view('usuario.eliminarUsuario')->with('usuario', $usuario));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();
        Flash::success('Usuario eliminado con éxito');
        return (redirect()->route('usuarios'));
    }
}

?>