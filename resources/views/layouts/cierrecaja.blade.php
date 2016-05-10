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
                        <h2 class="breadcrumb-titles">Caja <small>Administración de Caja al Día</small></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12 right-light-border col-sm-12">
                <div class="box-widget widget-module">
                    <div class="widget-container">
                        <div class=" widget-block">
							<div class="stat-w-wrap ca-center combine-stats">
								<div class="row">
									<div class="col-md-12">
										<span class="stat-w-title">Ingreos Caja</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3 col-sm-3">
										<a href="#" class="ico-cirlce-widget w_bg_green">
											<span><i class="fa fa-money"></i></span>
										</a>
										<div class="w-meta-info">
											<span  id="text-efectivo" class="w-meta-value number-animate" data-animation-duration="1500">3,893</span>
											<span class="w-meta-title">Efectivo</span>
										</div>
									</div>
									<div class="col-md-3 col-sm-3">
										<a href="#" class="ico-cirlce-widget w_bg_blue">
											<span><i class="fa fa-cc-visa"></i></span>
										</a>
										<div class="w-meta-info">
											<span id="text-tcredito" class="w-meta-value number-animate" data-animation-duration="1500">2,100</span>
											<span class="w-meta-title">Tarjeta Credito</span>
										</div>
									</div>
									<div class="col-md-3 col-sm-3">
										<a href="#" class="ico-cirlce-widget w_bg_grey">
											<span><i class="fa fa-credit-card"></i></span>
										</a>
										<div class="w-meta-info">
											<span id="text-tdebito" class="w-meta-value number-animate" data-animation-duration="1500">2,100</span>
											<span class="w-meta-title">Tarjeta Debito</span>
										</div>
									</div>
									<div class="col-md-3 col-sm-3">
										<a href="#" class="ico-cirlce-widget w_bg_brown">
											<span><i class="ico-certificate"></i></span>
										</a>
										<div class="w-meta-info">
											<span id="text-cheque" class="w-meta-value number-animate" data-animation-duration="1500">2,100</span>
											<span class="w-meta-title">Cheque</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="w-meta-info">
											<span id="text-sumatoria" class="w-previos-stat">Sumatoria Ingresos: $3,510</span>
											<div class="row">
												<div class="col-md-5"></div>
												<div class="col-md-2">
													<a href="#" class="btn btn-success btn-cierre-caja">Cerrar Caja</a>	
												</div>
												<div class="col-md-5"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						
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
                        <h4>Lista Abonos</h4>
                        <ul class="widget-action-bar pull-right">
                            <li><span class="waves-effect w-reload"><i class="fa fa-spinner"></i></span></li>
                        </ul>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <table id="tabla-abonos" class="table mb30">
                                <thead>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th>Efectivo</th>
                                    <th>Tarjeta Credito</th>
                                    <th>Tarjeta Debito</th>
                                    <th>Cheque</th>
                                    <th>Num Cheque</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
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
                        <h4>Lista Pagos</h4>
                        <ul class="widget-action-bar pull-right">
                            <li><span class="waves-effect w-reload"><i class="fa fa-spinner"></i></span></li>
                        </ul>
                    </div>
                    <div class="widget-container">
                        <div class=" widget-block">
                            <table id="tabla-pagos" class="table mb30">
                                <thead>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th>Efectivo</th>
                                    <th>Tarjeta Credito</th>
                                    <th>Tarjeta Debito</th>
                                    <th>Cheque</th>
                                    <th>Num Cheque</th>
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
<div class="modal fade" id="modal-cierrecaja" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cloase"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cierre Caja</h4>
            </div>
            <form id="form-cierrecaja">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Efectivo <span class="asterisk">*</span> </label>
                                <input type="text" name="efectivo" class="form-control" value="0" />
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

<script type="text/javascript" src="js/cierrecaja.js"></script>