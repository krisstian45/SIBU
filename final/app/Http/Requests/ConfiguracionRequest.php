<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConfiguracionRequest extends Request
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
            'titulo'                =>  'string|min:2|max:50|required',
            'descripcion'           =>  'string|min:2|max:255|required',
            'email'                 =>  'string|min:2|max:30|required',
            'elementos'             =>  'numeric|min:0|max:9999999|required',
            'habilitado'            =>  'required',
            'mensaje'               =>  'string|min:2|max:255|required'
        ];
    }
}

?>