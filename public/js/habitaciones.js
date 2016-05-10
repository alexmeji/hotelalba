$(document).ready( iniciar );

function iniciar( e )
{	
	$(".w-add").on("click", mostrarModalCrear);
	$("#form-crear").on("submit", crearRegistro);
	$("#form-editar").on("submit", editarRegistro);
	$("#tabla-registros").delegate(".btn-editar", "click", verModalEditar);
	$("#tabla-registros").delegate(".btn-eliminar", "click", eliminarRegistro);
	$("#tabla-registros").delegate(".btn-limpieza", "click", quitarLimpieza);

	llenarTabla();

	$('#select-crear').selectize();
	$('#select-editar').selectize();
	
	$('.i-min-check').iCheck({
        checkboxClass: 'icheckbox_minimal-green',
        radioClass: 'iradio_minimal',
        increaseArea: '30%' // optional
    });


	/****** CONFIGURACION DE LA TABLA ***********/
	$('#tabla-registros').DataTable(
	{
		responsive: true,
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ filas",
		  	"sSearch": "",
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
		  			"sFirst":    "Primero",
		  			"sLast":     "Último",
		  			"sNext":     "Siguiente",
		  			"sPrevious": "Anterior"
				}
		}
	});	
}

function llenarTabla( e ) 
{
	$.ajax({
		type:'GET',
		url:'ws/habitaciones',
		dataType:'json',
		data:{},
		success:function( respuesta )
		{
			if ( respuesta.resultado )
			{
				//nGen('success', 'fa fa-check-circle', 'Exito..!', resultado.mensaje, 'topRight');
				$("#tabla-registros").dataTable().fnClearTable();

				var xIndex = 0;
				$.each( respuesta.registros, function(index, value){
					var acciones = "";


					if (parseInt($("#idtipousuario").val()) == 1)
					{
						if(value.limpieza == 1)
						{
							acciones = "<div class='btn-tollbar' role='toolbar'>" +
											"<div class='btn-group' role='group'>" +
												"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-editar'><i class='fa fa-pencil-square-o'></i> Editar</a> " +
												"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-eliminar'><i class='fa fa-trash-o'></i> Eliminar</a> " +
												"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-limpieza'><i class='fa fa-paint-brush'></i>Quitar Limpieza</a> " +
											"</div>" +
										"</div>";
						}
						else
						{
							acciones = "<div class='btn-tollbar' role='toolbar'>" +
										"<div class='btn-group' role='group'>" +
											"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-editar'><i class='fa fa-pencil-square-o'></i> Editar</a> " +
											"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-eliminar'><i class='fa fa-trash-o'></i> Eliminar</a> " +
										"</div>" +
									"</div>";
						}
					}
					else
					{
						if (value.limpieza == 1)
						{
							acciones = "<div class='btn-tollbar' role='toolbar'>" +
											"<div class='btn-group' role='group'>" +
												"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-limpieza'><i class='fa fa-paint-brush'></i>Quitar Limpieza</a> " +
											"</div>" +
										"</div>";
						}
					}


					var tv = (value.television == 1 ? "<label class='label label-primary'>Si</label>" : "<label class='label label-danger'>No</label>");
					var ac = (value.ac == 1 ? "<label class='label label-primary'>Si</label>" : "<label class='label label-danger'>No</label>");
					var caja = (value.cajafuerte == 1 ? "<label class='label label-primary'>Si</label>" : "<label class='label label-danger'>No</label>");

					$("#tabla-registros").dataTable().fnAddData([
						++xIndex,
						value.numero,
						value.numcamas,
						value.tipohabitacion.nombre,
						tv,
						ac,
						caja,
						acciones
					]);
				});
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje, 'topRight');
			}
		},
		error: function( error )
		{
			console.log(error);
		}
	});
	

	if ( e != null )
		e.preventDefault();
}

function mostrarModalCrear( e )
{
	$("#modal-crear").modal('show');

	if ( e != null )
		e.preventDefault();
}

function crearRegistro( e )
{
	console.log($(this).serialize());
	$.ajax({
		type: 		"POST",
		url: 		"ws/habitaciones",
		dataType: 	"json",
		data: 		$(this).serialize(),
		success: function( respuesta )
		{
			if (respuesta.resultado )
			{
				nGen('success', 'fa fa-check-circle', 'Exito..!', respuesta.mensaje, 'topRight');
				$("#modal-crear").modal("hide");
				setTimeout( function(){ ratPack.refresh(); }, 300 );
			}
			else
			{
				console.log(respuesta);
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje , 'topRight');		
			}
		},
		error: function( error )
		{
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});

	if ( e != null )
		e.preventDefault();
		e.stopPropagation();
}

