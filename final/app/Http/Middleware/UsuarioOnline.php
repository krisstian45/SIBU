<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;
use Auth;
use Session;

class UsuarioOnline
{
    protected $auth;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            if($this->auth->user()->rol->nombre != "Usuario Online") {
                return (redirect()->to('backend'));
            }
            return $next($request);
        }
        else {
                return (redirect()->to('login'));
        }
    }
}

?>