<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UsuarioRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'usuario'          =>  'string|min:5|max:20|required',
            'password'         =>  'min:6|max:20|required',
            'password2'        =>  'min:6|max:20|same:password',
            'rol'              =>  'required',
            'habilitado'       =>  'required',
            'nombre'           =>  'alpha|min:2|max:30|required',
            'apellido'         =>  'alpha|min:2|max:30|required',
            'email'            =>  'string|min:4|max:250|required|unique:usuarios',
            'tipoDocumento'    =>  'string|required',
            'numeroDocumento'  =>  'numeric|min:10000000|max:99999999|required',
            'telefono'         =>  'string|min:6|max:20|required',
            'ubicacion'        =>  'required'
        ];
    }
}

?>