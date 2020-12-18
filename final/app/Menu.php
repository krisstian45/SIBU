<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['fecha', 'producto_id'];

    public function producto()
    {
    	return ($this->belongsTo('App\Producto'));
    }

    public static function obtenerMenu($hoy) {
    	return (
            DB::table('menus')
            ->join('productos', 'menus.producto_id', '=', 'productos.id')
            ->where('fecha', '=', $hoy)
            ->get()
        );
    }

    public static function obtenerProductoMenu($id, $fecha) {
        $arrayData[0] = $id;
        $arrayData[1] = $fecha;
        return (DB::select("
                    SELECT * FROM menus WHERE producto_id = ? and fecha = ?
                ", $arrayData));
    }

    public static function agregarProducto($id, $fecha) {
        $arrayData[0] = $fecha;
        $arrayData[1] = $id;
        return (DB::insert("
                    INSERT INTO menus (fecha, producto_id) VALUES (?, ?)
                ", $arrayData));
    }

    public static function eliminarProducto($id, $fecha) {
        $arrayData[0] = $fecha;
        $arrayData[1] = $id;
        return (DB::delete("
                    DELETE FROM menus WHERE fecha = ? and producto_id = ?
                ", $arrayData));
    }
}

?>