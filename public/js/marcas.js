$(document).ready( iniciar );

function iniciar( e )
{	
	$(".w-add").on("click", mostrarModalCrear);
	$("#form-crear").on("submit", crearRegistro);
	$("#form-editar").on("submit", editarRegistro);
	$("#tabla-registros").delegate(".btn-editar", "click", verModalEditar);
	$("#tabla-registros").delegate(".btn-eliminar", "click", eliminarRegistro);

	llenarTabla();

	$('#select-crear').selectize();
	$('#select-editar').selectize();
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
		},
		"columnDefs": [
			{ className: "tc-center", "targets": [0, 1, 2] }
		]
	});	
}

function llenarTabla( e ) 
{
	$.ajax({
		type:'GET',
		url:'ws/marcas',
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
					var acciones;

					acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-editar'><i class='fa fa-pencil-square-o'></i> Editar</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-eliminar'><i class='fa fa-trash-o'></i> Eliminar</a> " +
									"</div>" +
								"</div>";

					$("#tabla-registros").dataTable().fnAddData([
						++xIndex,
						value.nombre,
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
	$.ajax({
		type: 		"POST",
		url: 		"ws/marcas",
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
		url: 		"ws/marcas/"+idreg,
		dataType: 	"json",
		data: 		{},
		success: function ( respuesta )
		{
			if (respuesta.resultado)
			{
				$("#modal-editar").modal("show");
				$("#modal-editar #form-editar #nombre").val(respuesta.registros.nombre);
				$("#modal-editar #form-editar #idactualizar").val(respuesta.registros.id);
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
	var idreg = $("#modal-editar #form-editar #idactualizar").val();
	$.ajax({
		type: 		"PUT",
		url: 		"ws/marcas/"+idreg,
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

function eliminarRegistro( e )
{
	var idreg = $(e.target).closest('a').attr('idreg');

	swal({
		title: "¿Estas seguro?",
		text:  "Eliminaras una Marca",
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
				url:     	"ws/marcas/"+idreg,
				dataType: 	"json",
				data: 		{},
				success: function ( respuesta )
				{
					if( respuesta.resultado )
					{
						swal("Listo!", "La Marca fue eliminada", "success");
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
			swal("Cancelado!", "Ya no se eliminara la Marca", "error");
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


