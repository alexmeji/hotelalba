<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuenta';

    public function cliente()
    {
        return $this->hasOne('App\Clientes','id','idcliente');
    }
}
