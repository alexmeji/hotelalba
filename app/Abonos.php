<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abonos extends Model
{
    protected $table = 'abonos';

    public function detalleCuenta()
    {
        return $this->hasOne('App\DetalleCuenta','id','iddetallecuenta')->with('cuenta');
    }
}
