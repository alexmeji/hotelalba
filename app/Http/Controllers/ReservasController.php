<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Reservas;
use App\Cuenta;
use App\Cargos;
use App\DetalleCuenta;
use App\Habitaciones;
use App\Tarifas;
use App\TipoHabitacion;
use App\Pagos;
use App\Abonos;
use App\Correlativos;
use Exception;
use DB;
use Session;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fechaActual = date('Y-m-d H:i:s');
        $respuesta['registros'] = Reservas::with('habitacion', 'cliente', 'usuario', 'usuarioanulo')->whereRaw('salida > ? AND anulada != 1 AND checkout = "0000-00-00 00:00:00"', [$fechaActual])->get()->toArray();
        //$respuesta['registros'] = Reservas::with('habitacion', 'cliente', 'usuario', 'usuarioanulo')->get()->toArray();
        $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
        $respuesta['resultado'] = true;
        $respuesta['fecha'] = $fechaActual;

        return $respuesta; 
    }

    public function indexCalendario()
    {
        $respuesta['registros'] = Reservas::with('habitacion', 'cliente', 'usuario')->where('anulada', '!=', 1)->get()->toArray();
        $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
        $respuesta['resultado'] = true;

        return $respuesta; 
    }

    public function reservasAnuladas()
    {
        $respuesta['registros'] = Reservas::with('habitacion', 'cliente', 'usuario','usuarioanulo')->where('anulada', '=', 1)->get()->toArray();
        $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
        $respuesta['resultado'] = true;

        return $respuesta; 
    }

    public function anularReservacion($id)
    {
        try 
        {
            DB::beginTransaction();
            $registro = Reservas::find($id);
            if ($registro) 
            {
                $registro->anulada = 1;
                $registro->usuarioanulo = Session::get('id');
                if ($registro->save()) 
                {
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'La Reservacion se anulo correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de anular';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function cuentaReservacion($id)
    {
        try 
        {
            $registro = Cuenta::where('idreserva', '=', $id)->first();
            if ($registro) 
            {
                $respuesta['registros'] = DetalleCuenta::where('idcuenta', '=',$registro->id)->get()->toArray();
                $respuesta['mensaje']   = 'Detalle Cuenta Habitacion consultado exitosamente';
                $respuesta['resultado'] = true;
                return $respuesta;
            }
            else
            {
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e)
        {
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function checkOutReservacion($id)
    {
        try 
        {
            DB::beginTransaction();
            $registro = Reservas::find($id);
            if ($registro) 
            {
                $registro->checkout =  \Carbon\Carbon::now();
                if ($registro->save()) 
                {

                    $habitacion = Habitaciones::find($registro->idhabitacion);
                    $habitacion->limpieza = 1;
                    $habitacion->save();
                    
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Se Realizo el Check In correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de hacer Check In';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function checkInReservacion($id)
    {
        try 
        {
            DB::beginTransaction();
            $registro = Reservas::find($id);
            if ($registro) 
            {
                $registro->checkin =  \Carbon\Carbon::now();
                if ($registro->save()) 
                {
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Se Realizo el Check In correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de hacer Check In';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function realizarAbono(Request $request)
    {
        try 
        {
            DB::beginTransaction();
            $registro = Cuenta::find($request->input('idcuenta'));
            if ($registro) 
            {
                $detallecuenta = DetalleCuenta::whereRaw('idcuenta = ? AND pagado = 0', [$registro->id])->get()->lists('id');
                $totalAbono = $request->input('efectivo') + $request->input('tcredito') + $request->input('tdebito') + $request->input('cheque'); 
                foreach ($detallecuenta as $detalleId) 
                {
                    if ($totalAbono == 0) 
                    {
                        break;
                    }
                    else
                    {
                        $detalle = DetalleCuenta::find($detalleId);

                        if ($totalAbono >= $detalle->debe) 
                        {
                            $detalle->debe = 0;
                            $detalle->pagado = 1;
                            $totalAbono = $totalAbono - $detalle->costo;    
                        }
                        else if($totalAbono <= $detalle->debe)
                        {
                            $detalle->debe = $detalle->debe - $totalAbono;
                            $totalAbono = 0;
                        }

                        $detalle->save();
                    }
                }

                $correlativo = Correlativos::find(2);

                $abono = new Abonos();
                $abono->idcuenta = $registro->id;
                $abono->efectivo = $request->input('efectivo');
                $abono->tcredito = $request->input('tcredito');
                $abono->tdebito = $request->input('tdebito');
                $abono->cheque = $request->input('cheque');
                $abono->numcheque = $request->input('numcheque');
                $abono->documento = $correlativo->numero;
                if ($abono->save())
                {
                    $correlativo->numero = $correlativo->numero + 1;
                    $correlativo->save();
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Se Realizo el Abono correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de hacer el Abono';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function realizarPago(Request $request)
    {
        try 
        {
            DB::beginTransaction();
            $registro = Cuenta::find($request->input('idcuenta'));
            if ($registro) 
            {
                $detallecuenta = DetalleCuenta::whereRaw('idcuenta = ? AND pagado = 0', [$registro->id])->get()->lists('id');
                $totalAbono = $request->input('efectivo') + $request->input('tcredito') + $request->input('tdebito') + $request->input('cheque'); 
                foreach ($detallecuenta as $detalleId) 
                {
                    if ($totalAbono == 0) 
                    {
                        break;
                    }
                    else
                    {
                        $detalle = DetalleCuenta::find($detalleId);

                        if ($totalAbono >= $detalle->debe) 
                        {
                            $detalle->debe = 0;
                            $detalle->pagado = 1;
                            $totalAbono = $totalAbono - $detalle->costo;    
                        }
                        else if($totalAbono <= $detalle->debe)
                        {
                            $detalle->debe = $detalle->debe - $totalAbono;
                            $totalAbono = 0;
                        }

                        $detalle->save();
                    }
                }

                $correlativo = Correlativos::find(1);

                $pago = new Pagos();
                $pago->idcuenta = $registro->id;
                $pago->efectivo = $request->input('efectivo');
                $pago->tcredito = $request->input('tcredito');
                $pago->tdebito = $request->input('tdebito');
                $pago->cheque = $request->input('cheque');
                $pago->numcheque = $request->input('numcheque');
                $pago->documento = $correlativo->numero;
                if ($pago->save())
                {
                    $correlativo->numero = $correlativo->numero + 1;
                    $correlativo->save();
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Se Realizo el Pago correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de hacer el Abono';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function agregarCargo(Request $request)
    {
        try 
        {
            DB::beginTransaction();
            
            $cargo = Cargos::find($request->input("idcargo"));
            if ($cargo) 
            {
                $detalleCuenta = new DetalleCuenta();
                $detalleCuenta->idcuenta = $request->input("idcuenta");
                $detalleCuenta->cargo = $cargo->nombre;
                $detalleCuenta->descripcion = $cargo->nombre." ( ".$request->input("cantidad")." ) * ".$request->input("precio");
                $detalleCuenta->cantidad = $request->input("cantidad");
                $detalleCuenta->costo = $request->input('total');
                $detalleCuenta->debe = $request->input('total');
                
                if ($detalleCuenta->save()) 
                {
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Se Agrego el Cargo correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar agregar el Cargo';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'No existe el Cargo';
                $respuesta['resultado'] = false;
            }
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function eliminarCargo($id)
    {
        try 
        {
            $registro = DetalleCuenta::find($id);
            if ($registro->delete()) 
            {
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'Cargo Eliminado';
                $respuesta['resultado'] = true;
                return $respuesta;
            }
            else
            {
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e)
        {
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try 
        {
            if ( $request->input('idcliente') && $request->input('idtarifa') && $request->input('adultos') && $request->input('habitaciones') && $request->input('entrada') && $request->input('salida') ) 
            {
                DB::beginTransaction();
                $habitacionesArray = json_decode($request->input('habitaciones'));

                foreach ($habitacionesArray as $value) 
                {
                    $registro = new Reservas();
                    $registro->idcliente = $request->input('idcliente');
                    $registro->idusuario = Session::get('id');
                    $registro->idhabitacion = $value;
                    $registro->idtarifa = $request->input('idtarifa');
                    $registro->adultos = $request->input('adultos');
                    $registro->ninos = $request->input('ninos');
                    $registro->entrada = $request->input('entrada');
                    $registro->salida = $request->input('salida');
                    $registro->save();

                    $cuenta = new Cuenta();
                    $cuenta->idreserva = $registro->id;
                    $cuenta->idcliente = $registro->idcliente;
                    $cuenta->save();

                    $habitacion = Habitaciones::find($value);
                    $tipohabitacion = TipoHabitacion::find($habitacion->idtipohabitacion);
                    $tarifa = Tarifas::find($registro->idtarifa);

                    $detalleCuenta = new DetalleCuenta();
                    $detalleCuenta->idcuenta = $cuenta->id;
                    $detalleCuenta->cargo = "Habitacion";
                    $detalleCuenta->descripcion = "Num: ".$habitacion->numero." ( ".$tipohabitacion->nombre." ) ".$request->input('dias')." dias";
                    $detalleCuenta->cantidad = 1;
                    $detalleCuenta->costo = $request->input('dias') * $tarifa->precio;
                    $detalleCuenta->debe = $request->input('dias') * $tarifa->precio;
                    $detalleCuenta->save();
                }
                
                DB::commit();
                $respuesta['registros'] = $registro->toArray();
                $respuesta['mensaje']   = 'Registro Creado Exitosamente';
                $respuesta['resultado'] = true;
                return $respuesta;
            }
            else
            {
                $respuesta['registros'] = $request->all();
                $respuesta['mensaje']   = 'Te faltan campos';
                $respuesta['resultado'] = false;
                return $respuesta;
            }    
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registro = Reservas::find($id);
        if ($registro) 
        {
            $respuesta['registros'] = $registro->toArray();
            $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
            $respuesta['resultado'] = true;
        }
        else
        {
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = 'No existe el registro';
            $respuesta['resultado'] = false;
        }

        return $respuesta; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try 
        {
            $registro = Reservas::find($id);
            if ($registro) 
            {
                DB::beginTransaction();
                $registro->numero = $request->input('numero', $registro->numero);
                $registro->nivel = $request->input('nivel', $registro->nivel);
                $registro->torre = $request->input('torre', $registro->torre);
                $registro->numcamas = $request->input('numcamas', $registro->numcamas);
                $registro->costo = $request->input('costo', $registro->costo);
                $registro->idtipohabitacion = $request->input('idtipohabitacion', $registro->idtipohabitacion);
                $registro->television = ( $request->has('television') ? 1 : 0);
                $registro->ac = ( $request->has('ac') ? 1 : 0);
                $registro->cajafuerte = ( $request->has('cajafuerte') ? 1 : 0);

                if ($registro->save()) 
                {
                    DB::commit();
                    $respuesta['registros'] = $registro->toArray();
                    $respuesta['mensaje']   = 'Registro Actualizado Exitosamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al registrar';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'No existe el registro';
                $respuesta['resultado'] = false;
                return $respuesta;
            }    
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try 
        {
            $registro = Reservas::find($id);
            if ($registro) 
            {
                if ($registro->delete()) 
                {
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'El registro se elimino correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de eliminar';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }
            else
            {
                $respuesta['registros'] = [];
                $respuesta['mensaje']   = 'El registro no existe';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (Exception $e) 
        {
            $respuesta['registros'] = [];
            $respuesta['mensaje']   = $e->getMessage();
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }
}
