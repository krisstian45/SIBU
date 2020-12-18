<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nombre'];

    public function usuarios()
    {
    	return ($this->hasMany('App\Usuario'));
    }
}

?>