<?php 
use App\TipoHabitacion;
 ?>

<link rel="stylesheet" type="text/css" href="css/plugins.css">
<link rel="stylesheet" type="text/css" href="css/selectize.css" />
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
<script src="js/icheck.js"></script>

<div class="container-fluid">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-7">
                <div class="page-breadcrumb-wrap">

                    <div class="page-breadcrumb-info">
                        <h2 class="breadcrumb-titles">Habitaciones <small>Administración de Habitaciones</small></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix">
                        <span class="h-icon"><i class="fa fa-table"></i></span>
                        <h4>Lista Habitaciones</h4>
                        <ul class="widget-action-bar pull-right">
                            <li><span class="waves-effect w-reload"><i class="fa fa-spinner"></i></span></li>
                            @if(Session::get('idtipousuario') == 1)
                                <li><span class="widget-remove waves-effect w-remove w-add"><i class="fa fa-plus-square-o"></i></span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <table id="tabla-registros" class="table mb30">
                                <thead>
                                    <th>#</th>
                                    <th>Numero</th>
                                    <th># Camas</th>
                                    <th>Tipo Habitación</th>
                                    <th>TV</th>
                                    <th>A/C</th>
                                    <th>Caja Fuerte</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR -->
<div class="modal fade" id="modal-crear">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cloase"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Habitación</h4>
            </div>
            <form id="form-crear">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Numero <span class="asterisk">*</span> </label>
                                <input type="text" name="numero" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Tipo Habitación <span class="asterisk">*</span></label>
                                 <select id="select-crear" name="idtipohabitacion" placeholder="Elige un Tipo de Habitación">
                                    <option></option>
                                    @foreach (TipoHabitacion::all() as $registro) 
                                        <option value="{{$registro->id}}">{{$registro->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Num. Camas</label>
                                <input type="text" name="numcamas" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Torre</label>
                                <input type="text" name="torre" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nivel</label>
                                <input type="text" name="nivel" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="icheck-input">
                                <input class="i-min-check" type="checkbox" name="television" id="television">
                                <label for="television">Televisión</label>
                            </div>
                            <div class="icheck-input">
                                <input class="i-min-check" type="checkbox" name="ac" id="ac">
                                <label for="ac">A/C</label>
                            </div>
                            <div class="icheck-input">
                                <input class="i-min-check" type="checkbox" name="cajafuerte" id="cajafuerte">
                                <label for="cajafuerte">Caja Fuerte</label>
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

<!-- MODAL EDTAR -->
<div class="modal fade" id="modal-editar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cloase"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Habitación</h4>
            </div>
            <form id="form-editar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Numero <span class="asterisk">*</span> </label>
                                <input type="text" id="numero" name="numero" class="form-control" required />
                                <input type="hidden" id="idactualizar">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Tipo Habitación <span class="asterisk">*</span></label>
                                 <select id="select-editar" name="idtipohabitacion" placeholder="Elige un Tipo de Habitación">
                                    <option></option>
                                    @foreach (TipoHabitacion::all() as $registro) 
                                        <option value="{{$registro->id}}">{{$registro->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Num. Camas</label>
                                <input type="text" id="numcamas" name="numcamas" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Torre</label>
                                <input type="text" id="torre" name="torre" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nivel</label>
                                <input type="text" id="nivel" name="nivel" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="icheck-input">
                                <input class="i-min-check" type="checkbox" name="television" id="television">
                                <label for="television">Televisión</label>
                            </div>
                            <div class="icheck-input">
                                <input class="i-min-check" type="checkbox" name="ac" id="ac">
                                <label for="ac">A/C</label>
                            </div>
                            <div class="icheck-input">
                                <input class="i-min-check" type="checkbox" name="cajafuerte" id="cajafuerte">
                                <label for="cajafuerte">Caja Fuerte</label>
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

<script type="text/javascript" src="js/habitaciones.js"></script>