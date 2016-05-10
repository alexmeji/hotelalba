<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Clientes;
use Exception;
use DB;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respuesta['registros'] = Clientes::all()->toArray();
        $respuesta['mensaje']   = 'Registros Obtenidos Correctamente';
        $respuesta['resultado'] = true; 
        return $respuesta;
    }

    public function indexSelect()
    {
        $respuesta['registros'] = Clientes::select(DB::raw("CONCAT(nombres ,' ', apellidos) AS nombres, id"))->get();
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
            if ( $request->input('nombres') && $request->input('apellidos') && $request->input('razonsocial') && $request->input('idtipodocumento') && $request->input('numerodocumento') && $request->input('nit') ) 
            {
                DB::beginTransaction();
                $registro                   = new Clientes();
                $registro->nombres          = $request->input('nombres');
                $registro->apellidos        = $request->input('apellidos');
                $registro->razonsocial      = $request->input('razonsocial');
                $registro->nit              = $request->input('nit');
                $registro->direccion        = $request->input('direccion');
                $registro->telefono         = $request->input('telefono');
                $registro->email            = $request->input('email');
                $registro->empresa          = $request->input('empresa');
                $registro->sexo             = $request->input('sexo');
                $registro->fechanacimiento  = $request->input('fechanacimiento');
                $registro->idtipodocumento  = $request->input('idtipodocumento');
                $registro->numerodocumento  = $request->input('numerodocumento');

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
        $registro = Clientes::find($id);
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
            $registro = Clientes::find($id);
            if ($registro) 
            {
                if ( $request->input('nombres') && $request->input('apellidos') && $request->input('razonsocial') && $request->input('idtipodocumento') && $request->input('numerodocumento') && $request->input('nit') ) 
                {
                    $registro->nombres          = $request->input('nombres', $registro->nombres);
                    $registro->apellidos        = $request->input('apellidos', $registro->apellidos);
                    $registro->telefono         = $request->input('telefono', $registro->telefono);
                    $registro->email            = $request->input('email', $registro->email);
                    $registro->razonsocial      = $request->input('razonsocial', $registro->razonsocial);
                    $registro->nit              = $request->input('nit', $registro->nit);
                    $registro->direccion        = $request->input('direccion', $registro->direccion);
                    $registro->idtipodocumento  = $request->input('idtipodocumento', $registro->idtipodocumento);
                    $registro->numerodocumento  = $request->input('numerodocumento', $registro->numerodocumento);
                    $registro->empresa          = $request->input('empresa', $registro->empresa);
                    $registro->sexo             = $request->input('sexo', $registro->sexo);
                    $registro->fechanacimiento  = $request->input('fechanacimiento', $registro->fechanacimiento);
                    if ($registro->save()) 
                    {
                        DB::commit();
                        $respuesta['registros'] = $registro->toArray();
                        $respuesta['mensaje']   = 'Registro actualizado correctamente';
                        $respuesta['resultado'] = true;
                        return $respuesta;
                    }
                    else
                    {
                        DB::rollback();
                        $respuesta['registros'] = [];
                        $respuesta['mensaje']   = 'Ocurrio un error al tratar de actualizar';
                        $respuesta['resultado'] = false;
                        return $respuesta;
                    }
                }
                else
                {
                    DB::rollback();
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
        try 
        {
            DB::beginTransaction();
            $registro = Clientes::find($id);
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
}
