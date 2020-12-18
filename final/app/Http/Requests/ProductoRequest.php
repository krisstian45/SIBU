<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductoRequest extends Request
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
            'nombre'                =>  'string|min:2|max:20|required',
            'marca'                 =>  'string|min:2|max:20|required',
            'codigo_barra'          =>  'numeric|min:1000000000|max:9999999999|required',
            'stock'                 =>  'numeric|min:0',
            'stock_minimo'          =>  'numeric|min:0|required',
            'categoria_id'          =>  'required',
            'proveedor'             =>  'string|min:2|max:20|required',
            'precio_venta_unitario' =>  'numeric|min:0|required',
            'descripcion'           =>  'string|max:255|required'
        ];
    }
}

?>