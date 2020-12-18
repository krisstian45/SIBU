<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompraRequest extends Request
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
            'cantidad'      =>  'numeric|min:0|max:50',
            'proveedor'     =>  'string|min:2|max:20|required',
            'cuit'          =>  'numeric|min:10000000000|max:99999999999|required'
        ];
    }
}

?>