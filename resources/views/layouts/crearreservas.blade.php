<?php 
use App\TipoDocumentos;
use App\Clientes;
use App\Tarijas;
 ?>

<link rel="stylesheet" type="text/css" href="css/plugins.css">
<link rel="stylesheet" type="text/css" href="css/selectize.css" />
<link rel="stylesheet" type="text/css" href="css/switchery.css" />
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/jquery.dataTables.js"></script>
<script src="js/jquery.loadmask.js"></script>
<script src="js/dataTables.responsive.js"></script>
<script src="js/dataTables.tableTools.js"></script>
<script src="js/dataTables.bootstrap.js"></script>
<script src="js/stacktable.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="js/switchery.js"></script>
<script src="js/jquery.nouislider.js"></script>
<script src="js/bootbox.js"></script>
<script src="js/sweetalert.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/selectize.js"></script>

<div class="container-fluid">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-7">
                <div class="page-breadcrumb-wrap">

                    <div class="page-breadcrumb-info">
                        <h2 class="breadcrumb-titles">Reservaciones <small>Creación de Reservaciones</small></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
            </div>
        </div>
        <div class="row" id="crear-reserva">
            <div class="col-md-12">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix">
                        <span class="h-icon"><i class="fa fa-table"></i></span>
                        <h4>Datos Reservacion</h4>
                        <ul class="widget-action-bar pull-right">
                            <li><span class="widget-remove waves-effect w-remove w-add-c"><i class="fa fa-user-plus"></i></span></li>
                            <li><span class="widget-remove waves-effect w-remove w-add"><i class="fa fa-plus-square-o"></i></span></li>
                        </ul>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <form id="form-crear-reserva">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Cliente <span class="asterisk">*</span></label>
                                             <select id="select-cliente-c" name="idcliente" placeholder="Selecciona un Cliente">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Entrada</label>
                                            <input type="text" id="entrada" name="entrada" class="form-control input-date-picker" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Salida</label>
                                            <input type="text" id="salida" name="salida" class="form-control input-date-picker-fin" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-success btn-block btn-guardar"> Guardar</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Tarifa <span class="asterisk">*</span></label>
                                             <select id="select-tarifa-c" name="idtarifa" placeholder="Selecciona una Tarifa">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Adultos</label>
                                            <input type="number" id="adultos" name="adultos" class="form-control " />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Niños</label>
                                            <input type="number" id="ninos" name="ninos" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Dias</label>
                                            <input type="number" id="dias" name="dias" class="form-control " readonly="true" />
                                        </div>
                                    </div>
                                    <div class="col-sm-5"></div>
                                </div>
                                <div class="row">
                                    <table id="tabla-reservaciones" class="table mb30">
                                        <thead>
                                            <th>#</th>
                                            <th>Numero</th>
                                            <th>Torre</th>
                                            <th>Nivel</th>
                                            <th>Tipo</th>
                                            <th>Precio</th>
                                            <th>Costo</th>
                                            <th>Acciones</th>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        <tfoot>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th id="total">Total: Q.0.00</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- MODAL CREAR CLIENTE -->
<div class="modal fade" id="modal-crear">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cloase"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Cliente</h4>
            </div>
            <form id="form-crear-cliente">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nombres <span class="asterisk">*</span> </label>
                                <input type="text" name="nombres" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Telefono</label>
                                <input type="text" name="telefono" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" name="email" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Razón Social </label>
                                <input type="text" name="razonsocial" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nit</label>
                                <input type="text" name="nit" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Tipo Documento <span class="asterisk">*</span></label>
                                 <select id="select-crear" name="idtipodocumento" placeholder="Elige un Tipo de Documento">
                                    <option></option>
                                    @foreach (TipoDocumentos::all() as $registro) 
                                        <option value="{{$registro->id}}">{{$registro->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"># Documento</label>
                                <input type="text" name="numerodocumento" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Direccion</label>
                                <input type="text" name="direccion" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Empresa</label>
                                <input type="text" name="empresa" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Fecha Nacimiento</label>
                                <input type="text" name="fechanacimiento" class="form-control input-date-picker" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Sexo <span class="asterisk">*</span></label>
                                 <select id="selects-crear" name="sexo" placeholder="Elige un Sexo">
                                    <option></option>
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL HABITACIONES -->
<div class="modal fade" id="modal-habitaciones">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cloase"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista Habitaciones</h4>
            </div>
            <form id="form-crear-cliente">
                <div class="modal-body">
                    <table id="tabla-habitaciones" class="table mb30">
                        <thead>
                            <th>#</th>
                            <th>Numero</th>
                            <th>Nivel</th>
                            <th>Torre</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/crearreservas.js"></script>