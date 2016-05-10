$(document).ready( iniciar );

function iniciar( e )
{	
	llenarTabla();
	llenarClientes();
	llenarTarifas();

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
		url:'ws/reservas/ver/anuladas',
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


					if (value.checkin == "0000-00-00 00:00:00")
					{
						acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-anular'><i class='fa fa-thumbs-down'></i> Anular</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-cuenta'><i class='fa fa-calculator'></i> Cuenta</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-checkin'><i class='fa fa-check-square-o'></i> Check In</a> " +
									"</div>" +
								"</div>";
					}
					else
					{
						acciones = "<div class='btn-tollbar' role='toolbar'>" +
									"<div class='btn-group' role='group'>" +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-cuenta'><i class='fa fa-calculator'></i> Cuenta</a> " +
										"<a href='#' idreg='"+value.id+"' class='btn btn-default btn-sm btn-checkout'><i class='fa fa-toggle-up'></i> Check Out</a> " +
									"</div>" +
								"</div>";
					}

					var sexo = (value.sexo == 1 ? "<label class='label label-primary'>Masculino</label>" : "<label class='label label-danger'>Femenino</label>");

					$("#tabla-registros").dataTable().fnAddData([
						++xIndex,
						value.usuario.nombres,
						value.usuarioanulo.nombres,
						value.cliente.nombres + ' ' + value.cliente.apellidos,
						value.habitacion.numero,
						value.entrada,
						value.salida
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


