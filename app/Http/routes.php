<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () 
{
    return view('login');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () 
{
    Route::get('/panel', function()
    {
    	if (Session::get('id')) 
    	{
    		return view('layouts.panel');	
    	}
		else
		{
			return redirect('');
		}
	});

	Route::group(['prefix' => 'layouts'], function()
	{
		Route::get('dashboard', function(){ return view('layouts.dashboard'); });
		Route::get('usuarios', function(){ return view('layouts.usuarios'); });
		Route::get('clientes', function(){ return view('layouts.clientes'); });
		Route::get('cargos', function(){ return view('layouts.cargos'); });
		Route::get('tipohabitacion', function(){ return view('layouts.tipohabitacion'); });
		Route::get('correlativos', function(){ return view('layouts.correlativos'); });
		Route::get('habitaciones', function(){ return view('layouts.habitaciones'); });
		Route::get('tarifas', function(){ return view('layouts.tarifas'); });
		Route::get('reservas', function(){ return view('layouts.reservas'); });
		Route::get('crearreservas', function(){ return view('layouts.crearreservas'); });
		Route::get('reservasanuladas', function(){ return view('layouts.reservasanuladas'); });
		Route::get('cierrecaja', function(){ return view('layouts.cierrecaja'); });
		Route::get('reportes', function(){ return view('layouts.reportes'); });
	});

	Route::group(['prefix' => 'ws'], function()
	{
		//PDF
		Route::get('usuarios/caja/vercierre/pdf', 'UsuariosController@ObtenerCierrePDF');
		Route::get('habitaciones/reporte/pdf', 'HabitacionesController@ReporteHabitaciones');

		Route::get('clienteselect', 'ClientesController@indexSelect');
		Route::get('reservas/anular/{id}', 'ReservasController@anularReservacion');
		Route::get('reservas/checkin/{id}', 'ReservasController@checkInReservacion');
		Route::get('reservas/checkout/{id}', 'ReservasController@checkOutReservacion');
		Route::get('reservas/calentario/todas', 'ReservasController@indexCalendario');
		Route::get('reservas/ver/anuladas', 'ReservasController@reservasAnuladas');
		Route::get('reservas/cuenta/ver/{id}', 'ReservasController@cuentaReservacion');
		Route::get('reservas/cuenta/abonar', 'ReservasController@realizarAbono');
		Route::get('reservas/cuenta/pagar', 'ReservasController@realizarPago');
		Route::post('reservas/cuenta/cargo', 'ReservasController@agregarCargo');
		Route::delete('reservas/cargos/eliminar/{id}', 'ReservasController@eliminarCargo');
		Route::any('habitacionesdisponibles', 'HabitacionesController@indexDisponibles');
		Route::get('habitaciones/estado/limpieza/{pasarLimpieza}', 'HabitacionesController@pasarLimpieza');
		Route::get('usuarios/caja/aperturar', 'UsuariosController@AperturarCaja');
		Route::get('usuarios/caja/cerrar', 'UsuariosController@CerrarCaja');
		Route::get('usuarios/caja/vercierre', 'UsuariosController@ObtenerCierre');
		Route::get('login', 'UsuariosController@HacerLogin');
		Route::get('logout', 'UsuariosController@HacerLogout');

		//RESOURCE
		Route::resource('tipousuarios', 'TipoUsuariosController');
		Route::resource('tipodocumentos', 'TipoDocumentosController');
		Route::resource('formaspago', 'FormasPagoController');
		Route::resource('tarifas', 'TarifasController');
		Route::resource('paises', 'PaisesController');
		Route::resource('departamentos', 'DepartamentosController');
		Route::resource('municipios', 'MunicipiosController');
		Route::resource('usuarios', 'UsuariosController');
		Route::resource('clientes', 'ClientesController');
		Route::resource('cargos', 'CargosController');
		Route::resource('tipohabitacion', 'TipoHabitacionController');
		Route::resource('correlativos', 'CorrelativosController');
		Route::resource('habitaciones', 'HabitacionesController');
		Route::resource('reservas', 'ReservasController');
	});
});
