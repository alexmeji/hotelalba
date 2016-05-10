<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A Components Mix Bootstarp 3 Admin Dashboard Template">
    <meta name="author" content="Westilian">
    <title>Hotel Alba</title>
    <link rel="stylesheet" href="css/font-awesome.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/animate.css" type="text/css">
    <link rel="stylesheet" href="css/waves.css" type="text/css">
    <link rel="stylesheet" href="css/layout.css" type="text/css">
    <link rel="stylesheet" href="css/components.css" type="text/css">
    <link rel="stylesheet" href="css/plugins.css" type="text/css">
    <link rel="stylesheet" href="css/common-styles.css" type="text/css">
    <link rel="stylesheet" href="css/pages.css" type="text/css">
    <link rel="stylesheet" href="css/responsive.css" type="text/css">
    <link rel="stylesheet" href="css/matmix-iconfont.css" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet" type="text/css">
    <style media="screen">
        .tituloalba {
            margin: 0;
            margin-left: 40px;
            padding: 0;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<input type="hidden" id="idtipousuario" value="{{ Session::get('idtipousuario') }}">
<div class="page-container list-menu-view">
<!--Leftbar Start Here -->
<div class="left-aside desktop-view">
    <div class="aside-branding">
        <h1 class="tituloalba">Hotel Alba</h1>
        <span class="aside-pin waves-effect"><i class="fa fa-thumb-tack"></i></span>
        <span class="aside-close waves-effect"><i class="fa fa-times"></i></span>
    </div>
    <div class="left-navigation">
        <ul class="list-accordion">

            @if(Session::get('idtipousuario') == 1)
              <li><a href="#/dashboard"><span class="nav-icon"><i class="fa fa-home"></i></span><span class="nav-label">Dashboard</span></a></li>
              <li><a href="#/usuarios"><span class="nav-icon"><i class="fa fa-user"></i></span><span class="nav-label">Usuarios</span></a></li>
              <li><a href="#/clientes"><span class="nav-icon"><i class="fa fa-group"></i></span><span class="nav-label">Clientes</span></a></li>
              <li><a href="#/cargos"><span class="nav-icon"><i class="fa fa-magic"></i></span><span class="nav-label">Cargos</span></a></li>
              <li><a href="#/correlativos"><span class="nav-icon"><i class="fa fa-barcode"></i></span><span class="nav-label">Correlativos</span></a></li>
              <li><a href="#/tipohabitacion"><span class="nav-icon"><i class="fa fa-cubes"></i></span><span class="nav-label">Tipo Habitación</span></a></li>
              <li><a href="#/habitaciones"><span class="nav-icon"><i class="fa fa-bed"></i></span><span class="nav-label">Habitaciones</span></a></li>
              <li><a href="#/tarifas"><span class="nav-icon"><i class="fa fa-calculator"></i></span><span class="nav-label">Tarifas</span></a></li>
              <li><a href="#/reservas"><span class="nav-icon"><i class="fa fa-calendar"></i></span><span class="nav-label">Reservaciones</span></a></li>
              <li><a href="#/crearreservas"><span class="nav-icon"><i class="fa fa-calendar-o"></i></span><span class="nav-label">Crear Reservaciones</span></a></li>
              <li><a href="#/reservasanuladas"><span class="nav-icon"><i class="fa fa-exclamation-triangle"></i></span><span class="nav-label">Reservaciones Anuladas</span></a></li>
              <!--<li id="cierrecaja-menu"><a href="#/cierrecaja"><span class="nav-icon"><i class="fa fa-usd"></i></span><span class="nav-label">Caja</span></a></li>-->
              <li><a href="#/reportes"><span class="nav-icon"><i class="fa fa-file-pdf-o"></i></span><span class="nav-label">Reportes</span></a></li>
            @else
              <li><a href="#/dashboard"><span class="nav-icon"><i class="fa fa-home"></i></span><span class="nav-label">Dashboard</span></a></li>
              <li><a href="#/clientes"><span class="nav-icon"><i class="fa fa-group"></i></span><span class="nav-label">Clientes</span></a></li>
              <li><a href="#/habitaciones"><span class="nav-icon"><i class="fa fa-bed"></i></span><span class="nav-label">Habitaciones</span></a></li>
              <li><a href="#/reservas"><span class="nav-icon"><i class="fa fa-calendar"></i></span><span class="nav-label">Reservaciones</span></a></li>
              <li><a href="#/crearreservas"><span class="nav-icon"><i class="fa fa-calendar-o"></i></span><span class="nav-label">Crear Reservaciones</span></a></li>
              <!--<li id="cierrecaja-menu"><a href="#/cierrecaja"><span class="nav-icon"><i class="fa fa-usd"></i></span><span class="nav-label">Caja</span></a></li>-->
              <li><a href="#/reportes"><span class="nav-icon"><i class="fa fa-file-pdf-o"></i></span><span class="nav-label">Reportes</span></a></li>
            @endif
        </ul>
    </div>
</div>
<div class="page-content">
<!--Topbar Start Here -->
<header class="top-bar">
    <div class="container-fluid top-nav">
        <div class="row">
            <div class="col-md-2">
                <div class="clearfix top-bar-action">
                    <span class="leftbar-action-mobile waves-effect"><i class="fa fa-bars "></i></span>
                    <span class="leftbar-action desktop waves-effect"><i class="fa fa-bars "></i></span>
                    <span class="waves-effect search-btn mobile-search-btn"><i class="fa fa-search"></i></span>
                    <span class="rightbar-action waves-effect"><i class="fa fa-bars"></i></span>
                </div>
            </div>
            <div class="col-md-4 responsive-fix top-mid">

            </div>
            <div class="col-md-6 responsive-fix">
                <div class="top-aside-right">
                    <div class="user-nav">
                        <ul>
                            <li class="dropdown">
                                <a data-toggle="dropdown" href="#" class="clearfix dropdown-toggle waves-effect waves-block waves-classic">
                                    <span class="user-info"> {!! Session::get('nombres') !!} <cite>( {!! Session::get('tipousuario') !!} )</cite></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <span class="rightbar-action waves-effect cerrar-sesion"><i class="fa fa-remove"></i></span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- MODAL CREAR -->
<div class="modal fade" id="modal-aperturarcaja" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Aperturar Caja</h4>
            </div>
            <form id="form-aperturarcaja">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Efectivo <span class="asterisk">*</span> </label>
                                <input type="text" name="efectivo" id="efectivo" class="form-control" value="0" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn-cerrar-caja" type="button" class="btn btn-danger" data-dismiss="modal">Ver Sistema</button>
                    <button type="button" class="btn btn-danger btn-salir">Salir</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="main-container" id="contenido-dinamico">

</div>
<!--Footer Start Here -->
<footer class="footer-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="footer-left">
                    <span>&copy; 2016</span>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="footer-right">
                    <span class="footer-meta">Creado por&nbsp;<a href="http://alexmejicanos.com" target="_blanc">Alex Mejicanos</a></span>
                </div>
            </div>
        </div>
    </div>

</footer>



<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jRespond.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/nav-accordion.js"></script>
<script src="js/hoverintent.js"></script>
<script src="js/waves.js"></script>
<script src="js/switchery.js"></script>
<script src="js/jquery.loadmask.js"></script>
<script src="js/icheck.js"></script>
<script src="js/select2.js"></script>
<script src="js/bootstrap-filestyle.js"></script>
<script src="js/bootbox.js"></script>
<script src="js/animation.js"></script>
<script src="js/colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/sweetalert.js"></script>
<script src="js/moment.js"></script>
<script src="js/calendar/fullcalendar.js"></script>

<script src="js/jquery.dataTables.js"></script>
<script src="js/dataTables.responsive.js"></script>
<script src="js/dataTables.tableTools.js"></script>
<script src="js/dataTables.bootstrap.js"></script>
<script src="js/stacktable.js"></script>

<script src="js/sammy.js"></script>
<script type="text/javascript">

      $(".cerrar-sesion").on("click", function( e ){
        jQuery.ajax({
          type:     "GET",
          url:      "ws/logout",
          dataType: "json",
          data:     {},
          success: function( respuesta )
          {
            //setTimeout("window.location.href = '../public/'", 700);
            setTimeout("window.location.href = '../'", 700);
          },
          error: function( error )
          {
            nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
          }
        });
      });

      $(".btn-salir").on("click", function( e ){
        jQuery.ajax({
          type:     "GET",
          url:      "ws/logout",
          dataType: "json",
          data:     {},
          success: function( respuesta )
          {
            //setTimeout("window.location.href = '../public/'", 700);
            setTimeout("window.location.href = '../'", 700);
          },
          error: function( error )
          {
            nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
          }
        });
      });

      var ratPack = jQuery.sammy( function( e ){
            this.element_selector = "#contenido-dinamico";

            this.get("#/", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/dashboard", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".dashboard").addClass("active");
            });

            this.get("#/dashboard", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/dashboard", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".dashboard").addClass("active");
            });

            this.get("#/clientes", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/clientes", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".clientes").addClass("active");
            });

            this.get("#/usuarios", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/usuarios", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".usuarios").addClass("active");
            });

            this.get("#/cargos", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/cargos", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".cargos").addClass("active");
            });

            this.get("#/tipohabitacion", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/tipohabitacion", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".tipohabitacion").addClass("active");
            });

            this.get("#/correlativos", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/correlativos", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".correlativos").addClass("active");
            });

            this.get("#/habitaciones", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/habitaciones", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".habitaciones").addClass("active");
            });

            this.get("#/tarifas", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/tarifas", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".tarifas").addClass("active");
            });

            this.get("#/reservas", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/reservas", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".reservas").addClass("active");
            });

            this.get("#/crearreservas", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/crearreservas", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".crearreservas").addClass("active");
            });

            this.get("#/reservasanuladas", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/reservasanuladas", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".reservasanuladas").addClass("active");
            });

            this.get("#/cierrecaja", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/cierrecaja", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".cierrecaja").addClass("active");
            });

            this.get("#/reportes", function( context ){
                  context.app.swap("");
                  context.$element().load("layouts/reportes", function(){});
                  jQuery("#menu").find(".active").removeClass("active");
                  jQuery("#menu").find(".reportes").addClass("active");
            });

            this.notFound = function( context, url ){
                  console.log("URL No Encontrada");
            }
      });

      jQuery( function(){
            ratPack.run("#/");
      });
</script>


<!--CHARTS-->
<script src="js/chart/sparkline/jquery.sparkline.js"></script>
<script src="js/chart/easypie/jquery.easypiechart.min.js"></script>
<script src="js/chart/flot/excanvas.min.js"></script>
<script src="js/chart/flot/jquery.flot.min.js"></script>
<script src="js/chart/flot/curvedLines.js"></script>
<script src="js/chart/flot/jquery.flot.time.min.js"></script>
<script src="js/chart/flot/jquery.flot.stack.min.js"></script>
<script src="js/chart/flot/jquery.flot.axislabels.js"></script>
<script src="js/chart/flot/jquery.flot.resize.min.js"></script>
<script src="js/chart/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/chart/flot/jquery.flot.spline.js"></script>
<script src="js/chart/flot/jquery.flot.pie.min.js"></script>
<script src="js/chart.init.js"></script>
<script src="js/smart-resize.js"></script>
<script src="js/layout.init.js"></script>
<script src="js/matmix.init.js"></script>
<script src="js/retina.min.js"></script>
</body>
</html>
