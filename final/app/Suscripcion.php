<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    protected $table = 'suscripciones';
    protected $fillable = ['chat_id', 'nombre'];

    public static function crearSuscripcion($value)
    {
        $suscripcion[0] = $value["message"]["chat"]["id"];
        $suscripcion[1] = $value['message']['from']['first_name'];
        $usuario = array_values($suscripcion);
        return (DB::insert("
                    INSERT INTO suscripciones (chat_id, nombre) VALUES (?, ?)
                ", $usuario));
    }

    public static function eliminarSuscripcion($value)
    {
        $chat_id[0] = $value["message"]["chat"]["id"];
        return (DB::delete("
                    DELETE FROM suscripciones WHERE chat_id = ?
                ", $chat_id));
    }
}

?>