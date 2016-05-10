<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleCuenta extends Model
{
	use SoftDeletes;
    protected $table = 'detallecuenta';

    public function cuenta()
    {
        return $this->hasOne('App\Cuenta','id','idcuenta')->with('cliente');
    }

    public function abonos()
	{
		return $this->hasMany('App\Abonos', 'iddetallecuenta');	
	}

	public function pagos()
	{
		return $this->hasMany('App\Pagos', 'iddetallecuenta');	
	}
}
