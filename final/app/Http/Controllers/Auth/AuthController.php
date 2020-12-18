<?php

namespace App\Http\Controllers\Auth;

use App\Usuario;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    // El valor asignado debe ser la url de una ruta, no la ruta de una vista

    // El proposito de $redirectPath es definir una url a donde redireccionar si el usuario se loguea correctamente
    protected $redirectPath = 'backend';
    // El proposito de $loginPath es definir una url a donde redireccionar para intentos fallidos de inicio de sesion
    protected $loginPath = 'login';
    // El proposito de $redirectAfterLogout es definir una url a donde redireccionar cuando el usuario cierra sesion
    protected $redirectAfterLogout = '/';
    // Campo por el cual se compara en la base de datos para efectuar el login (El input del form debe llamarse igual que el valor de $username)
    protected $username = 'usuario';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|max:255',
            'email' => 'required|email|max:255|unique:usuarios',
            'password' => 'required|min:6|max:20',
            'password2' => 'min:6|max:20|same:password'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Usuario::create([
            'usuario' => $data['usuario'],
            'password' => bcrypt($data['password']),
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'tipoDocumento' => $data['tipoDocumento'],
            'numeroDocumento' => $data['numeroDocumento'],
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'rol_id' => $data['rol_id'],
            'ubicacion_id' => $data['ubicacion'],
            'habilitado' => 'habilitado',
        ]);
    }
}

?>