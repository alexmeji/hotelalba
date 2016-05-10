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
                        <h2 class="breadcrumb-titles">Correlativos <small>Administracion de Correlativos</small></h2>
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
                        <h4>Lista Correlativos</h4>
                        <ul class="widget-action-bar pull-right">
                            <li><span class="waves-effect w-reload"><i class="fa fa-spinner"></i></span></li>
                        </ul>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <table id="tabla-registros" class="table mb30">
                                <thead>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Numero</th>
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

<!-- MODAL EDTAR -->
<div class="modal fade" id="modal-editar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cloase"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Correlativo</h4>
            </div>
            <form id="form-editar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nombre <span class="asterisk">*</span> </label>
                                <input type="text" id="nombre" name="nombre" class="form-control" readonly />
                                <input type="hidden" id="idactualizar">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Numero <span class="asterisk">*</span> </label>
                                <input type="text" id="numero" name="numero" class="form-control" required />
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

<script type="text/javascript" src="js/correlativos.js"></script>