function verModalEditar( e )
{
	var idreg = $(e.target).closest("a").attr("idreg");
	$.ajax({
		type: 		"GET",
		url: 		"ws/habitaciones/"+idreg,
		dataType: 	"json",
		data: 		{},
		success: function ( respuesta )
		{
			if (respuesta.resultado)
			{
				$("#modal-editar").modal("show");
				$("#modal-editar #form-editar #numero").val(respuesta.registros.numero);
				$("#modal-editar #form-editar #numcamas").val(respuesta.registros.numcamas);
				$("#modal-editar #form-editar #idactualizar").val(respuesta.registros.id);
				$("#modal-editar #form-editar #torre").val(respuesta.registros.torre);
				$("#modal-editar #form-editar #nivel").val(respuesta.registros.nivel);

				if (respuesta.registros.television === 1)
					$("#modal-editar #form-editar #television").iCheck('check');
				else
					$("#modal-editar #form-editar #television").iCheck('uncheck');

				if (respuesta.registros.ac === 1)
					$("#modal-editar #form-editar #ac").iCheck('check');
				else
					$("#modal-editar #form-editar #ac").iCheck('uncheck');
				
				if (respuesta.registros.cajafuerte === 1)
					$("#modal-editar #form-editar #cajafuerte").iCheck('check');
				else
					$("#modal-editar #form-editar #cajafuerte").iCheck('uncheck');

				var select = $("#form-editar #select-editar").selectize();
				var selectize = select[0].selectize; 
				selectize.setValue(respuesta.registros.idtipohabitacion);
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje , 'topRight');		
			}
		},
		error: function ( error )
		{
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});

	if ( e != null)
		e.preventDefault();
}

function editarRegistro( e )
{
	console.log($(this).serialize());
	var idreg = $("#modal-editar #form-editar #idactualizar").val();
	$.ajax({
		type: 		"PUT",
		url: 		"ws/habitaciones/"+idreg,
		dataType: 	"json",
		data: 		$(this).serialize(),
		success: function( respuesta )
		{
			if (respuesta.resultado )
			{
				nGen('success', 'fa fa-check-circle', 'Exito..!', respuesta.mensaje, 'topRight');
				$("#modal-editar").modal("hide");
				setTimeout( function(){ ratPack.refresh(); }, 300 );
			}
			else
			{
				nGen('warning', 'fa fa-times-circle', 'Espera..!', respuesta.mensaje , 'topRight');		
			}
		},
		error: function( error )
		{
			nGen('warning', 'fa fa-times-circle', 'Espera..!', error, 'topRight');
		}
	});

	if ( e != null )
		e.preventDefault();
		e.stopPropagation();
}

function quitarLimpieza( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Pasaras la habitacion a Lista",
		type:  "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmbuttonText: "Si, pasarla a Lista",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: false

	}, function ( isConfirm ) {
		if ( isConfirm )
		{
			$.ajax({
				type:    	"GET",
				url:     	"ws/habitaciones/estado/limpieza/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "La habitacion paso a estar lista", "success");
						setTimeout( function(){ ratPack.refresh(); }, 300 );
					}
					else
					{
						console.log(respuesta);
						swal("Cancelado!", "Ocurrio un error al intentar pasar la habitacion a Lista", "error");
					}
				}, 
				error: function ( error )
				{
					console.log(error);
					swal("Cancelado!", "Ocurrio un error al intentar pasar la habitacion a Lista", "error");
				}
			});
		}
		else
		{
			swal("Cancelado!", "Ya no se paso la habitacion a Lista", "error");
		}
	});

	if ( e != null)
		e.preventDefault();
}

function eliminarRegistro( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Eliminaras al Cliente",
		type:  "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmbuttonText: "Si, eliminarla",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: false

	}, function ( isConfirm ) {
		if ( isConfirm )
		{
			$.ajax({
				type:    	"DELETE",
				url:     	"ws/habitaciones/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "El Cliente fue eliminado", "success");
						setTimeout( function(){ ratPack.refresh(); }, 300 );
					}
					else
					{
						swal("Cancelado!", "Ocurrio un error al intentar eliminar", "error");
					}
				}, 
				error: function ( error )
				{
					swal("Cancelado!", "Ocurrio un error al intentar eliminar", "error");
				}
			});
		}
		else
		{
			swal("Cancelado!", "Ya no se eliminara el Cliente", "error");
		}
	});

	if ( e != null)
		e.preventDefault();
}

function nGen(type, icono, titulo, text, layout)
{
	var n = noty({
		text: "<div class='activity-item'> <i class='"+icono+"' + 'text-alert'></i> <div class='activity'> <span>"+titulo+"</span> <span> "+text+" </span> </div> </div> ",
		type: type,
		timeout: 3000,
		dismissQueue: true,
        layout: layout,
        closeWith: ['click'],
        theme: 'MatMixNoty',
        maxVisible: 10,
		animation: {
            open: 'noty_animated bounceInRight',
            close: 'noty_animated bounceOutRight',
            easing: 'swing',
            speed: 500
        }
	});
}

var ThisLoad;
$(".w-reload").click( function(){
	ThisLoad = $(this);
	$(this).parents(".widget-head")
		.next(".widget-container").mask("Cargando..");
	setTimeout(UnMask, 1500);
});

function UnMask() {
	ThisLoad.parents(".widget-head")
		.next(".widget-container").unmask();
}


