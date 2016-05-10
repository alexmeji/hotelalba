<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Habitaciones;
use App\Reservas;
use App\Pagos;
use App\Abonos;
use Exception;
use DB;
use PDF;

class HabitacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $respuesta['registros'] = Habitaciones::with('tipohabitacion')->get()->toArray();
        $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
        $respuesta['resultado'] = true;

        return $respuesta; 
    }

    public function indexDisponibles(Request $request)
    {
        $habitacionesOcupadas = Reservas::whereRaw('anulada = 0 AND checkout = "0000-00-00 00:00:00" AND ((? BETWEEN entrada AND salida) OR (? BETWEEN entrada AND salida))', [$request->input('entrada').' 15:00:00', $request->input('salida').' 13:00:00'])->lists('idhabitacion');
        $respuesta['registros'] = Habitaciones::with('tipohabitacion')->whereNotIn('numero', json_decode($request->input('habitaciones')))->whereNotIn('id', $habitacionesOcupadas)->get()->toArray();
        $respuesta['ocupadas'] = Habitaciones::with('tipohabitacion')->whereIn('id', $habitacionesOcupadas)->get()->toArray();
        $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
        $respuesta['resultado'] = true;
        return $respuesta; 
    }

    public function pasarLimpieza($id)
    {
        try 
        {
            DB::beginTransaction();
            $registro = Habitaciones::find($id);
            if ($registro) 
            {
                $registro->limpieza = 0;
                if ($registro->save()) 
                {
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'La Habitacion paso a Lista';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de pasar a Lista';
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
            if ( $request->input('numero') && $request->input('numcamas') && $request->input('idtipohabitacion')) 
            {
                DB::beginTransaction();
                $registro = new Habitaciones();
                $registro->numero = $request->input('numero');
                $registro->nivel = $request->input('nivel');
                $registro->torre = $request->input('torre');
                $registro->numcamas = $request->input('numcamas');
                $registro->television = ( $request->has('television') ? 1 : 0);
                $registro->ac = ( $request->has('ac') ? 1 : 0);
                $registro->cajafuerte = ( $request->has('cajafuerte') ? 1 : 0);
                $registro->idtipohabitacion = $request->input('idtipohabitacion');

                if ($registro->save()) 
                {
                    DB::commit();
                    $respuesta['registros'] = $registro->toArray();
                    $respuesta['mensaje']   = 'Registro Creado Exitosamente';
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
        $registro = Habitaciones::find($id);
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
            $registro = Habitaciones::find($id);
            if ($registro) 
            {
                DB::beginTransaction();
                $registro->numero = $request->input('numero', $registro->numero);
                $registro->nivel = $request->input('nivel', $registro->nivel);
                $registro->torre = $request->input('torre', $registro->torre);
                $registro->numcamas = $request->input('numcamas', $registro->numcamas);
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
            $registro = Habitaciones::find($id);
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

    public function ReporteHabitaciones(Request $request)
    {
        try
        {
            $inicio = $request->input("inicio")." 00:00:00";
            $fin = $request->input("fin")." 23:59:59";
            $tipo = $request->input("tipo");

            $reservacionessalen = Reservas::whereRaw(' (salida BETWEEN ? AND ?) ', [$inicio, $fin])->with('habitacion','cliente')->get();
            $reservacionesentran = Reservas::whereRaw(' (entrada BETWEEN ? AND ?) ', [$inicio, $fin])->with('habitacion','cliente')->get();
            $reservacionesestan = Reservas::whereRaw('((? BETWEEN entrada AND salida) AND (? BETWEEN entrada AND salida)) AND checkin != "0000-00-00 00:00:00"', [$inicio, $fin])->with('habitacion','cliente')->get();

            $datos = [
                "salen" => $reservacionessalen,
                "entran" => $reservacionesentran,
                "estan" => $reservacionesestan
            ];

            $viewPDF = view('pdf.habitaciones', ["salen" => $reservacionessalen, "entran" => $reservacionesentran, "estan" => $reservacionesestan, "tipo" => $tipo]);
            $pdf = PDF::loadHTML($viewPDF);
            return $pdf->stream();

        } 
        catch (\Exception $e) 
        {
            $respuesta['registros'] = Array();
            $respuesta['mensaje'] = 'Error general: '.$e;
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }
}
