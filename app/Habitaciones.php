<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitaciones extends Model
{
	protected $table = "habitaciones";

	public function tipohabitacion()
    {
        return $this->hasOne('App\TipoHabitacion','id','idtipohabitacion');
    }
}
