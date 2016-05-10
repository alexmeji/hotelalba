<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $table = 'pagos';

    public function detalleCuenta()
    {
        return $this->hasOne('App\DetalleCuenta','id','iddetallecuenta')->with('cuenta');
    }
}
