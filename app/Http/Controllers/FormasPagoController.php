<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FormasPago;
use Exception;
use DB;

class FormasPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $respuesta['registros'] = FormasPago::all()->toArray();
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
            if ($request->input('nombre')) 
            {
                DB::beginTransaction();
                $registro = new FormasPago();
                $registro->nombre = $request->input('nombre');
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
        $registro = FormasPago::find($id);
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
            $registro = FormasPago::find($id);
            if ($registro) 
            {
                DB::beginTransaction();
                $registro->nombre = $request->input('nombre', $registro->nombre);
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
            $registro = FormasPago::find($id);
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
