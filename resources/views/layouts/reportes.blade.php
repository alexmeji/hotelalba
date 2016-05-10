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
                        <h2 class="breadcrumb-titles">Reportes <small>Impresión de Reportes</small></h2>
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
                        <h4>Reporte Cierre Caja Día</h4>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <form>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Inicio</label>
                                            <input type="text" id="inicio-cd" class="form-control input-date-picker" value="{{ date('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Fin</label>
                                            <input type="text" id="fin-cd" class="form-control input-date-picker-fin" value="{{ date('Y-m-d') }}" />
                                        </div>
                                    </div> 
                                    <div class="col-sm-2">
                                        <label class="control-label"></label>
                                        <button type="button" class="btn btn-success btn-block btn-cierrecajadia"> Ver Reporte</button>
                                    </div>  
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix">
                        <span class="h-icon"><i class="fa fa-table"></i></span>
                        <h4>Reporte Habitaciones</h4>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <form>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Fecha</label>
                                            <input type="text" id="inicio-rh" class="form-control input-date-picker" value="{{ date('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label"></label>
                                        <button type="button" class="btn btn-success btn-block btn-reportehabitaciones"> Reporte General</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label"></label>
                                        <button type="button" class="btn btn-info btn-block btn-reporte-encasa"> En Casa</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label"></label>
                                        <button type="button" class="btn btn-primary btn-block btn-reporte-llegadas"> Llegadas</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label"></label>
                                        <button type="button" class="btn btn-defualt btn-block btn-reporte-salidas"> Salidas</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/reportes.js"></script>