<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
	protected $table = "reservas";

	public function habitacion()
    {
        return $this->hasOne('App\Habitaciones','id','idhabitacion')->with('tipohabitacion');
    }

    public function cliente()
    {
        return $this->hasOne('App\Clientes','id','idcliente');
    }

    public function usuario()
    {
        return $this->hasOne('App\Usuarios','id','idusuario');
    }

    public function usuarioanulo()
    {
        return $this->hasOne('App\Usuarios','id','usuarioanulo');
    }
}
