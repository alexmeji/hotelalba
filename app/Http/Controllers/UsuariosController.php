<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Usuarios;
use App\CierreCaja;
use App\Abonos;
use App\Pagos;
use Exception;
use DB;
use Hash;
use Validator;
use Session;
use Auth;
use PDF;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respuesta['registros'] = Usuarios::with('tipousuario')->get()->toArray();
        $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
        $respuesta['resultado'] = true;

        return $respuesta; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            if ( $request->input('idtipousuario') && $request->input('usuario') && $request->input('password') && $request->input('nombres') ) 
            {
                DB::beginTransaction();
                $registro                   = new Usuarios();
                $registro->idtipousuario    = $request->input('idtipousuario');
                $registro->usuario          = $request->input('usuario');
                $registro->password         = Hash::make( $request->input('password', '') );
                $registro->nombres          = $request->input('nombres');
                $registro->telefono         = $request->input('telefono');
                $registro->activado         = 1;
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
        $registro = Usuarios::find($id);
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
        //
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
        try 
        {
            DB::beginTransaction();
            $registro = Usuarios::find($id);
            if ($registro) 
            {
                if ( $request->input('idtipousuario') && $request->input('idsucursal') && $request->input('usuario') && $request->input('nombres') ) 
                {
                    $registro->idtipousuario    = $request->input('idtipousuario', $registro->idtipousuario);
                    $registro->usuario          = $request->input('usuario', $registro->usuario);
                    $registro->nombres          = $request->input('nombres', $registro->nombres);
                    $registro->telefono         = $request->input('telefono', $registro->telefono);

                    if ($request->input('password')) {
                        $registro->password     = Hash::make( $request->input('password', '') ); 
                    }

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
                    $respuesta['mensaje']   = 'Te faltan campos';
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            DB::beginTransaction();
            $registro = Usuarios::find($id);
            if ($registro) 
            {
                if ($registro->delete()) 
                {
                    DB::commit();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'El registro se elimino correctamente';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    DB::rollback();
                    $respuesta['registros'] = [];
                    $respuesta['mensaje']   = 'Ocurrio un error al tratar de eliminar';
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

    public function HacerLogin(Request $request)
    {
        try
        {
            $rules = array(
                'usuario'   =>  'required',
                'password'  =>  'required|alphaNum|min:3'
            );
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails())
            {
                $respuesta['registros'] = Array();
                $respuesta['mensaje']   = 'Datos incorrectos';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
            else
            {
                Session::flush();
                $userdata = array(
                    'usuario'   =>  $request->get('usuario'),
                    'password'  =>  $request->get('password')
                );
                if(Auth::attempt($userdata,true))
                {
                    $usuario = Usuarios::find(Auth::user()->id);
                    $usuario->tipousuario;

                    $usuario->ultimoacceso = date('Y-m-d H:i:s');
                    $usuario->save();

                    Session::put('nombres', $usuario->nombres);
                    Session::put('id', $usuario->id);
                    Session::put('tipousuario', $usuario->tipousuario->nombre);
                    Session::put('idtipousuario', $usuario->idtipousuario);

                    $respuesta['registros'] = Session::all();
                    $respuesta['mensaje'] = 'Bienvenido al Sistema';
                    $respuesta['resultado'] = true;
                    return $respuesta;
                }
                else
                {
                    $respuesta['registros'] = Array();
                    $respuesta['mensaje'] = 'Usuario o Password incorrecto.';
                    $respuesta['resultado'] = false;
                    return $respuesta;
                }
            }   
        }
        catch(\Exception $e)
        {
            $respuesta['registros'] = Array();
            $respuesta['mensaje'] = 'Error general: '.$e;
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function HacerLogout()
    {
        Session::flush();
        Auth::logout();
        $respuesta['registros'] = Array();
        $respuesta['mensaje'] = 'Adios..asdfasdf.!';
        $respuesta['resultado'] = true;
        return $respuesta;
    }

    public function AperturarCaja(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $registro = new CierreCaja();
            $registro->idusuario = Session::get('id');
            $registro->fechainicio = date('Y-m-d H:i:s');
            $registro->valorinicial = $request->input('efectivo');
            $registro->cerrada = 0;
            if ($registro->save()) 
            {
                Session::put('idcierrecaja', $registro->id);

                DB::commit();
                $respuesta['registros'] = $registro->toArray();
                $respuesta['mensaje']   = 'Apertura de Caja exitosamente';
                $respuesta['resultado'] = true;
                return $respuesta;
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = Array();
                $respuesta['mensaje']   = 'No se pudo Aperturar Caja';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = Array();
            $respuesta['mensaje'] = 'Error general: '.$e;
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function CerrarCaja(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $registro = CierreCaja::find(Session::get('idcierrecaja'));
            $registro->idusuario = Session::get('id');
            $registro->fechafin = date('Y-m-d H:i:s');
            $registro->valorfinal = $request->input('efectivo');
            $registro->cerrada = 1;
            if ($registro->save()) 
            {
                Session::put('idcierrecaja', 0);

                DB::commit();
                $respuesta['registros'] = $registro->toArray();
                $respuesta['mensaje']   = 'Apertura de Caja exitosamente';
                $respuesta['resultado'] = true;
                return $respuesta;
            }
            else
            {
                DB::rollback();
                $respuesta['registros'] = Array();
                $respuesta['mensaje']   = 'No se pudo Aperturar Caja';
                $respuesta['resultado'] = false;
                return $respuesta;
            }
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            $respuesta['registros'] = Array();
            $respuesta['mensaje'] = 'Error general: '.$e;
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function ObtenerCierre()
    {
        try
        {
            if (Session::get('idcierrecaja') > 0) 
            {
                $cierreCaja = CierreCaja::find(Session::get('idcierrecaja'));

                $abonos = Abonos::where('idcierrecaja','=', Session::get('idcierrecaja'))->with('detalleCuenta')->get();
                $pagos = Pagos::where('idcierrecaja','=', Session::get('idcierrecaja'))->with('detalleCuenta')->get();

                $sumaEfectivoAbonos = Abonos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('efectivo');
                $sumaEfectivoPagos = Pagos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('efectivo');
                $sumaEfectivo = $sumaEfectivoAbonos + $sumaEfectivoPagos + $cierreCaja->valorinicial;

                $sumaTcreditoAbonos = Abonos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('tcredito');
                $sumaTcreditoPagos = Pagos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('tcredito');
                $sumaTCredito = $sumaTcreditoAbonos + $sumaTcreditoPagos;

                $sumaTdebitoAbonos = Abonos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('tdebito');
                $sumaTdebitoPagos = Pagos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('tdebito');
                $sumaTdebito = $sumaTdebitoAbonos + $sumaTdebitoPagos;

                $sumachequeAbonos = Abonos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('cheque');
                $sumachequePagos = Pagos::where('idcierrecaja', '=', Session::get('idcierrecaja'))->sum('cheque');
                $sumacheque = $sumachequeAbonos + $sumachequePagos;

                $sumaTotal = $sumaEfectivo + $sumaTCredito + $sumaTdebito + $sumacheque;




                $resumen = [
                    "efectivo" => $sumaEfectivo,
                    "tcredito" => $sumaTCredito,
                    "tdebito" => $sumaTdebito,
                    "cheque" => $sumacheque,
                    "total" => $sumaTotal
                ];

                $respuesta['abonos'] = $abonos->toArray();
                $respuesta['pagos'] = $pagos->toArray();
                $respuesta['resumen'] = $resumen;
                $respuesta['mensaje']   = 'Apertura de Caja exitosamente';
                $respuesta['resultado'] = true;
                return $respuesta;
            }
            else
            {
                $resumen = [
                    "efectivo" => 0,
                    "tcredito" => 0,
                    "tdebito" => 0,
                    "cheque" => 0,
                    "total" => 0
                ];

                $respuesta['abonos'] = [];
                $respuesta['pagos'] = [];
                $respuesta['resumen'] = $resumen;
                $respuesta['mensaje']   = 'Apertura de Caja exitosamente';
                $respuesta['resultado'] = true;
                return $respuesta;
            }
        } 
        catch (\Exception $e) 
        {
            $respuesta['registros'] = Array();
            $respuesta['mensaje'] = 'Error general: '.$e;
            $respuesta['resultado'] = false;
            return $respuesta;
        }
    }

    public function ObtenerCierrePDF(Request $request)
    {
        try
        {
            $inicio = $request->input("inicio")." 00:00:00";
            $fin = $request->input("fin")." 23:59:59";
            $pagos = Pagos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->get()->toArray();
            $sumefe = Pagos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('efectivo');
            $sumtce = Pagos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('tcredito');
            $sumtde = Pagos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('tdebito');
            $sumche = Pagos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('cheque');
            $sumnoc = Pagos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('notacredito');

            $abonos  = Abonos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->get()->toArray();
            $nsumefe = Abonos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('efectivo');
            $nsumtce = Abonos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('tcredito');
            $nsumtde = Abonos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('tdebito');
            $nsumche = Abonos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('cheque');
            $nsumnoc = Abonos::whereRaw('created_at BETWEEN ? AND ?',[ $inicio,$fin])->sum('notacredito');

            $resumen = [
                "efectivo" => $sumefe + $nsumefe,
                "tcredito" => $sumtce + $nsumtce,
                "tdebito"  => $sumtde + $nsumtde,
                "cheque"   => $sumche + $nsumche,
                "nota"     => $sumnoc + $nsumnoc
            ];

            $viewPDF = view('pdf.cierrecaja', ["pagos" => $pagos, "abonos" => $abonos, "resumen" => $resumen]);
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
