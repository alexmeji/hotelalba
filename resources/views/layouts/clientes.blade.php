<?php 
use App\TipoDocumentos;
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

<div class="container-fluid">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-7">
                <div class="page-breadcrumb-wrap">

                    <div class="page-breadcrumb-info">
                        <h2 class="breadcrumb-titles">Clientes <small>Administración de Clientes</small></h2>
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
                        <h4>Lista Clientes</h4>
                        <ul class="widget-action-bar pull-right">
                            <li><span class="waves-effect w-reload"><i class="fa fa-spinner"></i></span></li>
                            <li><span class="widget-remove waves-effect w-remove w-add"><i class="fa fa-plus-square-o"></i></span></li>
                        </ul>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <table id="tabla-registros" class="table mb30">
                                <thead>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Nit</th>
                                    <th>Sexo</th>
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
                <h4 class="modal-title">Crear Cliente</h4>
            </div>
            <form id="form-crear">
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

<!-- MODAL EDTAR -->
<div class="modal fade" id="modal-editar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cloase"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Cliente</h4>
            </div>
            <form id="form-editar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nombres <span class="asterisk">*</span> </label>
                                <input type="text" id="nombres" name="nombres" class="form-control" required />
                                <input type="hidden" id="idactualizar">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Apellidos <span class="asterisk">*</span> </label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Telefono</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Razón Social</label>
                                <input type="text" id="razonsocial" name="razonsocial" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nit</label>
                                <input type="text" id="nit" name="nit" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Tipo Documento <span class="asterisk">*</span></label>
                                 <select id="select-editar" name="idtipodocumento" id="tipodocumento" placeholder="Elige un Tipo de Documento">
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
                                <input type="text" name="numerodocumento"  id="numerodocumento" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Dirección </label>
                                <input type="text" id="direccion" name="direccion" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Empresa</label>
                                <input type="text" name="empresa" id="empresa" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Fecha Nacimiento</label>
                                <input type="text" name="fechanacimiento" id="fechanacimiento" class="form-control input-date-picker" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Sexo <span class="asterisk">*</span></label>
                                 <select id="selects-editar" name="sexo" id="sexo" placeholder="Elige un Sexo">
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

<script type="text/javascript" src="js/clientes.js"></script>